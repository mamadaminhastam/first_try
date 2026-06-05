<?php

namespace Database\Seeders;

use App\Models\UserBalance;
use App\Models\Token;
use Illuminate\Database\Seeder;

class UserBalanceSeeder extends Seeder
{
    public function run(): void
    {
        $user = \App\Models\User::first();
        if ($user) {
            $tokens = Token::all();
            foreach ($tokens as $token) {
                UserBalance::firstOrCreate(
                    ['user_id' => $user->id, 'token_id' => $token->id],
                    ['balance' => 1000]
                );
            }
        }
    }
}