<?php

use App\Models\Client;
use App\Models\ClientContact;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

it('has fillable attributes', function () {
    $contact = new ClientContact();

    expect($contact->getFillable())->toEqual([
        'client_id', 'name', 'email', 'phone', 'position',
    ]);
});

it('belongs to a client', function () {
    $client = Client::factory()->create();
    $contact = ClientContact::factory()->create([
        'client_id' => $client->id,
    ]);

    expect($contact->client)->toBeInstanceOf(Client::class);
    expect($contact->client->id)->toEqual($client->id);
});

it('creates contact with valid data', function () {
    $client = Client::factory()->create();

    $contact = ClientContact::create([
        'client_id' => $client->id,
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '123456789',
        'position' => 'Manager',
    ]);

    expect($contact)->toBeInstanceOf(ClientContact::class);
    expect($contact->name)->toBe('John Doe');
    expect($contact->email)->toBe('john@example.com');

    $this->assertDatabaseHas('client_contacts', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);
});
