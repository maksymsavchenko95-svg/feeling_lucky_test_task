<?php

namespace Tests\Feature;

use App\Models\GameResult;
use App\Models\User;
use App\Services\GameService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Random\Engine\Mt19937;
use Random\Randomizer;
use Tests\TestCase;

class GameControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_page_is_available_by_active_link(): void
    {
        $user = User::factory()->withLink()->create();

        $this->get(route('game.show', $user))->assertOk()->assertSee($user->username);
    }

    public function test_play_stores_and_shows_result_by_the_game_rules(): void
    {
        $user = User::factory()->withLink()->create();
        $this->app->instance(Randomizer::class, new Randomizer(new Mt19937(42)));
        $number = (new Randomizer(new Mt19937(42)))->getInt(1, 1000);
        ['is_win' => $isWin, 'amount' => $amount] = GameService::outcome($number);

        $this->followingRedirects()
            ->post(route('game.play', $user))
            ->assertOk()
            ->assertSeeInOrder([$number, $isWin ? 'Win' : 'Lose', number_format($amount, 2)]);

        $result = $user->gameResults()->sole();
        $this->assertSame($number, $result->number);
        $this->assertSame($isWin, $result->is_win);
        $this->assertEqualsWithDelta($amount, (float)$result->amount, 0.001);
    }

    public function test_history_shows_only_last_three_results_of_the_user(): void
    {
        $user = User::factory()->withLink()->create();
        foreach ([10, 20, 30, 40] as $number) {
            GameResult::factory()->create(['user_id' => $user->id, 'number' => $number]);
        }
        GameResult::factory()->create(['number' => 50]);

        $this->get(route('game.history', $user))
            ->assertOk()
            ->assertViewHas('results', fn($results) => $results->pluck('number')->all() === [40, 30, 20]);
    }
}
