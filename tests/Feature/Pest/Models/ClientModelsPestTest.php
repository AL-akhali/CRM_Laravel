<?php

use App\Models\Client;
use App\Models\ClientContact;
use App\Models\ClientNote;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

it('has correct fillable attributes', function () {
    $client = new Client();

    expect($client->getFillable())->toEqual([
        'name',
        'type',
        'email',
        'phone',
        'industry',
        'address',
        'status',
    ]);
});

it('has correct casts', function () {
    $client = new Client();

    $expected = [
        'type' => 'string',
        'status' => 'string',
    ];

    foreach ($expected as $key => $type) {
        expect($client->getCasts())->toHaveKey($key, $type);
    }
});

it('has many contacts', function () {
    $client = Client::factory()->create();
    $contact = ClientContact::factory()->create(['client_id' => $client->id]);

    expect($client->contacts->contains($contact))->toBeTrue();
});

it('has many notes', function () {
    $client = Client::factory()->create();
    $note = ClientNote::factory()->create(['client_id' => $client->id]);

    expect($client->notes->contains($note))->toBeTrue();
});
