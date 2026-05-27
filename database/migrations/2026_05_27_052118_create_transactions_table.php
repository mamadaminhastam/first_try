<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('token_from_id')->constrained('tokens')->onDelete('cascade');
            $table->foreignId('token_to_id')->constrained('tokens')->onDelete('cascade');
            $table->decimal('amount_from', 30, 10);
            $table->decimal('amount_to', 30, 10);
            $table->decimal('rate', 20, 8);
            $table->string('transaction_hash')->nullable(); // شبیه‌سازی هش تراکنش
            $table->string('type')->default('swap'); // swap, liquidity, stake
            $table->string('status')->default('completed'); // completed, pending, failed
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};