<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment; // Thêm import này
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $validated['content'],
        ]);

        return back()->with('success', 'Bình luận đã được đăng thành công!');
    }

    // Thêm method destroy
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return back()->with('success', 'Bình luận đã được xóa!');
    }
}