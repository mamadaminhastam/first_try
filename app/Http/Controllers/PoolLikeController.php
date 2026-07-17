<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LiquidityPool;
use App\Models\PoolLike;
use Illuminate\Support\Facades\Auth;

class PoolLikeController extends Controller
{
    public function toggle(LiquidityPool $pool, Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $existing = PoolLike::where('user_id', $user->id)
            ->where('liquidity_pool_id', $pool->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $liked = false;
        } else {
            PoolLike::create([
                'user_id' => $user->id,
                'liquidity_pool_id' => $pool->id,
            ]);
            $liked = true;
        }

        $count = $pool->likes()->count();

        return response()->json(['liked' => $liked, 'count' => $count]);
    }
}
