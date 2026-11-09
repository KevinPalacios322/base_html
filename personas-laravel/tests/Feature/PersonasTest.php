<?php

namespace Tests\Feature;

use App\Models\Persona;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PersonasTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_sees_people_ordered_by_id(): void
    {
        $user = User::factory()->create();

        Persona::factory()->create([
            'dni' => '0000000000002',
            'nombre' => 'Segunda persona',
            'fecha_nacimiento' => '1990-02-04',
        ]);
        Persona::factory()->create([
            'dni' => '0000000000001',
            'nombre' => 'Primera persona',
            'fecha_nacimiento' => '1985-06-18',
        ]);

        $this->actingAs($user)
            ->get(route('personas.index'))
            ->assertOk()
            ->assertSeeInOrder([
                'ID',
                'DNI',
                'Nombre',
                'Nacimiento',
                '0000000000002',
                'Segunda persona',
                '04/02/1990',
                '0000000000001',
                'Primera persona',
                '18/06/1985',
            ]);
    }

    public function test_empty_people_list_displays_an_empty_state(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('personas.index'))
            ->assertOk()
            ->assertSee('No hay personas registradas.')
            ->assertSee('<th scope="col">ID</th>', false);
    }

    public function test_guest_is_redirected_to_login_when_opening_people_list(): void
    {
        $this->get(route('personas.index'))
            ->assertRedirect(route('login'));
    }

    public function test_inicio_redirects_to_the_people_list(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('inicio'))
            ->assertRedirect(route('personas.index'));
    }
}
