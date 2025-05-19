<?php

namespace Tests\Unit\Models;

use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientModelsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_client_with_valid_data()
    {
        $data = [
            'name' => 'شركة جباري',
            'type' => 'شركة',
            'email' => 'info@jabari.com',
            'phone' => '123456789',
            'industry' => 'السياحة',
            'address' => 'غزة',
            'status' => 'فعال',
        ];

        $client = Client::create($data);

        $this->assertDatabaseHas('clients', [
            'email' => 'info@jabari.com',
        ]);

        $this->assertEquals('شركة جباري', $client->name);
        $this->assertEquals('شركة', $client->type);
        $this->assertEquals('فعال', $client->status);
    }

    /** @test */
    public function name_and_email_are_required()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        Client::create([
            // No name or email
            'type' => 'شركة',
            'status' => 'فعال',
        ]);
    }
}
