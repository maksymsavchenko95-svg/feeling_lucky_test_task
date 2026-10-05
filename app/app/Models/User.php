<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Propaganistas\LaravelPhone\Casts\E164PhoneNumberCast;

#[Fillable(['username', 'phone'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    private const int LINK_TTL_DAYS = 7;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'link_expires_at' => 'immutable_datetime',
            'phone' => E164PhoneNumberCast::class.':UA',

        ];
    }

    /**
     * @return HasMany<GameResult, $this>
     */
    public function gameResults(): HasMany
    {
        return $this->hasMany(GameResult::class);
    }

    public function issueLink(): void
    {
        $this->forceFill([
            'link_token' => Str::random(64),
            'link_expires_at' => now()->addDays(self::LINK_TTL_DAYS),
        ])->save();
    }

    public function deactivateLink(): void
    {
        $this->forceFill(['link_token' => null, 'link_expires_at' => null])->save();
    }

    public function resolveRouteBinding($value, $field = null): ?Model
    {
        if ($field === 'link_token') {
            return $this->where('link_token', $value)
                ->where('link_expires_at', '>', now())
                ->first();
        }

        return parent::resolveRouteBinding($value, $field);
    }
}
