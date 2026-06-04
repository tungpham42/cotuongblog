<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedBigInteger('price')->default(0); // Giá sản phẩm (VNĐ)
            $table->longText('description'); // Mô tả sản phẩm
            $table->string('video_url')->nullable(); // Link video demo (Youtube/Vimeo)
            $table->json('gallery')->nullable(); // Lưu mảng đường dẫn ảnh
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
