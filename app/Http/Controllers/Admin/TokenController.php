<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Token;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function index(Request $request)
    {
        $query = Token::orderBy('symbol');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('symbol', 'like', "%{$search}%");
            });
        }

        $tokens = $query->paginate(20)->appends($request->query());

        return view('admin.tokens.index', compact('tokens'));
    }

    public function destroy(Token $token)
    {
        $token->delete();
        return back()->with('success', 'توکن حذف شد.');
    }
}