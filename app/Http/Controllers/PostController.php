<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use League\CommonMark\CommonMarkConverter;

class PostController extends Controller
{
    public function index()
    {
        $query = Post::with(['category', 'author', 'tags'])->latest();

        // Nếu không phải admin, chỉ hiển thị bài viết của chính họ
        if (!auth()->user()->is_admin) {
            $query->where('user_id', auth()->id());
        }

        $posts = $query->paginate(12);
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::withCount('posts')->get();
        $tags = Tag::withCount('posts')->get();
        return view('posts.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $request->merge(['slug' => Str::slug($request->title)]);

        $validated = $request->validate([
            'title' => 'required|max:255|unique:posts,title',
            'slug' => 'required|unique:posts,slug',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required',
            'featured_image' => 'nullable|image|max:20480',
            'tags' => 'array|exists:tags,id',
        ], [
            'title.unique' => 'Tiêu đề bài viết này đã tồn tại. Vui lòng chọn một tiêu đề khác.',
            'slug.unique' => 'Đường dẫn (slug) được tạo từ tiêu đề này đã bị trùng lặp.'
        ]);

        $validated['user_id'] = auth()->id();

        // Chỉ admin mới có quyền xuất bản ngay lập tức
        if (auth()->user()->is_admin) {
            $validated['is_published'] = $request->has('is_published');
        } else {
            $validated['is_published'] = false; // Luôn là false để chờ duyệt
        }

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('posts', 'public');
            $validated['featured_image'] = $path;
        }

        $post = Post::create($validated);

        if ($request->has('tags')) {
            $post->tags()->sync($request->tags);
        }

        $message = auth()->user()->is_admin ? 'Tạo bài viết thành công!' : 'Tạo bài viết thành công! Vui lòng chờ admin duyệt.';
        return redirect()->route('posts.index')->with('success', $message);
    }

    public function edit(Post $post)
    {
        // Phân quyền: User thường không được sửa bài của người khác
        abort_if(!auth()->user()->is_admin && $post->user_id !== auth()->id(), 403);

        $categories = Category::withCount('posts')->get();
        $tags = Tag::withCount('posts')->get();
        return view('posts.edit', compact('post', 'categories', 'tags'));
    }

    public function update(Request $request, Post $post)
    {
        abort_if(!auth()->user()->is_admin && $post->user_id !== auth()->id(), 403);

        $request->merge(['slug' => Str::slug($request->title)]);

        $validated = $request->validate([
            'title' => 'required|max:255|unique:posts,title,' . $post->id,
            'slug' => 'required|unique:posts,slug,' . $post->id,
            'category_id' => 'required|exists:categories,id',
            'content' => 'required',
            'featured_image' => 'nullable|image|max:20480',
            'tags' => 'array|exists:tags,id',
        ], [
            'title.unique' => 'Tiêu đề bài viết này đã tồn tại. Vui lòng chọn một tiêu đề khác.',
            'slug.unique' => 'Đường dẫn (slug) được tạo từ tiêu đề này đã bị trùng lặp.'
        ]);

        // Nếu user thường sửa bài, trạng thái sẽ bị đưa về chờ duyệt
        if (auth()->user()->is_admin) {
            $validated['is_published'] = $request->has('is_published');
        } else {
            $validated['is_published'] = false;
        }

        if ($request->hasFile('featured_image')) {
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        }

        $post->update($validated);

        if ($request->has('tags')) {
            $post->tags()->sync($request->tags);
        } else {
            $post->tags()->detach();
        }

        $message = auth()->user()->is_admin ? 'Cập nhật bài viết thành công!' : 'Đã cập nhật bài viết. Chờ admin duyệt lại.';
        return redirect()->route('posts.index')->with('success', $message);
    }

    public function destroy(Post $post)
    {
        abort_if(!auth()->user()->is_admin && $post->user_id !== auth()->id(), 403);

        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Bài viết đã được xóa!');
    }

    // Method mới cho Admin duyệt bài
    public function approve(Post $post)
    {
        $post->update(['is_published' => true]);
        return back()->with('success', 'Đã duyệt và xuất bản bài viết!');
    }

    public function show(Post $post)
    {
        $post->load(['author', 'category', 'tags', 'comments.user']);
        $post->increment('views');

        $relatedPosts = Post::where('category_id', $post->category_id)
                            ->where('id', '!=', $post->id)
                            ->where('is_published', true)
                            ->latest()
                            ->take(4)
                            ->get();

        return view('posts.show', compact('post', 'relatedPosts'));
    }

    public function uploadImage(Request $request)
    {
        $request->validate(['file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120']);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('uploads/posts', $filename, 'public');
            return response()->json(['location' => asset('storage/' . $path)]);
        }

        return response()->json(['error' => 'Không thể tải ảnh lên.'], 400);
    }

    public function apiIndex(Request $request)
    {
        $converter = new CommonMarkConverter([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);

        $posts = Post::where('is_published', true)->latest()->get();

        $formattedPosts = $posts->map(function ($post) use ($converter) {
            $html = $converter->convert($post->content)->getContent();
            $content = str_replace(['</p>', '<br>', '</div>'], ' ', $html);
            $content = strip_tags($content);
            $content = preg_replace('/\s+/', ' ', $content);
            $content = trim($content);

            return [
                'title' => $post->title,
                'slug' => $post->slug,
                'content' => $content,
            ];
        });

        return response()->json($formattedPosts, 200, [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
