<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;

uses(Tests\TestCase::class, RefreshDatabase::class);

it('checks if client_notes table exists', function () {
    expect(Schema::hasTable('client_notes'))->toBeTrue();
});

it('checks client_notes table has expected columns', function () {
    $columns = [
        'id',
        'client_id',
        'user_id',
        'content',
        'visibility',
        'created_at',
        'updated_at',
    ];

    foreach ($columns as $column) {
        expect(Schema::hasColumn('client_notes', $column))->toBeTrue();
    }
});
