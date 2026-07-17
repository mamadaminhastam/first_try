<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoolLike extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'liquidity_pool_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pool()
    {
        return $this->belongsTo(LiquidityPool::class, 'liquidity_pool_id');
    }
}
