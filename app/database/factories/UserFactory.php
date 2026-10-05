<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * @return array|mixed[]
     */
    public function definition(): array
    {
        return [
            'username' => fake()->unique()->userName(),
            'phone' => '+38050'.fake()->numerify('#######'),
        ];
    }

    public function withLink(): static
    {
        return $this->afterCreating(fn (User $user) => $user->issueLink());
    }
}
