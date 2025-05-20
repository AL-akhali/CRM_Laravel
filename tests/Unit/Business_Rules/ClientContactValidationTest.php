<?php

namespace Tests\Feature\Client;

use App\Models\Client;
use App\Models\ClientContact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientContactValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_email_must_be_unique_per_client()
{
    $client1 = Client::factory()->create();

    ClientContact::create([
        'client_id' => $client1->id,
        'name' => 'Contact One',
        'email' => 'contact@example.com',
        'phone' => '1234567890',
        'position' => 'Manager',
    ]);

    $duplicateContact = [
        'client_id' => $client1->id,
        'name' => 'Contact Duplicate',
        'email' => 'contact@example.com',
        'phone' => '0987654321',
        'position' => 'Assistant',
    ];

    $rulesForClient1 = [
        'client_id' => 'required|exists:clients,id',
        'name' => 'required|string',
        'email' => [
            'required',
            'email',
            // هنا نمرر client_id الخاص بالعميل 1
            \Illuminate\Validation\Rule::unique('client_contacts')->where(fn ($query) => $query->where('client_id', $client1->id)),
        ],
        'phone' => 'nullable|string',
        'position' => 'nullable|string',
    ];

    $validator1 = \Validator::make($duplicateContact, $rulesForClient1);

    $this->assertTrue($validator1->fails());
    $this->assertArrayHasKey('email', $validator1->errors()->toArray());

    // عميل ثاني
    $client2 = Client::factory()->create();

    $validContact = [
        'client_id' => $client2->id,
        'name' => 'Contact Valid',
        'email' => 'contact@example.com', // نفس البريد لكن لعميل مختلف
        'phone' => '5555555555',
        'position' => 'Director',
    ];

    $rulesForClient2 = [
        'client_id' => 'required|exists:clients,id',
        'name' => 'required|string',
        'email' => [
            'required',
            'email',
            \Illuminate\Validation\Rule::unique('client_contacts')->where(fn ($query) => $query->where('client_id', $client2->id)),
        ],
        'phone' => 'nullable|string',
        'position' => 'nullable|string',
    ];

    $validator2 = \Validator::make($validContact, $rulesForClient2);

    $this->assertFalse($validator2->fails());
}

}
