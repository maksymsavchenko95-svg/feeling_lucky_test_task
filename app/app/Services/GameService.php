<?php

namespace App\Services;

use App\Models\GameResult;
use App\Models\User;
use Random\Randomizer;

class GameService
{
    public function __construct(private Randomizer $randomizer) {}

    public function play(User $user): GameResult
    {
        $number = $this->randomizer->getInt(1, 1000);

        return $user->gameResults()->create(['number' => $number, ...self::outcome($number)]);
    }

    /**
     * @return array{is_win: bool, amount: float}
     */
    public static function outcome(int $number): array
    {
        $isWin = $number % 2 === 0;

        return [
            'is_win' => $isWin,
            'amount' => $isWin ? self::prize($number) : 0.0,
        ];
    }

    private static function prize(int $number): float
    {
        $percent = match (true) {
            $number > 900 => 70,
            $number > 600 => 50,
            $number > 300 => 30,
            default => 10,
        };

        return $number * $percent / 100;
    }
}
