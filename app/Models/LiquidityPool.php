<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiquidityPool extends Model
{
    use HasFactory;

    protected $fillable = [
        'token_a_id', 'token_b_id', 'reserve_a', 'reserve_b',
        'total_lp_tokens', 'fee_percent'
    ];

    protected $casts = [
        'reserve_a' => 'decimal:10',
        'reserve_b' => 'decimal:10',
        'total_lp_tokens' => 'decimal:10',
        'fee_percent' => 'decimal:2',
    ];

    public function tokenA()
    {
        return $this->belongsTo(Token::class, 'token_a_id');
    }

    public function tokenB()
    {
        return $this->belongsTo(Token::class, 'token_b_id');
    }

    public function contributions()
    {
        return $this->hasMany(PoolContribution::class);
    }
}