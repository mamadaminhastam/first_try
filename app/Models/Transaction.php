<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'token_from_id', 'token_to_id',
        'amount_from', 'amount_to', 'rate',
        'transaction_hash', 'type', 'status'
    ];

    protected $casts = [
        'amount_from' => 'decimal:10',
        'amount_to' => 'decimal:10',
        'rate' => 'decimal:8',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tokenFrom()
    {
        return $this->belongsTo(Token::class, 'token_from_id');
    }

    public function tokenTo()
    {
        return $this->belongsTo(Token::class, 'token_to_id');
    }
}