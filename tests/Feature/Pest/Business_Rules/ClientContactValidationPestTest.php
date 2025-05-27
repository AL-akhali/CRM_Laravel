<?php

use App\Models\Client;
use App\Models\ClientContact;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

it('fails if the same email is used for the same client, but passes for different clients', function () {
    $client1 = Client::factory()->create();

    // جهة الاتصال الأولى بنفس البريد
    ClientContact::create([
        'client_id' => $client1->id,
        'name' => 'Contact One',
        'email' => 'contact@example.com',
        'phone' => '1234567890',
        'position' => 'Manager',
    ]);

    // محاولة التكرار مع نفس العميل
    $duplicateContact = [
        'client_id' => $client1->id,
        'name' => 'Contact Duplicate',
        'email' => 'contact@example.com',
        'phone' => '0987654321',
        'position' => 'Assistant',
    ];

    $rules = [
        'client_id' => 'required|exists:clients,id',
        'name' => 'required|string',
        'email' => [
            'required',
            'email',
            Rule::unique('client_contacts')->where(fn ($query) => $query->where('client_id', $duplicateContact['client_id'])),
        ],
        'phone' => 'nullable|string',
        'position' => 'nullable|string',
    ];

    $validator = Validator::make($duplicateContact, $rules);

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->toArray())->toHaveKey('email');

    // نفس البريد ولكن لعميل مختلف: يجب أن يمر
    $client2 = Client::factory()->create();

    $validContact = [
        'client_id' => $client2->id,
        'name' => 'Contact Valid',
        'email' => 'contact@example.com',
        'phone' => '5555555555',
        'position' => 'Director',
    ];

    $rulesForClient2 = [
        'client_id' => 'required|exists:clients,id',
        'name' => 'required|string',
        'email' => [
            'required',
            'email',
            Rule::unique('client_contacts')->where(fn ($query) => $query->where('client_id', $validContact['client_id'])),
        ],
        'phone' => 'nullable|string',
        'position' => 'nullable|string',
    ];

    $validator2 = Validator::make($validContact, $rulesForClient2);

    expect($validator2->fails())->toBeFalse();
});
