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

        $userMessage = $request->message;

        // 1. Tối ưu: Lọc ra các từ khóa chính từ câu hỏi của người dùng
        // Ví dụ: "Luật nhập thành cờ tướng" -> ['Luật', 'nhập', 'thành', 'tướng']
        $keywords = array_filter(explode(' ', $userMessage), function ($word) {
            return mb_strlen($word) > 2; // Bỏ qua các từ quá ngắn như "là", "có", "gì"...
        });

        // 2. Query cơ sở dữ liệu: Tìm các bài viết có chứa từ khóa
        $query = Post::select('title', 'content', 'created_at')
            ->where('is_published', true);

        if (!empty($keywords)) {
            $query->where(function ($q) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $q->orWhere('title', 'LIKE', '%' . $keyword . '%')
                      ->orWhere('content', 'LIKE', '%' . $keyword . '%');
                }
            });
        }

        // 3. Chỉ lấy 5 bài viết LIÊN QUAN NHẤT (thay vì toàn bộ) để tối ưu Token
        $posts = $query->latest()
            ->take(5)
            ->get()
            ->map(function ($post) {
                // Tiếp tục nén data: Bỏ HTML và giới hạn 400 ký tự cho mỗi bài
                $cleanContent = Str::limit(strip_tags($post->content), 400);
                return "Tiêu đề: {$post->title}\nNội dung: {$cleanContent}";
            })->implode("\n\n---\n\n");

        // Nếu không tìm thấy bài nào liên quan, báo cho AI biết
        $context = $posts ?: "Không tìm thấy bài viết nào trên blog liên quan trực tiếp đến câu hỏi này.";

        $systemPrompt = "Bạn là một trợ lý AI hữu ích cho blog Cờ tướng. Hãy dựa vào ngữ cảnh từ các bài viết liên quan sau đây để trả lời câu hỏi của người dùng. Nếu thông tin không có trong bài viết, hãy trả lời theo kiến thức của bạn một cách lịch sự, nhưng ưu tiên dữ liệu từ blog.\n\nNgữ cảnh bài viết:\n" . $context;

        try {
            $response = Http::withToken(env('GROQ_API_KEY'))
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => env('GROQ_MODEL'),
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $userMessage],
                    ],
                    'temperature' => 0.6, // Giảm temperature một chút để AI bám sát fact (ngữ cảnh) hơn
                    'max_tokens' => 4096, // Tăng max tokens để AI có thể trả lời chi tiết hơn nếu cần
                ]);

            if ($response->successful()) {
                $rawContent = $response->json('choices.0.message.content');

                return response()->json([
                    'reply' => Str::markdown($rawContent)
                ]);
            }

            return response()->json(['error' => 'API Error: ' . $response->body()], 500);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Không thể kết nối đến AI.'], 500);
        }
    }
}
