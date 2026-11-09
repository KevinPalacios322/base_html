<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_is_displayed(): void
    {
        $response = $this->get(route('login'));

        $response->assertOk()
            ->assertSee('Iniciar sesión')
            ->assertSee('name="email"', false)
            ->assertSee('name="password"', false)
            ->assertSee(route('login.store'), false);
    }

    public function test_valid_credentials_authenticate_the_user_and_redirect_to_inicio(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@clase.test',
            'password' => 'Clase2026!',
        ]);

        $response = $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'Clase2026!',
        ]);

        $response->assertRedirect(route('inicio'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_invalid_credentials_return_to_login_without_old_password(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@clase.test',
            'password' => 'Clase2026!',
        ]);

        $response = $this->from(route('login'))->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'incorrecta',
        ]);

        $response->assertRedirect(route('login'))
            ->assertSessionHasErrors('email')
            ->assertSessionHas('_old_input.email', $user->email)
            ->assertSessionMissing('_old_input.password');
        $this->assertGuest();
    }

    public function test_authenticated_user_is_redirected_from_login_to_inicio(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('login'))
            ->assertRedirect(route('inicio'));
    }

    public function test_guest_is_redirected_from_inicio_to_login(): void
    {
        $this->get(route('inicio'))
            ->assertRedirect(route('login'));
    }

    public function test_logout_ends_the_session_and_redirects_to_login(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('logout'))
            ->assertRedirect(route('login'));

        $this->assertGuest();
    }
}
