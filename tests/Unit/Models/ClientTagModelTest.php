<?php

namespace Tests\Unit\Models;

use App\Models\Client;
use App\Models\ClientTag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientTagModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_fillable_fields(): void
    {
        $tag = new ClientTag([
            'name' => 'Important',
            'slug' => 'important',
            'color' => '#FF0000',
        ]);

        $this->assertEquals('Important', $tag->name);
        $this->assertEquals('important', $tag->slug);
        $this->assertEquals('#FF0000', $tag->color);
    }

    public function test_slug_is_generated_automatically(): void
    {
        $tag = ClientTag::create([
            'name' => 'VIP Client',
        ]);

        $this->assertEquals('vip-client', $tag->slug);
    }

    public function test_client_tag_relationship(): void
    {
        $client = Client::factory()->create();
        $tag = ClientTag::factory()->create();

        $client->tags()->attach($tag);

        $this->assertTrue($client->tags->contains($tag));
        $this->assertTrue($tag->clients->contains($client));
    }
}
