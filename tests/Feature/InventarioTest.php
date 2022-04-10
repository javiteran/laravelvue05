<?php

namespace Tests\Feature;

use App\Http\Controllers\Controller;
use App\Models\Inventario;
use App\Models\User;
use Tests\TestCase;

class InventarioTest extends TestCase
{
    /** @var User */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /** @test */
    public function create_inventario()
    {
        $this->actingAs($this->user)
            ->postJson(route('inventarios.store'), [
                'name' => 'Lorem',
                'marca' => 'Ipsum',
                'TipoHardware' => 'Dolor',
                'Departamento' => 'Sit',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('inventarios', [
            'name' => 'Lorem',
            'marca' => 'Ipsum',
            'TipoHardware' => 'Dolor',
            'Departamento' => 'Sit',
        ]);
    }

    /** @test */
    public function update_inventario()
    {
        $inventario = Inventario::factory()->create();

        $this->actingAs($this->user)
            ->putJson(route('inventarios.update', $inventario->id), [
                'name' => 'Updated inventario',
                'marca' => 'Ipsum',
                'TipoHardware' => 'Dolor',
                'Departamento' => 'Sit',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('inventarios', [
            'id' => $inventario->id,
            'name' => 'Updated inventario',
            'marca' => 'Ipsum',
            'TipoHardware' => 'Dolor',
            'Departamento' => 'Sit',
        ]);
    }

    /** @test */
    public function show_inventario()
    {
        $inventario = Inventario::factory()->create();

        $this->actingAs($this->user)
            ->getJson(route('inventarios.show', $inventario->id))
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'name' => $inventario->name,
                ],
            ]);
    }

    /** @test */
    public function list_inventario()
    {
        $inventarios = Inventario::factory()->count(2)->create()->map(function ($inventario) {
            return $inventario->only(['id', 'name']);
        });

        $this->actingAs($this->user)
            ->getJson(route('inventarios.index'))
            ->assertSuccessful()
            ->assertJson([
                'data' => $inventarios->toArray(),
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
    public function delete_inventario()
    {
        $inventario = Inventario::factory()->create([
            'name' => 'Inventario for delete',
        ]);

        $this->actingAs($this->user)
            ->deleteJson(route('inventarios.update', $inventario->id))
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseMissing('inventarios', [
            'id' => $inventario->id,
            'name' => 'Inventario for delete',
        ]);
    }
}
