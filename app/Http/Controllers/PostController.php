<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        // Eager load relationships để tránh N+1 Query
        $posts = Post::with(['category', 'author', 'tags'])->latest()->paginate(10);
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('posts.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required',
            'featured_image' => 'nullable|image|max:2048', // Max 2MB
            'tags' => 'array|exists:tags,id',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
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
        $categories = Category::all();
        $tags = Tag::all();
        return view('posts.edit', compact('post', 'categories', 'tags'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required',
            'featured_image' => 'nullable|image|max:2048',
            'tags' => 'array|exists:tags,id',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
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
}
