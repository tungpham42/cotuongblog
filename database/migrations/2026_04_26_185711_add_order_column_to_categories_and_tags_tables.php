<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // Adds the 'order' column right after the 'slug' column
            $table->integer('order')->default(0)->after('slug');
        });

        Schema::table('tags', function (Blueprint $table) {
            // Adds the 'order' column right after the 'slug' column
            $table->integer('order')->default(0)->after('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('order');
        });

        Schema::table('tags', function (Blueprint $table) {
            $table->dropColumn('order');
        });
    }
};
