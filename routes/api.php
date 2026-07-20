<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/token-prices', function () {
    $tokens = \App\Models\Token::select('id', 'symbol', 'name', 'price_usd')
        ->get()
        ->map(function ($token) {
            $token->icon_url = asset('icons/tokens/' . strtolower($token->symbol) . '.svg');
            return $token;
        });

    return response()->json($tokens);
});
