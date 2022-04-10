<?php

namespace Tests\Feature;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\User;
use Tests\TestCase;

class ProductoTest extends TestCase
{
    /** @var User */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /** @test */
    public function create_producto()
    {
        $this->actingAs($this->user)
            ->postJson(route('productos.store'), [
                'name' => 'Lorem',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('productos', [
            'name' => 'Lorem',
        ]);
    }

    /** @test */
    public function update_producto()
    {
        $producto = Producto::factory()->create();

        $this->actingAs($this->user)
            ->putJson(route('productos.update', $producto->id), [
                'name' => 'Updated producto',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('productos', [
            'id' => $producto->id,
            'name' => 'Updated producto',
        ]);
    }

    /** @test */
    public function show_producto()
    {
        $producto = Producto::factory()->create();

        $this->actingAs($this->user)
            ->getJson(route('productos.show', $producto->id))
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'name' => $producto->name,
                ],
            ]);
    }

    /** @test */
    public function list_producto()
    {
        $productos = Producto::factory()->count(2)->create()->map(function ($producto) {
            return $producto->only(['id', 'name']);
        });

        $this->actingAs($this->user)
            ->getJson(route('productos.index'))
            ->assertSuccessful()
            ->assertJson([
                'data' => $productos->toArray(),
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
    public function delete_producto()
    {
        $producto = Producto::factory()->create([
            'name' => 'Producto for delete',
        ]);

        $this->actingAs($this->user)
            ->deleteJson(route('productos.update', $producto->id))
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseMissing('productos', [
            'id' => $producto->id,
            'name' => 'Producto for delete',
        ]);
    }
}
