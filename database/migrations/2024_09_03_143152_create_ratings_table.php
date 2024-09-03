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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // معرّف المستخدم
            $table->foreignId('book_id')->constrained()->onDelete('cascade'); // معرّف الكتاب
            $table->integer('rating')->unsigned(); // التقييم (1-5)
            $table->text('review')->nullable(); // مراجعة النصية (اختياري)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
