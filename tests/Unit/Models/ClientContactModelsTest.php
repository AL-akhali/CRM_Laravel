<?php

namespace Tests\Unit;

use App\Models\Client;
use App\Models\ClientContact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientContactModelsTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_has_fillable_attributes(): void
    {
        $contact = new ClientContact();

        $this->assertEquals(
            ['client_id', 'name', 'email', 'phone', 'position'],
            $contact->getFillable()
        );
    }

    public function test_it_belongs_to_a_client(): void
    {
        $client = Client::factory()->create();
        $contact = ClientContact::factory()->create([
            'client_id' => $client->id,
        ]);

        $this->assertInstanceOf(Client::class, $contact->client);
        $this->assertEquals($client->id, $contact->client->id);
    }

    public function test_it_creates_contact_with_valid_data(): void
    {
        $client = Client::factory()->create();

        $contact = ClientContact::create([
            'client_id' => $client->id,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '123456789',
            'position' => 'Manager',
        ]);

        $this->assertDatabaseHas('client_contacts', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }
}
