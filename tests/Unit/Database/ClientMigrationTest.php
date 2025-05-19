<?php

namespace Tests\Unit;

use Tests\TestCase;   // مهم جداً - فئة Laravel للاختبارات
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Client;

class ClientMigrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_client_with_required_fields()
    {
        $client = Client::create([
            'name' => 'شركة جباري',
            'type' => 'شركة',
            'email' => 'info@jabari.com',
            'phone' => '123456789',
            'industry' => 'السياحة',
            'address' => 'غزة',
            'status' => 'active',
        ]);

        $this->assertEquals('شركة جباري', $client->name);
        $this->assertEquals('شركة', $client->type);
        $this->assertEquals('info@jabari.com', $client->email);
    }

    /** @test */
    public function name_and_email_must_be_unique()
    {
        Client::create([
            'name' => 'جباري',
            'type' => 'شركة',
            'email' => 'test@jabari.com',
            'phone' => '123456789',
            'industry' => 'السياحة',
            'address' => 'غزة',
            'status' => 'active',
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Client::create([
            'name' => 'جباري',
            'type' => 'شركة',
            'email' => 'test@jabari.com',
            'phone' => '987654321',
            'industry' => 'تجارة',
            'address' => 'رام الله',
            'status' => 'inactive',
        ]);
    }
}

