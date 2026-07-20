<?php

namespace App\Http\Controllers;

use App\Models\UserBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $balances = UserBalance::where('user_id', $user->id)
            ->where('balance', '>', 0)
            ->with('token')
            ->get();

        return view('profile.show', compact('user', 'balances'));
    }
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $user->update($validated);

        return redirect()->route('profile.show')
            ->with('success', __('Profile updated successfully.'));
    }
}
