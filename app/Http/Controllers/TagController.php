<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
use Spatie\SchemaOrg\Schema;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::withCount('posts')->orderBy('order', 'asc')->get();
        return view('tags.index', compact('tags'));
    }

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
            'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480',
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
            'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480',
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
        $tag->posts()->detach();
        $tag->delete();

        return redirect()->route('tags.index')->with('success', 'Thẻ đã được xóa!');
    }

    public function show(Request $request, Tag $tag)
    {
        App::setLocale('vi');
        $query = $tag->posts()->where('is_published', true);

        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

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
            case 'views_desc':
                $query->orderBy('views', 'desc');
                break;
            case 'views_asc':
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

        $tagSchema = Schema::collectionPage()
            ->name('Thẻ: ' . $tag->name)
            ->description($tag->description ?? 'Tuyển tập các bài viết được gắn thẻ #' . $tag->name . ' trên Cộng Đồng Cờ Tướng.')
            ->url(url()->current()) // SEO: dynamic URL for pagination handling
            ->mainEntity(
                Schema::itemList()->itemListElement($itemListElements)
            );

        if ($tag->featured_image) {
            $tagSchema->image(asset('storage/' . $tag->featured_image));
        }

        // SEO: Build Breadcrumb Schema for the Tag Page
        $breadcrumbSchema = Schema::breadcrumbList()
            ->itemListElement([
                Schema::listItem()->position(1)->name('Trang chủ')->item(route('home')),
                Schema::listItem()->position(2)->name('Thẻ: ' . $tag->name)->item(route('tags.show', $tag->slug))
            ]);

        return view('tags.show', compact('tag', 'posts', 'tagSchema', 'breadcrumbSchema'));
    }
}
