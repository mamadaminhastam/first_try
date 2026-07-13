<?php

namespace App\Http\Controllers;

use App\Models\Token;
use App\Models\Transaction;
use App\Models\UserBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SwapController extends Controller
{
    public function index()
    {
        $tokens = Token::all();
        return view('swap.index', compact('tokens'));
    }

    public function swap(Request $request)
    {
        $request->validate([
            'token_from' => 'required|exists:tokens,id',
            'token_to'   => 'required|exists:tokens,id|different:token_from',
            'amount'     => 'required|numeric|min:0.0000000001',
        ]);

        $user = Auth::user();
        $tokenFrom = Token::findOrFail($request->token_from);
        $tokenTo   = Token::findOrFail($request->token_to);
        $amountFrom = $request->amount;

        
        $rate = $tokenFrom->price_usd / $tokenTo->price_usd;
        $amountTo = $amountFrom * $rate;

       
        $balance = UserBalance::where('user_id', $user->id)
                              ->where('token_id', $tokenFrom->id)
                              ->first();

        if (!$balance || $balance->balance < $amountFrom) {
            return back()->with('error', 'موجودی ناکافی است.')
                ->with('snackbar', 'Insufficient balance!');
        }

       
        $balance->balance -= $amountFrom;
        $balance->save();

        
        $toBalance = UserBalance::firstOrNew([
            'user_id' => $user->id,
            'token_id' => $tokenTo->id
        ]);
        $toBalance->balance += $amountTo;
        $toBalance->save();

      
        $transaction = Transaction::create([
            'user_id'          => $user->id,
            'token_from_id'    => $tokenFrom->id,
            'token_to_id'      => $tokenTo->id,
            'amount_from'      => $amountFrom,
            'amount_to'        => $amountTo,
            'rate'             => $rate,
            'transaction_hash' => '0x' . Str::random(64), // هش شبیه‌سازی شده
            'type'             => 'swap',
            'status'           => 'completed',
        ]);

        return redirect()->route('swap.history')->with('success', 'تبادل با موفقیت انجام شد.');
    }

    public function history()
    {
        $transactions = Auth::user()->transactions()
                                   ->with(['tokenFrom', 'tokenTo'])
                                   ->latest()
                                   ->paginate(10);
        return view('swap.history', compact('transactions'));
    }
}