<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index()
    {
        // Xóa phân trang, sắp xếp theo order
        $tags = Tag::withCount('posts')->orderBy('order', 'asc')->get();
        return view('tags.index', compact('tags'));
    }

    // Thêm method xử lý kéo thả
    public function updateOrder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'exists:tags,id',
        ]);

        foreach ($request->order as $index => $id) {
            Tag::where('id', $id)->update(['order' => $index]);
        }

        return response()->json(['status' => 'success']);
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

    public function show(Request $request, Tag $tag)
    {
        // Bắt đầu query các bài viết thuộc tag này
        $query = $tag->posts()->where('is_published', true);

        // Xử lý Tìm kiếm
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        // Xử lý Sắp xếp
        $sort = $request->input('sort', 'latest');
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'alpha_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'alpha_desc':
                $query->orderBy('title', 'desc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        // Phân trang và giữ nguyên query string trên URL
        $posts = $query->paginate(12)->withQueryString();

        return view('tags.show', compact('tag', 'posts'));
    }
}
