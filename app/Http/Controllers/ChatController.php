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

        // 1. Retrieve existing chat history from the session (default to an empty array)
        $history = session()->get('chat_history', []);

        // 2. Append the new user message to the history
        $history[] = ['role' => 'user', 'content' => $request->message];

        // 3. Keep only the last 10 messages (5 user messages + 5 AI responses) to avoid exceeding token limits
        if (count($history) > 10) {
            $history = array_slice($history, -10);
        }

        // Fetch the latest 10 published posts for context
        $posts = Post::where('is_published', true)
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($post) {
                $cleanContent = Str::limit(strip_tags($post->content), 300);
                return "Tiêu đề: {$post->title}\nNội dung tóm tắt: {$cleanContent}";
            })->implode("\n\n");

        $systemPrompt = "Bạn là một trợ lý AI hữu ích cho blog Cờ tướng. Hãy dựa vào ngữ cảnh từ các bài viết mới nhất sau đây để trả lời câu hỏi của người dùng. Nếu thông tin không có trong bài viết, hãy trả lời theo kiến thức của bạn một cách lịch sự.\n\nNgữ cảnh bài viết:\n" . $posts;

        // 4. Prepare the final messages array: System prompt goes first, followed by the chat history
        $messages = [
            ['role' => 'system', 'content' => $systemPrompt]
        ];
        $messages = array_merge($messages, $history);

        try {
            $response = Http::withToken(env('GROQ_API_KEY'))
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => 'meta-llama/llama-4-scout-17b-16e-instruct',
                    'messages' => $messages,
                    'temperature' => 0.7, // See note below regarding temperature
                    'max_tokens' => 4096,
                ]);

            if ($response->successful()) {
                $rawContent = $response->json('choices.0.message.content');

                // 5. Append the AI's reply to the history and save it back to the session
                $history[] = ['role' => 'assistant', 'content' => $rawContent];
                session()->put('chat_history', $history);

                return response()->json([
                    'reply' => Str::markdown($rawContent)
                ]);
            }

            return response()->json(['error' => 'API Error: ' . $response->body()], $response->status());

        } catch (\Exception $e) {
            return response()->json(['error' => 'Không thể kết nối đến AI.'], 500);
        }
    }

    // Optional: Add a method so users can reset their conversation
    public function clearHistory()
    {
        session()->forget('chat_history');
        return response()->json(['message' => 'Lịch sử trò chuyện đã được xóa.']);
    }
}
