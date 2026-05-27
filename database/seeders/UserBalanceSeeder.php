<?php

namespace Database\Seeders;

use App\Models\UserBalance;
use App\Models\Token;
use Illuminate\Database\Seeder;

class UserBalanceSeeder extends Seeder
{
    public function run(): void
    {
        $tokens = Token::all();
        $user = \App\Models\User::first();
        if ($user) {
            foreach ($tokens as $token) {
                UserBalance::create([
                    'user_id' => $user->id,
                    'token_id' => $token->id,
                    'balance' => 1000, // مقدار زیاد برای تست
                ]);
            }
        }
    }
}