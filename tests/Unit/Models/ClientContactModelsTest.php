<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Client;
use App\Models\ClientContact;

class ClientContactModelsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_client()
    {
        $client = Client::factory()->create();
        $contact = ClientContact::factory()->create(['client_id' => $client->id]);

        $this->assertInstanceOf(Client::class, $contact->client);
        $this->assertEquals($client->id, $contact->client->id);
    }

    /** @test */
    public function it_creates_contact_with_valid_data()
    {
        $client = Client::factory()->create();

        $contact = ClientContact::create([
            'client_id' => $client->id,
            'name' => 'Ahmad Saleh',
            'email' => 'ahmad@example.com',
            'phone' => '123456789',
            'position' => 'Manager',
        ]);

        $this->assertDatabaseHas('client_contacts', [
            'client_id' => $client->id,
            'email' => 'ahmad@example.com',
        ]);
    }

    /** @test */
    public function it_fails_if_email_is_not_unique_per_client()
    {
        $client = Client::factory()->create();

        ClientContact::create([
            'client_id' => $client->id,
            'name' => 'First',
            'email' => 'duplicate@example.com',
            'phone' => '123',
            'position' => 'HR',
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        ClientContact::create([
            'client_id' => $client->id,
            'name' => 'Second',
            'email' => 'duplicate@example.com', // same email for same client
            'phone' => '456',
            'position' => 'Manager',
        ]);
    }
}
