<?php

use App\Models\Client;
use App\Models\ClientActivity;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

it('has fillable attributes', function () {
    $clientActivity = new ClientActivity();

    expect($clientActivity->getFillable())->toEqual([
        'client_id',
        'type',
        'description',
    ]);
});

it('belongs to a client', function () {
    $client = Client::factory()->create();

    $activity = ClientActivity::factory()->make([
        'client_id' => $client->id,
    ]);

    expect($activity->client)->toBeInstanceOf(Client::class);
});
