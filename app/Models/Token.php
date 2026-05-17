<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'symbol',
        'contract_address',
        'decimals',
        'price_usd',
        'network'
    ];

    protected $casts = [
        'decimals' => 'integer',
        'price_usd' => 'decimal:8',
    ];
}