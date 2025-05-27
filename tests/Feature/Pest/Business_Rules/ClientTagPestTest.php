<?php

use App\Models\ClientTag;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

it('throws exception when creating duplicate tag name and slug', function () {
    ClientTag::create([
        'name' => 'Important',
        'slug' => 'important',
        'color' => 'red',
    ]);

    ClientTag::create([
        'name' => 'Important',
        'slug' => 'important',
        'color' => 'blue',
    ]);
})->throws(\Illuminate\Database\QueryException::class);

it('auto generates slug from name when not provided', function () {
    $tag = ClientTag::create([
        'name' => 'New Tag',
        // slug not provided, should auto-generate
    ]);

    expect($tag->slug)->toBe('new-tag');
});
