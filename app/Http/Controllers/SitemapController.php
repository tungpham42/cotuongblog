<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index()
    {
        // Get all published posts, and all categories/tags
        $posts = Post::where('is_published', true)->latest()->get();
        $categories = Category::all();
        $tags = Tag::all();

        // Return the view as an XML document
        return response()->view('sitemap', [
            'posts' => $posts,
            'categories' => $categories,
            'tags' => $tags
        ])->header('Content-Type', 'text/xml');
    }
}
