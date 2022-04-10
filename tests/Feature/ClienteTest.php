<?php

namespace Tests\Feature;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\User;
use Tests\TestCase;

class ClienteTest extends TestCase
{
    /** @var User */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /** @test */
    public function create_cliente()
    {
        $this->actingAs($this->user)
            ->postJson(route('clientes.store'), [
                'name' => 'Lorem',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('clientes', [
            'name' => 'Lorem',
        ]);
    }

    /** @test */
    public function update_cliente()
    {
        $cliente = Cliente::factory()->create();

        $this->actingAs($this->user)
            ->putJson(route('clientes.update', $cliente->id), [
                'name' => 'Updated cliente',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('clientes', [
            'id' => $cliente->id,
            'name' => 'Updated cliente',
        ]);
    }

    /** @test */
    public function show_cliente()
    {
        $cliente = Cliente::factory()->create();

        $this->actingAs($this->user)
            ->getJson(route('clientes.show', $cliente->id))
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'name' => $cliente->name,
                ],
            ]);
    }

    /** @test */
    public function list_cliente()
    {
        $clientes = Cliente::factory()->count(2)->create()->map(function ($cliente) {
            return $cliente->only(['id', 'name']);
        });

        $this->actingAs($this->user)
            ->getJson(route('clientes.index'))
            ->assertSuccessful()
            ->assertJson([
                'data' => $clientes->toArray(),
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
    public function delete_cliente()
    {
        $cliente = Cliente::factory()->create([
            'name' => 'Cliente for delete',
        ]);

        $this->actingAs($this->user)
            ->deleteJson(route('clientes.update', $cliente->id))
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseMissing('clientes', [
            'id' => $cliente->id,
            'name' => 'Cliente for delete',
        ]);
    }
}
