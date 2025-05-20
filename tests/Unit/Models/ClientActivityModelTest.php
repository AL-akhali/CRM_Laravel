<?php

namespace Tests\Unit\Models;

use App\Models\Client;
use App\Models\ClientActivity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientActivityModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_fillable_attributes()
    {
        $clientActivity = new ClientActivity();

        $this->assertEquals([
            'client_id',
            'type',
            'description',
        ], $clientActivity->getFillable());
    }

    /** @test */
    public function it_belongs_to_a_client()
    {
        $client = Client::factory()->create();

        $activity = ClientActivity::factory()->make([
            'client_id' => $client->id,
        ]);

        $this->assertInstanceOf(Client::class, $activity->client);
    }
}
