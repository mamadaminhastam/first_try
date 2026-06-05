<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Token;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function index()
    {
        $tokens = Token::orderBy('symbol')->paginate(20);
        return view('admin.tokens.index', compact('tokens'));
    }

    public function destroy(Token $token)
    {
        $token->delete();
        return back()->with('success', 'توکن حذف شد.');
    }
}