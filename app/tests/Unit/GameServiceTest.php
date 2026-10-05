<?php

namespace Tests\Unit;

use App\Services\GameService;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class GameServiceTest extends TestCase
{
    /**
     * @return array<string, array{int, bool, float}>
     */
    public static function outcomes(): array
    {
        return [
            'odd loses' => [1, false, 0.0],
            'odd above 900 loses' => [999, false, 0.0],
            'even at 2' => [2, true, 0.2],
            'even at 300 pays 10%' => [300, true, 30.0],
            'odd at 301 loses' => [301, false, 0.0],
            'even at 302 pays 30%' => [302, true, 90.6],
            'even at 600 pays 30%' => [600, true, 180.0],
            'even at 602 pays 50%' => [602, true, 301.0],
            'even at 900 pays 50%' => [900, true, 450.0],
            'even at 902 pays 70%' => [902, true, 631.4],
            'even at 1000 pays 70%' => [1000, true, 700.0],
        ];
    }

    #[DataProvider('outcomes')]
    public function test_outcome(int $number, bool $isWin, float $amount): void
    {
        $outcome = GameService::outcome($number);

        $this->assertSame($isWin, $outcome['is_win']);
        $this->assertEqualsWithDelta($amount, $outcome['amount'], 0.001);
    }
}
