<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   
public function up()
{
    Schema::create('articles', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('slug')->unique(); // اصلاح غلط املایی unique
        $table->text('content');
        $table->string('image')->nullable();
        
        // تعریف ستون کلید خارجی (با رعایت استاندارد snake_case)
        $table->unsignedBigInteger('user_id'); 
        
        $table->integer('view_count')->default(0);
        $table->timestamp('published_at')->nullable(); // اصلاح timestamps به timestamp
        $table->boolean('is_published')->default(false);
        $table->timestamps(); // ایجاد created_at و updated_at

        // تنظیمات کلید خارجی
        $table->foreign('user_id')
              ->references('id') // در جدول users ستون اصلی id نام دارد
              ->on('users')
              ->onDelete('cascade');

        // تعریف ایندکس‌ها
        $table->index('slug');
        $table->index('is_published');
        $table->index('published_at');
        // ستون user_id چون کلید خارجی است، معمولاً خودش ایندکس می‌شود اما نوشتنش ضرری ندارد
        $table->index('user_id'); 
    });
}

            
  

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
