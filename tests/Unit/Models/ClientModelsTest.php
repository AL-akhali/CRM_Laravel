<?php

namespace Tests\Unit\Models;

use App\Models\Client;
use App\Models\ClientContact;
use App\Models\ClientNote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientModelsTest extends TestCase
{
    use RefreshDatabase;

    public function test_fillable_attributes(): void
    {
        $client = new Client();

        $this->assertEquals([
            'name',
            'type',
            'email',
            'phone',
            'industry',
            'address',
            'status',
        ], $client->getFillable());
    }

    public function test_casts(): void
{
    $client = new Client();

    $expected = [
        'type' => 'string',
        'status' => 'string',
    ];

    foreach ($expected as $key => $value) {
        $this->assertArrayHasKey($key, $client->getCasts());
        $this->assertEquals($value, $client->getCasts()[$key]);
    }
}

    public function test_has_many_contacts(): void
    {
        $client = Client::factory()->create();
        $contact = ClientContact::factory()->create(['client_id' => $client->id]);

        $this->assertTrue($client->contacts->contains($contact));
    }

    public function test_has_many_notes(): void
    {
        $client = Client::factory()->create();
        $note = ClientNote::factory()->create(['client_id' => $client->id]);

        $this->assertTrue($client->notes->contains($note));
    }
}
