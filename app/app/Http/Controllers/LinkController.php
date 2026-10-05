<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function register(RegisterRequest $request): RedirectResponse
    {
        $user = User::firstOrCreate($request->only('username'), $request->only('phone'));

        $user->issueLink();

        return redirect()->route('game.show', $user);
    }

    public function update(User $user): RedirectResponse
    {
        $user->issueLink();

        return redirect()->route('game.show', $user);
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->deactivateLink();

        return redirect()->route('register')->with('status', 'Link deactivated.');
    }
}
