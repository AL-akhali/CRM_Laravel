<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

test('clients table exists', function () {
    expect(Schema::hasTable('clients'))->toBeTrue();
});

test('clients table has expected columns', function () {
    $expected = [
        'id',
        'name',
        'type',
        'email',
        'phone',
        'industry',
        'address',
        'status',
        'created_at',
        'updated_at',
    ];

    foreach ($expected as $column) {
        expect(Schema::hasColumn('clients', $column))->toBeTrue("Missing column: $column");
    }
});
