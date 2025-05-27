<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Client;
use App\Models\ClientTag;

uses(Tests\TestCase::class, RefreshDatabase::class);

it('checks if client_client_tag table exists', function () {
    expect(Schema::hasTable('client_client_tag'))->toBeTrue();
});

it('checks client_client_tag table has expected columns', function () {
    $expected = [
        'client_id',
        'client_tag_id',
    ];

    foreach ($expected as $column) {
        expect(Schema::hasColumn('client_client_tag', $column))->toBeTrue();
    }
});

it('enforces unique constraint on client_client_tag table', function () {
    $client = Client::factory()->create();
    $tag = ClientTag::factory()->create();

    DB::table('client_client_tag')->insert([
        'client_id' => $client->id,
        'client_tag_id' => $tag->id,
    ]);

    $this->expectException(\Illuminate\Database\QueryException::class);

    DB::table('client_client_tag')->insert([
        'client_id' => $client->id,
        'client_tag_id' => $tag->id,
    ]);
});
