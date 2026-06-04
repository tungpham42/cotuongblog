<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\App;

class ProductController extends Controller
{
    // ==========================================
    // PUBLIC ROUTES
    // ==========================================
    public function index(Request $request)
    {
        App::setLocale('vi');
        $query = Product::where('is_published', true);

        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $sort = $request->input('sort', 'latest');
        switch ($sort) {
            case 'price_asc': $query->orderBy('price', 'asc'); break;
            case 'price_desc': $query->orderBy('price', 'desc'); break;
            case 'oldest': $query->oldest(); break;
            case 'latest': default: $query->latest(); break;
        }

        $products = $query->paginate(12)->withQueryString();
        return view('products.index', compact('products'));
    }

    public function show(Product $product)
    {
        // Tăng view nếu có trường views (tùy chọn)
        // $product->increment('views');
        return view('products.show', compact('product'));
    }

    // ==========================================
    // ADMIN / AUTHENTICATED ROUTES
    // ==========================================
    public function adminIndex(Request $request)
    {
        $query = Product::with('user');

        // Nếu không phải admin, chỉ thấy sản phẩm của mình
        if (!auth()->user()->is_admin) {
            $query->where('user_id', auth()->id());
        }

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->paginate(12)->withQueryString();
        return view('products.admin_index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->merge(['slug' => Str::slug($request->name)]);

        $validated = $request->validate([
            'name' => 'required|max:255|unique:products,name',
            'slug' => 'required|unique:products,slug',
            'price' => 'required|numeric|min:0',
            'zalo_number' => 'nullable|string|max:20',
            'description' => 'required',
            'video_url' => 'nullable|url',
            'gallery' => 'nullable|array|max:12',
            'gallery.*' => 'image|max:51200',
        ]);

        $validated['user_id'] = auth()->id();

        // Chỉ admin mới có quyền xuất bản ngay lập tức
        if (auth()->user()->is_admin) {
            $validated['is_published'] = $request->boolean('is_published');
        } else {
            $validated['is_published'] = false; // Chờ duyệt
        }

        // Xử lý Gallery ảnh
        $galleryPaths = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $galleryPaths[] = $image->store('products', 'public');
            }
        }
        $validated['gallery'] = $galleryPaths;

        Product::create($validated);

        $message = auth()->user()->is_admin ? 'Thêm sản phẩm thành công!' : 'Thêm sản phẩm thành công! Vui lòng chờ admin duyệt.';
        return redirect()->route('admin.products.index')->with('success', $message);
    }

    public function edit(Product $product)
    {
        abort_if(!auth()->user()->is_admin && $product->user_id !== auth()->id(), 403);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        abort_if(!auth()->user()->is_admin && $product->user_id !== auth()->id(), 403);

        $request->merge(['slug' => Str::slug($request->name)]);

        $validated = $request->validate([
            'name' => 'required|max:255|unique:products,name,' . $product->id,
            'slug' => 'required|unique:products,slug,' . $product->id,
            'price' => 'required|numeric|min:0',
            'zalo_number' => 'nullable|string|max:20',
            'description' => 'required',
            'video_url' => 'nullable|url',
            'gallery' => 'nullable|array|max:12',
            'gallery.*' => 'image|max:51200',
        ]);

        if (auth()->user()->is_admin) {
            $validated['is_published'] = $request->boolean('is_published');
        } else {
            $validated['is_published'] = false;
        }

        $galleryPaths = $product->gallery ?? [];

        // Nếu có upload file mới, thay thế gallery cũ (hoặc bạn có thể code thêm logic giữ ảnh cũ)
        if ($request->hasFile('gallery')) {
            if (!empty($product->gallery)) {
                foreach ($product->gallery as $oldImg) {
                    Storage::disk('public')->delete($oldImg);
                }
            }
            $galleryPaths = [];
            foreach ($request->file('gallery') as $image) {
                $galleryPaths[] = $image->store('products', 'public');
            }
        }
        $validated['gallery'] = $galleryPaths;

        $product->update($validated);

        $message = auth()->user()->is_admin ? 'Cập nhật sản phẩm thành công!' : 'Đã cập nhật. Chờ admin duyệt lại.';
        return redirect()->route('admin.products.index')->with('success', $message);
    }

    public function destroy(Product $product)
    {
        abort_if(!auth()->user()->is_admin && $product->user_id !== auth()->id(), 403);

        if (!empty($product->gallery)) {
            foreach ($product->gallery as $img) {
                Storage::disk('public')->delete($img);
            }
        }
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Đã xóa sản phẩm!');
    }
}
