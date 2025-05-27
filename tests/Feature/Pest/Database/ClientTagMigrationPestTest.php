<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

uses(Tests\TestCase::class, RefreshDatabase::class);

it('checks if client_tags table exists', function () {
    expect(Schema::hasTable('client_tags'))->toBeTrue();
});

it('checks client_tags table has expected columns', function () {
    $expected = [
        'id',
        'name',
        'slug',
        'color',
        'created_at',
        'updated_at',
    ];

    foreach ($expected as $column) {
        expect(Schema::hasColumn('client_tags', $column))->toBeTrue();
    }
});

it('ensures name and slug are unique', function () {
    DB::table('client_tags')->insert([
        'name' => 'VIP',
        'slug' => 'vip',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $this->expectException(\Illuminate\Database\QueryException::class);

    DB::table('client_tags')->insert([
        'name' => 'VIP',  // مكرر
        'slug' => 'vip',  // مكرر
        'created_at' => now(),
        'updated_at' => now(),
    ]);
});
