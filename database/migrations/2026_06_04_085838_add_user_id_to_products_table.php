<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Thêm user_id vào sau cột id, nullable() để không bị lỗi nếu bảng đang có sẵn dữ liệu
            $table->foreignId('user_id')
                  ->nullable()
                  ->after('id')
                  ->constrained()
                  ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop foreign key trước, drop cột sau
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
