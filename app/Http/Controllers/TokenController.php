<?php

namespace App\Http\Controllers;

use App\Models\Token;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function index()
    {
        $tokens = Token::paginate(15);
        return view('tokens.index', compact('tokens'));
    }

    public function create()
    {
        return view('tokens.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'symbol' => 'required|string|max:10',
            'contract_address' => 'required|string|unique:tokens,contract_address',
            'decimals' => 'required|integer|min:1|max:18',
            'price_usd' => 'nullable|numeric',
            'network' => 'nullable|string'
        ]);

        Token::create($validated);

        return redirect()->route('tokens.index')
                         ->with('success', 'توکن با موفقیت اضافه شد.');
    }

    public function show(Token $token)
    {
        return view('tokens.show', compact('token'));
    }

    public function edit(Token $token)
    {
        return view('tokens.edit', compact('token'));
    }

    public function update(Request $request, Token $token)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'symbol' => 'required|string|max:10',
            'contract_address' => 'required|string|unique:tokens,contract_address,' . $token->id,
            'decimals' => 'required|integer|min:1|max:18',
            'price_usd' => 'nullable|numeric',
            'network' => 'nullable|string'
        ]);

        $token->update($validated);

        return redirect()->route('tokens.show', $token)
                         ->with('success', 'توکن به‌روزرسانی شد.');
    }

    public function destroy(Token $token)
    {
        $token->delete();

        return redirect()->route('tokens.index')
                         ->with('success', 'توکن حذف شد.');
    }
}