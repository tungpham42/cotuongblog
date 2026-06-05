<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\App;
use Spatie\SchemaOrg\Schema;
use Maestroerror\HeicToJpg;

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
        $product->increment('views');
        $description = Str::limit(strip_tags(Str::markdown($product->description ?? '')), 160);

        $productSchema = Schema::product()
            ->name($product->name)
            ->description($description)
            ->url(route('products.show', $product->slug))
            ->sku((string) $product->id)
            ->brand(Schema::brand()->name('Cộng Đồng Cờ Tướng Việt Nam'))
            ->offers(
                Schema::offer()
                    ->price($product->price)
                    ->priceCurrency('VND')
                    ->url(route('products.show', $product->slug))
            );

        if (!empty($product->gallery) && count($product->gallery) > 0) {
            $productSchema->image(asset('storage/' . $product->gallery[0]));
        }

        $breadcrumbSchema = Schema::breadcrumbList()->itemListElement([
            Schema::listItem()->position(1)->name('Trang chủ')->item(route('home')),
            Schema::listItem()->position(2)->name('Cửa hàng')->item(route('products.index')),
            Schema::listItem()->position(3)->name($product->name)->item(route('products.show', $product->slug)),
        ]);

        return view('products.show', compact('product', 'productSchema', 'breadcrumbSchema'));
    }

    // ==========================================
    // ADMIN / AUTHENTICATED ROUTES
    // ==========================================
    public function adminIndex(Request $request)
    {
        $query = Product::with('user');

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
            'gallery.*' => 'file|mimes:jpeg,png,jpg,gif,webp,heic,heif|max:512000',
        ]);

        $validated['user_id'] = auth()->id();

        if (auth()->user()->is_admin) {
            $validated['is_published'] = $request->boolean('is_published');
        } else {
            $validated['is_published'] = false;
        }

        $galleryPaths = [];
        if ($request->hasFile('gallery')) {
            // Duyệt theo thứ tự mảng đã được AlpineJS reorder trên Frontend
            foreach ($request->file('gallery') as $image) {
                $ext = strtolower($image->getClientOriginalExtension());

                if (in_array($ext, ['heic', 'heif'])) {
                    $jpgContent = HeicToJpg::convert($image->getRealPath())->get();
                    $filename = 'products/' . Str::random(40) . '.jpg';
                    Storage::disk('public')->put($filename, $jpgContent);
                    $galleryPaths[] = $filename;
                } else {
                    $galleryPaths[] = $image->store('products', 'public');
                }
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
            'gallery_sort_order' => 'nullable|array', // Mảng định dạng order (old:path / new:index)
            'gallery_sort_order.*' => 'string',
            'gallery' => 'nullable|array|max:12',
            'gallery.*' => 'file|mimes:jpeg,png,jpg,gif,webp,heic,heif|max:512000',
        ]);

        if (auth()->user()->is_admin) {
            $validated['is_published'] = $request->boolean('is_published');
        } else {
            $validated['is_published'] = false;
        }

        $currentGallery = $product->gallery ?? [];
        $uploadedFiles = $request->file('gallery') ?? [];
        $sortedOrders = $request->input('gallery_sort_order', []);

        $galleryPaths = [];
        $retainedPaths = [];

        // Xử lý thứ tự ảnh dựa trên list kéo thả từ Frontend
        foreach ($sortedOrders as $sortItem) {
            if (str_starts_with($sortItem, 'old:')) {
                // Nếu là ảnh cũ, giữ lại path
                $path = substr($sortItem, 4);
                if (in_array($path, $currentGallery)) {
                    $galleryPaths[] = $path;
                    $retainedPaths[] = $path;
                }
            } elseif (str_starts_with($sortItem, 'new:')) {
                // Nếu là ảnh mới, lấy từ file upload bằng index
                $index = (int) substr($sortItem, 4);
                if (isset($uploadedFiles[$index])) {
                    $image = $uploadedFiles[$index];
                    $ext = strtolower($image->getClientOriginalExtension());

                    if (in_array($ext, ['heic', 'heif'])) {
                        $jpgContent = HeicToJpg::convert($image->getRealPath())->get();
                        $filename = 'products/' . Str::random(40) . '.jpg';
                        Storage::disk('public')->put($filename, $jpgContent);
                        $galleryPaths[] = $filename;
                    } else {
                        $galleryPaths[] = $image->store('products', 'public');
                    }
                }
            }
        }

        // Xóa những ảnh cũ KHÔNG CÒN nằm trong danh sách giữ lại
        $deletedImages = array_diff($currentGallery, $retainedPaths);
        foreach ($deletedImages as $img) {
            Storage::disk('public')->delete($img);
        }

        $validated['gallery'] = array_slice($galleryPaths, 0, 12);
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
