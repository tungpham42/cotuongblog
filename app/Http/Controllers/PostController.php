<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use League\CommonMark\CommonMarkConverter;
use Spatie\SchemaOrg\Schema;

class PostController extends Controller
{
    public function home(Request $request)
    {
        App::setLocale('vi');
        $query = Post::where('is_published', true)
                     ->whereHas('category', function($q) {
                         $q->where('slug', '!=', 'english-articles');
                     });

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

        // Make sure both Categories and Tags are sorted by order
        $categories = Category::orderBy('order', 'asc')->get();
        $tags = Tag::orderBy('order', 'asc')->get();

        return view('home', compact('posts', 'categories', 'tags'));
    }

    public function index(Request $request)
    {
        App::setLocale('vi');
        $query = Post::with(['category', 'author', 'tags']);

        // Nếu không phải admin, chỉ hiển thị bài viết của chính họ
        if (!auth()->user()->is_admin) {
            $query->where('user_id', auth()->id());
        }

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
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::withCount('posts')->orderBy('order', 'asc')->get();
        $tags = Tag::withCount('posts')->orderBy('order', 'asc')->get();
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
            'video_url' => 'nullable|url|max:255',
            'featured_image' => 'nullable|image|max:20480',
            'tags' => 'array|exists:tags,id',
        ], [
            'title.unique' => 'Tiêu đề bài viết này đã tồn tại. Vui lòng chọn một tiêu đề khác.',
            'slug.unique' => 'Đường dẫn (slug) được tạo từ tiêu đề này đã bị trùng lặp.'
        ]);

        $validated['user_id'] = auth()->id();

        // Chỉ admin mới có quyền xuất bản ngay lập tức
        if (auth()->user()->is_admin) {
            $validated['is_published'] = $request->boolean('is_published');
        } else {
            $validated['is_published'] = false; // Luôn là false để chờ duyệt
        }

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('posts', 'public');
            $validated['featured_image'] = $path;
        } elseif ($request->filled('video_url')) {
            // Tự động lấy thumbnail nếu không upload ảnh nhưng có link video
            $thumbnailPath = $this->fetchVideoThumbnail($request->video_url);
            if ($thumbnailPath) {
                $validated['featured_image'] = $thumbnailPath;
            }
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

        $categories = Category::withCount('posts')->orderBy('order', 'asc')->get();
        $tags = Tag::withCount('posts')->orderBy('order', 'asc')->get();
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
            'video_url' => 'nullable|url|max:255',
            'featured_image' => 'nullable|image|max:20480',
            'tags' => 'array|exists:tags,id',
        ], [
            'title.unique' => 'Tiêu đề bài viết này đã tồn tại. Vui lòng chọn một tiêu đề khác.',
            'slug.unique' => 'Đường dẫn (slug) được tạo từ tiêu đề này đã bị trùng lặp.'
        ]);

        // Nếu user thường sửa bài, trạng thái sẽ bị đưa về chờ duyệt
        if (auth()->user()->is_admin) {
            $validated['is_published'] = $request->boolean('is_published');
        } else {
            $validated['is_published'] = false;
        }

        if ($request->hasFile('featured_image')) {
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        } elseif ($request->filled('video_url')) {
            // Kiểm tra xem link video có bị thay đổi so với cũ không
            if ($request->video_url !== $post->video_url) {
                $thumbnailPath = $this->fetchVideoThumbnail($request->video_url);
                if ($thumbnailPath) {
                    // Xóa ảnh thumbnail cũ nếu nó là ảnh tự động lấy từ YouTube trước đó
                    if ($post->featured_image && Str::startsWith($post->featured_image, 'posts/yt_')) {
                        Storage::disk('public')->delete($post->featured_image);
                    }
                    $validated['featured_image'] = $thumbnailPath;
                }
            }
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

        // SEO: Build the BlogPosting Schema
        $postSchema = Schema::blogPosting()
            ->mainEntityOfPage(Schema::webPage()->identifier(route('posts.show', $post->slug)))
            ->headline($post->title)
            ->description(Str::limit(strip_tags($post->excerpt ?? $post->content), 150))
            ->datePublished($post->created_at->toIso8601String())
            ->dateModified($post->updated_at->toIso8601String())
            ->keywords($post->tags->pluck('name')->implode(', ')) // Added keywords
            ->articleSection($post->category->name ?? 'General') // Added section
            ->author(
                Schema::person()->name($post->author->name ?? 'Tác giả ẩn danh')
            )
            ->publisher(
                Schema::organization()
                    ->name('Cộng Đồng Cờ Tướng')
                    ->logo(Schema::imageObject()->url(asset('img/favicon-32x32-game.png')))
            );

        if ($post->featured_image) {
            $postSchema->image(asset('storage/' . $post->featured_image));
        }

        // SEO: Build Breadcrumb Schema
        $breadcrumbElements = [
            Schema::listItem()->position(1)->name('Trang chủ')->item(route('home'))
        ];

        if ($post->category) {
            $breadcrumbElements[] = Schema::listItem()
                ->position(2)
                ->name($post->category->name)
                ->item(route('categories.show', $post->category->slug));

            $breadcrumbElements[] = Schema::listItem()
                ->position(3)
                ->name($post->title)
                ->item(route('posts.show', $post->slug));
        } else {
            $breadcrumbElements[] = Schema::listItem()
                ->position(2)
                ->name($post->title)
                ->item(route('posts.show', $post->slug));
        }

        $breadcrumbSchema = Schema::breadcrumbList()->itemListElement($breadcrumbElements);

        return view('posts.show', compact('post', 'relatedPosts', 'postSchema', 'breadcrumbSchema'));
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

    /**
     * Tự động lấy ảnh Thumbnail từ Video URL (YouTube, Vimeo, TikTok)
     */
    private function fetchVideoThumbnail($videoUrl)
    {
        $thumbnailUrl = null;
        $prefix = 'vid_'; // Tiền tố mặc định cho tên file

        // 1. Kiểm tra Youtube
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $videoUrl, $match)) {
            $youtubeId = $match[1];
            $prefix = 'yt_';

            // Ưu tiên ảnh chất lượng cao (maxres), nếu không có thì lùi về chất lượng cao tiêu chuẩn (hq)
            $urlsToTry = [
                "https://img.youtube.com/vi/{$youtubeId}/maxresdefault.jpg",
                "https://img.youtube.com/vi/{$youtubeId}/hqdefault.jpg"
            ];

            foreach ($urlsToTry as $url) {
                try {
                    $response = Http::get($url);
                    if ($response->successful()) {
                        $thumbnailUrl = $url;
                        break;
                    }
                } catch (\Exception $e) {
                    continue;
                }
            }
        }
        // 2. Kiểm tra Vimeo (Sử dụng oEmbed API)
        elseif (preg_match('/vimeo\.com/i', $videoUrl)) {
            $prefix = 'vm_';
            try {
                $response = Http::get('https://vimeo.com/api/oembed.json?url=' . urlencode($videoUrl));
                if ($response->successful()) {
                    $thumbnailUrl = $response->json('thumbnail_url');
                }
            } catch (\Exception $e) {
                // Bỏ qua nếu có lỗi mạng hoặc link video không tồn tại
            }
        }
        // 3. Kiểm tra TikTok (Sử dụng oEmbed API)
        elseif (preg_match('/tiktok\.com/i', $videoUrl)) {
            $prefix = 'tt_';
            try {
                $response = Http::get('https://www.tiktok.com/oembed?url=' . urlencode($videoUrl));
                if ($response->successful()) {
                    $thumbnailUrl = $response->json('thumbnail_url');
                }
            } catch (\Exception $e) {
                // Bỏ qua nếu có lỗi
            }
        }

        // Nếu tìm thấy link ảnh hợp lệ, tiến hành tải về và lưu trữ
        if ($thumbnailUrl) {
            try {
                $response = Http::get($thumbnailUrl);
                if ($response->successful()) {
                    // Xác định đuôi mở rộng cơ bản (Mặc định là jpg)
                    $extension = 'jpg';
                    if (\Illuminate\Support\Str::contains($thumbnailUrl, '.png')) {
                        $extension = 'png';
                    } elseif (\Illuminate\Support\Str::contains($thumbnailUrl, '.webp')) {
                        $extension = 'webp';
                    }

                    // Tạo tên file độc nhất: posts/yt_1714567890_abcde.jpg
                    $filename = 'posts/' . $prefix . time() . '_' . \Illuminate\Support\Str::random(5) . '.' . $extension;
                    Storage::disk('public')->put($filename, $response->body());

                    return $filename;
                }
            } catch (\Exception $e) {
                return null;
            }
        }

        return null; // Trả về null nếu không khớp nền tảng nào hoặc quá trình lấy ảnh thất bại
    }
}
