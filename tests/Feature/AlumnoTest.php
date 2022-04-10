<?php

namespace Tests\Feature;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\User;
use Tests\TestCase;

class AlumnoTest extends TestCase
{
    /** @var User */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /** @test */
    public function create_alumno()
    {
        $this->actingAs($this->user)
            ->postJson(route('alumnos.store'), [
                'name' => 'Lorem',
                'curso' => 'Ipsum',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('alumnos', [
            'name' => 'Lorem',
            'curso' => 'Ipsum',
        ]);
    }

    /** @test */
    public function update_alumno()
    {
        $alumno = Alumno::factory()->create();

        $this->actingAs($this->user)
            ->putJson(route('alumnos.update', $alumno->id), [
                'name' => 'Alumno7',
                'curso' => 'Ipsum',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('alumnos', [
            'id' => $alumno->id,
            'name' => 'Alumno7',
            'curso' => 'Ipsum',
        ]);
    }

    /** @test */
    public function show_alumno()
    {
        $alumno = Alumno::factory()->create();

        $this->actingAs($this->user)
            ->getJson(route('alumnos.show', $alumno->id))
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'name' => $alumno->name,
                    'curso' => $alumno->curso,
                ],
            ]);
    }

    /** @test */
    public function list_alumno()
    {
        $alumnos = Alumno::factory()->count(2)->create()->map(function ($alumno) {
            return $alumno->only(['id', 'name']);
        });

        $this->actingAs($this->user)
            ->getJson(route('alumnos.index'))
            ->assertSuccessful()
            ->assertJson([
                'data' => $alumnos->toArray(),
            ])
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name'],
                ],
                'links',
                'meta',
            ]);
    }

    /** @test */
    public function delete_alumno()
    {
        $alumno = Alumno::factory()->create([
            'name' => 'Alumno for delete',
            'curso' => 'Ipsum',
        ]);

        $this->actingAs($this->user)
            ->deleteJson(route('alumnos.update', $alumno->id))
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseMissing('alumnos', [
            'id' => $alumno->id,
            'name' => 'Alumno for delete',
            'curso' => 'Ipsum',
        ]);
    }
}
