<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pool_contributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('liquidity_pool_id')->constrained()->onDelete('cascade');
            $table->decimal('lp_tokens', 30, 10); // مقدار LP توکن‌هایی که کاربر دارد
            $table->timestamps();

            $table->unique(['user_id', 'liquidity_pool_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pool_contributions');
    }
};