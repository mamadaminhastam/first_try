<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoolContribution extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'liquidity_pool_id', 'lp_tokens'];

    protected $casts = [
        'lp_tokens' => 'decimal:10',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pool()
    {
        return $this->belongsTo(LiquidityPool::class, 'liquidity_pool_id');
    }
}