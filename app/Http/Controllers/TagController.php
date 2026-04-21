<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::withCount('posts')->latest()->paginate(12);
        return view('tags.index', compact('tags'));
    }

    public function create()
    {
        return view('tags.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255|unique:tags,name',
            'description'    => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480', //
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('tags', 'public');
        }

        Tag::create($validated);

        return redirect()->route('tags.index')->with('success', 'Tạo thẻ thành công!');
    }

    public function edit(Tag $tag)
    {
        return view('tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255|unique:tags,name,' . $tag->id,
            'description'    => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480', //
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('tags', 'public');
        }

        $tag->update($validated);

        return redirect()->route('tags.index')->with('success', 'Cập nhật thẻ thành công!');
    }

    public function destroy(Tag $tag)
    {
        // Xóa liên kết trong bảng trung gian (post_tag) trước khi xóa thẻ
        $tag->posts()->detach();
        $tag->delete();

        return redirect()->route('tags.index')->with('success', 'Thẻ đã được xóa!');
    }

    public function show(Tag $tag)
    {
        // Lấy các bài viết có gắn thẻ này, phân trang 12 bài / trang
        $posts = $tag->posts()
                     ->where('is_published', true)
                     ->latest()
                     ->paginate(12);
        return view('tags.show', compact('tag', 'posts'));
    }
}
