<?php

use App\Models\Client;
use App\Models\ClientNote;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

it('has fillable attributes', function () {
    $note = new ClientNote();

    expect($note->getFillable())->toEqual([
        'client_id',
        'user_id',
        'content',
        'visibility',
    ]);
});

it('belongs to a client', function () {
    $client = Client::factory()->create();
    $note = ClientNote::factory()->create(['client_id' => $client->id]);

    expect($note->client)->toBeInstanceOf(Client::class)
        ->and($note->client->id)->toBe($client->id);
});

it('belongs to a user', function () {
    $user = User::factory()->create();
    $note = ClientNote::factory()->create(['user_id' => $user->id]);

    expect($note->user)->toBeInstanceOf(User::class)
        ->and($note->user->id)->toBe($user->id);
});
