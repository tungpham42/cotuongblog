<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserGameRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check(); // Chỉ yêu cầu user đã đăng nhập
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'initial_fen' => ['required', 'string'],
            'moves' => ['nullable', 'json'],
        ];
    }
}
