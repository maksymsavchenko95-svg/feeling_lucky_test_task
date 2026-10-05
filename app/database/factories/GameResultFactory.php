<?php

namespace Database\Factories;

use App\Models\GameResult;
use App\Models\User;
use App\Services\GameService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<GameResult>
 */
class GameResultFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $number = fake()->numberBetween(1, 1000);

        return [
            'user_id' => User::factory(),
            'number' => $number,
            ...GameService::outcome($number),
        ];
    }
}
