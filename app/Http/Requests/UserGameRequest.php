<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UserGameRequest extends FormRequest
{
    /**
     * Xác định xem người dùng có quyền thực hiện request này hay không.
     */
    public function authorize()
    {
        return true; // Xử lý phân quyền đã được làm ở Controller
    }

    /**
     * Chuẩn bị dữ liệu trước khi validate.
     * Tạo 'slug' tự động từ 'title' để có thể kiểm tra tính duy nhất.
     */
    protected function prepareForValidation()
    {
        if ($this->has('title')) {
            $this->merge([
                'slug' => Str::slug($this->title),
            ]);
        }
    }

    /**
     * Quy tắc validation.
     */
    public function rules()
    {
        // Lấy ID của ván cờ hiện tại nếu đang ở thao tác Update (route 'games.update')
        // Lưu ý: $this->route('game') trả về Model Game do Route Model Binding dùng slug
        $gameId = $this->route('game') ? $this->route('game')->id : null;

        return [
            // Bắt buộc, chuỗi, tối đa 255 ký tự, và duy nhất trong bảng 'games' (bỏ qua $gameId nếu đang update)
            'title'       => 'required|string|max:255|unique:games,title,' . $gameId,
            'slug'        => 'required|string|max:255|unique:games,slug,' . $gameId,

            'description' => 'nullable|string',
            'initial_fen' => 'required|string',
            'moves'       => 'nullable|string', // Chứa chuỗi JSON từ form
            'raw_moves'   => 'nullable|string', // Biên bản dạng text (chỉ để hiển thị form, không nhất thiết lưu)
        ];
    }

    /**
     * Tùy chỉnh thông báo lỗi (Tiếng Việt) để hiển thị ra form.
     */
    public function messages()
    {
        return [
            'title.required'    => 'Vui lòng nhập tiêu đề ván cờ.',
            'title.unique'      => 'Tiêu đề này đã tồn tại. Vui lòng chọn một tiêu đề khác.',
            'slug.unique'       => 'Đường dẫn (slug) tạo từ tiêu đề này đã tồn tại. Vui lòng thay đổi tiêu đề.',
            'initial_fen.required' => 'Mã FEN ban đầu là bắt buộc.',
        ];
    }
}
