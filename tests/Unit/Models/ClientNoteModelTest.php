<?php

namespace Tests\Unit\Models;

use App\Models\Client;
use App\Models\ClientNote;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientNoteModelTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_has_fillable_attributes()
    {
        $note = new ClientNote();

        $this->assertEquals([
            'client_id',
            'user_id',
            'content',
            'visibility',
        ], $note->getFillable());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_belongs_to_a_client()
    {
        $client = Client::factory()->create();
        $note = ClientNote::factory()->create(['client_id' => $client->id]);

        $this->assertInstanceOf(Client::class, $note->client);
        $this->assertEquals($client->id, $note->client->id);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_belongs_to_a_user()
    {
        $user = User::factory()->create();
        $note = ClientNote::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $note->user);
        $this->assertEquals($user->id, $note->user->id);
    }
}
