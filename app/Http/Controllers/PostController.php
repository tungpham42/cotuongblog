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
        // Eager load relationships để tránh N+1 Query
        $posts = Post::with(['category', 'author', 'tags'])->latest()->paginate(12);
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
        // Generate the slug and merge it into the request before validation
        $request->merge([
            'slug' => Str::slug($request->title)
        ]);

        $validated = $request->validate([
            'title' => 'required|max:255|unique:posts,title',
            'slug' => 'required|unique:posts,slug',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required',
            'featured_image' => 'nullable|image|max:20480', // Max 20MB
            'tags' => 'array|exists:tags,id',
        ], [
            // Custom error messages
            'title.unique' => 'Tiêu đề bài viết này đã tồn tại. Vui lòng chọn một tiêu đề khác.',
            'slug.unique' => 'Đường dẫn (slug) được tạo từ tiêu đề này đã bị trùng lặp.'
        ]);

        $validated['user_id'] = auth()->id(); // Gán user hiện tại đang đăng nhập
        $validated['is_published'] = $request->has('is_published');

        // Xử lý upload ảnh
        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('posts', 'public');
            $validated['featured_image'] = $path;
        }

        $post = Post::create($validated);

        // Sync Tags (Bảng trung gian)
        if ($request->has('tags')) {
            $post->tags()->sync($request->tags);
        }

        return redirect()->route('posts.index')->with('success', 'Tạo bài viết thành công!');
    }

    public function edit(Post $post)
    {
        $categories = Category::withCount('posts')->get();
        $tags = Tag::withCount('posts')->get();
        return view('posts.edit', compact('post', 'categories', 'tags'));
    }

    public function update(Request $request, Post $post)
    {
        // Generate the slug and merge it into the request before validation
        $request->merge([
            'slug' => Str::slug($request->title)
        ]);

        $validated = $request->validate([
            // Ignore the current post's ID in the unique check
            'title' => 'required|max:255|unique:posts,title,' . $post->id,
            'slug' => 'required|unique:posts,slug,' . $post->id,
            'category_id' => 'required|exists:categories,id',
            'content' => 'required',
            'featured_image' => 'nullable|image|max:20480',
            'tags' => 'array|exists:tags,id',
        ], [
            // Custom error messages
            'title.unique' => 'Tiêu đề bài viết này đã tồn tại. Vui lòng chọn một tiêu đề khác.',
            'slug.unique' => 'Đường dẫn (slug) được tạo từ tiêu đề này đã bị trùng lặp.'
        ]);

        $validated['is_published'] = $request->has('is_published');

        // Xử lý thay đổi ảnh đại diện
        if ($request->hasFile('featured_image')) {
            // Xóa ảnh cũ nếu có
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            // Lưu ảnh mới
            $validated['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        }

        $post->update($validated);

        // Cập nhật Tags
        if ($request->has('tags')) {
            $post->tags()->sync($request->tags);
        } else {
            $post->tags()->detach(); // Xóa hết tag nếu user bỏ chọn tất cả
        }

        return redirect()->route('posts.index')->with('success', 'Cập nhật bài viết thành công!');
    }

    public function destroy(Post $post)
    {
        // Xóa ảnh vật lý trên server
        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Bài viết đã được xóa!');
    }

    public function show(Post $post)
    {
        $post->load(['author', 'category', 'tags', 'comments.user']);
        return view('posts.show', compact('post'));
    }

    public function uploadImage(Request $request)
    {
        // Validate file upload
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // Max 5MB
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // Tạo tên file ngẫu nhiên để tránh trùng lặp
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Lưu file vào thư mục storage/app/public/uploads/posts
            $path = $file->storeAs('uploads/posts', $filename, 'public');

            // JavaScript fetch fetch hook ở Frontend sẽ expect một JSON key là 'location'
            return response()->json([
                'location' => asset('storage/' . $path)
            ]);
        }

        return response()->json(['error' => 'Không thể tải ảnh lên.'], 400);
    }

    /**
     * Get all published posts as JSON (Title and Content only)
     */
    public function apiIndex(Request $request)
    {
        $converter = new CommonMarkConverter([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);

        // Only fetch published posts without unnecessary relationships
        $posts = Post::where('is_published', true)
                    ->latest()
                    ->get();

        // Map the collection to return only title and processed content
        $formattedPosts = $posts->map(function ($post) use ($converter) {
            // 1. Convert Markdown to HTML
            $html = $converter->convert($post->content)->getContent();

            // 2. Clean the content (remove tags and collapse whitespace)
            $content = str_replace(['</p>', '<br>', '</div>'], ' ', $html);
            $content = strip_tags($content);
            $content = preg_replace('/\s+/', ' ', $content);
            $content = trim($content);

            // Return only the desired fields
            return [
                'title' => $post->title,
                'slug' => $post->slug,
                'content' => $content,
            ];
        });

        // Return JSON with readable characters
        return response()->json($formattedPosts, 200, [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
