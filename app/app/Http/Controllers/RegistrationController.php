<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function store(RegisterRequest $request): RedirectResponse
    {
        $user = User::firstOrCreate($request->only('username'), $request->only('phone'));

        $user->issueLink();

        return redirect()->route('game.show', $user);
    }
}
