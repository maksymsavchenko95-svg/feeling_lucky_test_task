<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class LinkControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_form_is_shown(): void
    {
        $this->get('/')->assertOk()->assertSee('Register')->assertSee('value="+380"', false);
    }

    public function test_user_registers_and_is_redirected_to_a_link_valid_for_seven_days(): void
    {
        $response = $this->post('/link/register', ['username' => 'john', 'phone' => '050 123 4567']);

        $user = User::sole();
        $response->assertRedirect(route('game.show', $user));
        $this->assertTrue($user->link_expires_at->isSameDay(now()->addDays(7)));
        $this->assertDatabaseHas('users', ['username' => 'john', 'phone' => '+380501234567']);
    }

    public function test_owner_re_registers_and_gets_a_new_link(): void
    {
        $this->post('/link/register', ['username' => 'john', 'phone' => '+380501234567']);
        $oldToken = User::sole()->link_token;

        $this->post('/link/register', ['username' => 'john', 'phone' => '050 123 4567'])->assertSessionHasNoErrors();

        $user = User::sole();
        $this->assertNotSame($oldToken, $user->link_token);
        $this->get(route('game.show', $oldToken))->assertNotFound();
        $this->get(route('game.show', $user))->assertOk();
    }

    public function test_username_of_another_user_is_taken(): void
    {
        User::factory()->create(['username' => 'john', 'phone' => '+380501234567']);

        $this->post('/link/register', ['username' => 'john', 'phone' => '+380671234567'])
            ->assertSessionHasErrors('username');

        $this->assertNull(User::sole()->link_token);
    }

    #[DataProvider('invalidPhones')]
    public function test_registration_rejects_invalid_phone(string $phone): void
    {
        $this->post('/link/register', ['username' => 'john', 'phone' => $phone])
            ->assertSessionHasErrors('phone');

        $this->assertDatabaseCount('users', 0);
    }

    /**
     * @return array<string, array{string}>
     */
    public static function invalidPhones(): array
    {
        return [
            'empty' => [''],
            'text' => ['test'],
            'not ukrainian' => ['+48501234567'],
            'too short' => ['+38050123'],
        ];
    }

}
