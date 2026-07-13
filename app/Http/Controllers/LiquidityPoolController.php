<?php

namespace App\Http\Controllers;

use App\Models\LiquidityPool;
use App\Models\Token;
use App\Models\PoolContribution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LiquidityPoolController extends Controller
{
    
    public function index()
    {
        $pools = LiquidityPool::with(['tokenA', 'tokenB'])->paginate(10);
        return view('pools.index', compact('pools'));
    }

    
    public function create()
    {
        $tokens = Token::orderBy('symbol')->get();
        return view('pools.create', compact('tokens'));
    }

   
    public function store(Request $request)
    {
        $validated = $request->validate([
            'token_a_id' => 'required|exists:tokens,id|different:token_b_id',
            'token_b_id' => 'required|exists:tokens,id',
            'fee_percent' => 'nullable|numeric|min:0|max:100'
        ]);

        
        $exists = LiquidityPool::where(function($query) use ($validated) {
            $query->where('token_a_id', $validated['token_a_id'])
                  ->where('token_b_id', $validated['token_b_id']);
        })->orWhere(function($query) use ($validated) {
            $query->where('token_a_id', $validated['token_b_id'])
                  ->where('token_b_id', $validated['token_a_id']);
        })->exists();

        if ($exists) {
            return back()->with('error', 'این استخر قبلاً ایجاد شده است.')->withInput();
        }

        LiquidityPool::create([
            'token_a_id' => $validated['token_a_id'],
            'token_b_id' => $validated['token_b_id'],
            'fee_percent' => $validated['fee_percent'] ?? 0.3,
        ]);

        return redirect()->route('pools.index')->with('success', 'استخر نقدینگی با موفقیت ایجاد شد.');
    }

    
    public function show(LiquidityPool $pool)
    {
        $userContribution = null;
        if (Auth::check()) {
            $userContribution = PoolContribution::where('user_id', Auth::id())
                ->where('liquidity_pool_id', $pool->id)
                ->first();
        }

        return view('pools.show', compact('pool', 'userContribution'));
    }

    
    public function addLiquidityForm(LiquidityPool $pool)
    {
        return view('pools.add-liquidity', compact('pool'));
    }

   
    public function addLiquidity(Request $request, LiquidityPool $pool)
    {
       

        $request->validate([
            'amount_a' => 'required|numeric|min:0.0000000001',
            'amount_b' => 'required|numeric|min:0.0000000001',
        ]);

        $user = Auth::user();
        $amountA = $request->amount_a;
        $amountB = $request->amount_b;

        
        $balanceA = \App\Models\UserBalance::where('user_id', $user->id)
            ->where('token_id', $pool->token_a_id)->first();
        $balanceB = \App\Models\UserBalance::where('user_id', $user->id)
            ->where('token_id', $pool->token_b_id)->first();

       
        if (!$balanceA || $balanceA->balance < $amountA) {
            return back()->with('error', "موجودی ناکافی {$pool->tokenA->symbol}");
        }
        if (!$balanceB || $balanceB->balance < $amountB) {
            return back()->with('error', "موجودی ناکافی {$pool->tokenB->symbol}");
        }

        
        if ($pool->total_lp_tokens == 0) {
            $lpTokens = sqrt($amountA * $amountB);
        } else {
            $shareA = ($amountA / $pool->reserve_a) * $pool->total_lp_tokens;
            $shareB = ($amountB / $pool->reserve_b) * $pool->total_lp_tokens;
            $lpTokens = min($shareA, $shareB);
        }

        
        $pool->reserve_a += $amountA;
        $pool->reserve_b += $amountB;
        $pool->total_lp_tokens += $lpTokens;
        $pool->save();

        
        $contribution = PoolContribution::firstOrNew([
            'user_id' => $user->id,
            'liquidity_pool_id' => $pool->id,
        ]);
        $contribution->lp_tokens += $lpTokens;
        $contribution->save();

        
        $balanceA->balance -= $amountA;
        $balanceA->save();
        $balanceB->balance -= $amountB;
        $balanceB->save();

        return redirect()->route('pools.show', $pool)->with('success', 'نقدینگی با موفقیت اضافه شد.');
        }
        public function destroy(LiquidityPool $pool)
{
    
    $pool->contributions()->delete();
    $pool->delete();

    return redirect()->route('pools.index')->with('success', 'استخر با موفقیت حذف شد.');
}
}