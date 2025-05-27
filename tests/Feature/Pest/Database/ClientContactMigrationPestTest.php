<?php

use App\Models\Client;
use App\Models\ClientContact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\QueryException;

uses(Tests\TestCase::class, RefreshDatabase::class);

it('checks if client_contacts table exists', function () {
    expect(Schema::hasTable('client_contacts'))->toBeTrue();
});

it('checks client_contacts table has expected columns', function () {
    $expected = [
        'id',
        'client_id',
        'name',
        'email',
        'phone',
        'position',
        'created_at',
        'updated_at',
    ];

    foreach ($expected as $column) {
        expect(Schema::hasColumn('client_contacts', $column))->toBeTrue();
    }
});

it('ensures email is unique per client', function () {
    $client = Client::factory()->create();

    ClientContact::create([
        'client_id' => $client->id,
        'name' => 'Contact One',
        'email' => 'test@example.com',
    ]);

    $this->expectException(QueryException::class);

    ClientContact::create([
        'client_id' => $client->id,
        'name' => 'Contact Two',
        'email' => 'test@example.com',
    ]);
});
