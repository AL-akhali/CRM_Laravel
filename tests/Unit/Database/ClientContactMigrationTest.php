<?php

namespace Tests\Unit\Models;

use App\Models\Client;
use App\Models\ClientContact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientContactMigrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_client_contact_for_a_client()
    {
        $client = Client::factory()->create();

        $contact = ClientContact::create([
            'client_id' => $client->id,
            'name' => 'أحمد علي',
            'email' => 'ahmad@example.com',
            'phone' => '0599123456',
            'position' => 'مدير مبيعات',
        ]);

        $this->assertDatabaseHas('client_contacts', [
            'client_id' => $client->id,
            'email' => 'ahmad@example.com',
        ]);

        $this->assertEquals('أحمد علي', $contact->name);
        $this->assertEquals('0599123456', $contact->phone);
    }

    /** @test */
    public function email_must_be_unique_per_client()
    {
        $client = Client::factory()->create();

        ClientContact::create([
            'client_id' => $client->id,
            'name' => 'أحمد',
            'email' => 'ahmad@example.com',
            'phone' => '0599123456',
            'position' => 'مدير',
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        ClientContact::create([
            'client_id' => $client->id,
            'name' => 'خالد',
            'email' => 'ahmad@example.com', // نفس البريد
            'phone' => '0599111222',
            'position' => 'مشرف',
        ]);
    }
}
