<?php

use App\Models\Client;
use App\Models\ClientTag;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

it('has fillable fields', function () {
    $tag = new ClientTag([
        'name' => 'Important',
        'slug' => 'important',
        'color' => '#FF0000',
    ]);

    expect($tag->name)->toBe('Important')
        ->and($tag->slug)->toBe('important')
        ->and($tag->color)->toBe('#FF0000');
});

it('generates slug automatically', function () {
    $tag = ClientTag::create([
        'name' => 'VIP Client',
    ]);

    expect($tag->slug)->toBe('vip-client');
});

it('has many-to-many relationship with clients', function () {
    $client = Client::factory()->create();
    $tag = ClientTag::factory()->create();

    $client->tags()->attach($tag);

    expect($client->tags->contains($tag))->toBeTrue()
        ->and($tag->clients->contains($client))->toBeTrue();
});
