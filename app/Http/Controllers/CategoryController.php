<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
use Spatie\SchemaOrg\Schema;

class CategoryController extends Controller
{
    public function index()
    {
        // Xóa phân trang để hiển thị toàn bộ danh sách khi kéo thả
        $categories = Category::withCount('posts')->orderBy('order', 'asc')->get();
        return view('categories.index', compact('categories'));
    }

    // Thêm method xử lý kéo thả
    public function updateOrder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'exists:categories,id',
        ]);

        foreach ($request->order as $index => $id) {
            Category::where('id', $id)->update(['order' => $index]);
        }

        return response()->json(['status' => 'success']);
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
            'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,webp,heic|max:20480', //
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
            'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,webp,heic|max:20480', //
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

    public function show(Request $request, Category $category)
    {
        App::setLocale('vi');
        $query = $category->posts()->where('is_published', true);

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
            case 'views_desc': // Lượt xem giảm dần
                $query->orderBy('views', 'desc');
                break;
            case 'views_asc': // Lượt xem tăng dần
                $query->orderBy('views', 'asc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $posts = $query->paginate(12)->withQueryString();

// SEO: Build the CollectionPage & ItemList Schema
        $itemListElements = [];

        foreach ($posts as $index => $post) {
            $itemListElements[] = Schema::listItem()
                ->position($index + 1)
                ->url(route('posts.show', $post->slug))
                ->name($post->title);
        }

        $categorySchema = Schema::collectionPage()
            ->name($category->name)
            ->description($category->description ?? 'Tuyển tập các bài viết thuộc chuyên mục ' . $category->name . ' trên Cộng Đồng Cờ Tướng.')
            ->url(url()->current()) // Better canonical URL for paginated states
            ->mainEntity(
                Schema::itemList()->itemListElement($itemListElements)
            );

        if ($category->featured_image) {
            $categorySchema->image(asset('storage/' . $category->featured_image));
        }

        // SEO: Build Breadcrumb Schema for the Collection Page
        $breadcrumbSchema = Schema::breadcrumbList()
            ->itemListElement([
                Schema::listItem()->position(1)->name('Trang chủ')->item(route('home')),
                Schema::listItem()->position(2)->name($category->name)->item(route('categories.show', $category->slug))
            ]);

        // Note: You will need to render {!! $breadcrumbSchema->toScript() !!} in your categories.show blade file
        return view('categories.show', compact('category', 'posts', 'categorySchema', 'breadcrumbSchema'));
    }
}
