<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['number', 'is_win', 'amount'])]
class GameResult extends Model
{
    /** @use HasFactory<\Database\Factories\GameResultFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'is_win' => 'boolean',
            'amount' => 'decimal:2',
        ];
    }
}
