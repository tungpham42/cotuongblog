<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        // Kèm theo số lượng bài viết của mỗi chuyên mục
        $categories = Category::withCount('posts')->latest()->paginate(12);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255|unique:categories,name',
            'description'    => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480', //
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('categories', 'public');
        }

        Category::create($validated);

        return redirect()->route('categories.index')->with('success', 'Tạo chuyên mục thành công!');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description'    => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480', //
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('featured_image')) {
            // Optional: Delete old image here if using Storage::delete()
            $validated['featured_image'] = $request->file('featured_image')->store('categories', 'public');
        }

        $category->update($validated);

        return redirect()->route('categories.index')->with('success', 'Cập nhật chuyên mục thành công!');
    }

    public function destroy(Category $category)
    {
        // Có thể thêm logic kiểm tra xem category có post nào không trước khi xóa
        if ($category->posts()->count() > 0) {
            return redirect()->route('categories.index')->with('error', 'Không thể xóa chuyên mục đang có bài viết!');
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Chuyên mục đã được xóa!');
    }

    public function show(Category $category)
    {
        // Lấy các bài viết thuộc chuyên mục, phân trang 12 bài / trang
        $posts = $category->posts()
                          ->where('is_published', true)
                          ->latest()
                          ->paginate(12);
        return view('categories.show', compact('category', 'posts'));
    }
}
