<?php

use App\Models\Client;
use App\Http\Requests\StoreClientRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

it('fails validation if name is not unique', function () {
    Client::create([
        'name' => 'مكرر',
        'email' => 'test1@example.com',
    ]);

    $data = [
        'name' => 'مكرر', // مكرر
        'email' => 'test2@example.com', // جديد
    ];

    $request = new StoreClientRequest();
    $validator = Validator::make($data, $request->rules());

    expect($validator->fails())->toBeTrue()
        ->and(array_key_exists('name', $validator->errors()->toArray()))->toBeTrue();
});

it('fails validation if email is not unique', function () {
    Client::create([
        'name' => 'Client A',
        'email' => 'duplicate@example.com',
    ]);

    $data = [
        'name' => 'Client B',
        'email' => 'duplicate@example.com', // مكرر
    ];

    $request = new StoreClientRequest();
    $validator = Validator::make($data, $request->rules());

    expect($validator->fails())->toBeTrue()
        ->and(array_key_exists('email', $validator->errors()->toArray()))->toBeTrue();
});
