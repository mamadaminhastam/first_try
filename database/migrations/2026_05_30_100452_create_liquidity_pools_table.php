<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('liquidity_pools', function (Blueprint $table) {
            $table->id();
            $table->foreignId('token_a_id')->constrained('tokens')->onDelete('cascade');
            $table->foreignId('token_b_id')->constrained('tokens')->onDelete('cascade');
            $table->decimal('reserve_a', 30, 10)->default(0);
            $table->decimal('reserve_b', 30, 10)->default(0);
            $table->decimal('total_lp_tokens', 30, 10)->default(0);
            $table->decimal('fee_percent', 5, 2)->default(0.3); // 0.3%
            $table->timestamps();

            $table->unique(['token_a_id', 'token_b_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('liquidity_pools');
    }
};