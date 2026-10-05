<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\GameService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GameController extends Controller
{
    public function show(User $user): View
    {
        return view('game.play', [
            'user' => $user,
            'result' => $user->gameResults()->find(session('result_id')),
        ]);
    }
    public function play(User $user, GameService $game): RedirectResponse
    {
        return redirect()->route('game.show', $user)->with('result_id', $game->play($user)->id);
    }

    public function history(User $user): View
    {
        return view('game.history', [
            'user' => $user,
            'results' => $user->gameResults()->latest('id')->limit(3)->get(),
        ]);
    }

}
