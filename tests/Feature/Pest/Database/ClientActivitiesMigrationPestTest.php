<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;

uses(Tests\TestCase::class, RefreshDatabase::class);

it('checks if client_activities table exists', function () {
    expect(Schema::hasTable('client_activities'))
        ->toBeTrue();
});

it('checks client_activities table has required columns', function () {
    $expectedColumns = [
        'id',
        'client_id',
        'type',
        'description',
        'created_at',
        'updated_at',
    ];

    foreach ($expectedColumns as $column) {
        expect(Schema::hasColumn('client_activities', $column))
            ->toBeTrue();
    }
});
