<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        // Lấy 10 bài viết mới nhất để làm ngữ cảnh (tránh vượt quá giới hạn token)
        $posts = Post::where('is_published', true)
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($post) {
                // Xóa HTML tags và chỉ lấy khoảng 300 ký tự đầu để tối ưu token
                $cleanContent = Str::limit(strip_tags($post->content), 300);
                return "Tiêu đề: {$post->title}\nNội dung tóm tắt: {$cleanContent}";
            })->implode("\n\n");

        $systemPrompt = "Bạn là một trợ lý AI hữu ích cho blog Cờ tướng. Hãy dựa vào ngữ cảnh từ các bài viết mới nhất sau đây để trả lời câu hỏi của người dùng. Nếu thông tin không có trong bài viết, hãy trả lời theo kiến thức của bạn một cách lịch sự.\n\nNgữ cảnh bài viết:\n" . $posts;

        try {
            $response = Http::withToken(env('GROQ_API_KEY'))
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => env('GROQ_MODEL'),
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $request->message],
                    ],
                    'temperature' => 0.7,
                    'max_tokens' => 4096,
                ]);

            if ($response->successful()) {
                $rawContent = $response->json('choices.0.message.content');

                return response()->json([
                    // Parse Markdown thành HTML ở Backend
                    'reply' => Str::markdown($rawContent)
                ]);
            }

            return response()->json(['error' => 'API Error: ' . $response->body()], 500);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Không thể kết nối đến AI.'], 500);
        }
    }
}
