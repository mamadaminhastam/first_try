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
        $tokens = Token::all()->map(function ($token) {
            $token->icon_url = asset('icons/tokens/' . strtolower($token->symbol) . '.svg');
            return $token;
        });

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

    public function history(Request $request)
    {
        $query = Auth::user()->transactions()->with(['tokenFrom', 'tokenTo'])->latest();

        $filter = request('filter');
        if ($filter === 'today') {
            $query->whereDate('created_at', now()->toDateString());
        } elseif ($filter === 'week') {
            $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($filter === 'month') {
            $query->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()]);
        }

        $transactions = $query->paginate(10)->appends(request()->query());

        if ($request->ajax()) {
            $html = view('swap._transactions_rows', compact('transactions'))->render();
            return response()->json([
                'html' => $html,
                'hasMore' => $transactions->hasMorePages(),
                'currentPage' => $transactions->currentPage(),
            ]);
        }

        return view('swap.history', compact('transactions'));
    }
}
