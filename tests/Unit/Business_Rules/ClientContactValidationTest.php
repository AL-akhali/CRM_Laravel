<?php

namespace Tests\Unit;

use App\Models\Client;
use App\Models\ClientContact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Tests\TestCase;

class ClientContactValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_must_be_unique_per_client()
    {
        $client1 = Client::factory()->create();

        // إنشاء جهة اتصال بالعميل الأول بنفس البريد
        ClientContact::create([
            'client_id' => $client1->id,
            'name' => 'Contact One',
            'email' => 'contact@example.com',
            'phone' => '1234567890',
            'position' => 'Manager',
        ]);

        // محاولة إضافة جهة اتصال أخرى بنفس البريد للعميل نفسه
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
        $this->assertTrue($validator->fails(), 'Should fail when using same email for same client');
        $this->assertArrayHasKey('email', $validator->errors()->toArray());

        // إنشاء عميل جديد
        $client2 = Client::factory()->create();

        // نفس البريد لكن لعميل مختلف: يجب أن ينجح
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
        $this->assertFalse($validator2->fails(), 'Should pass when using same email for different client');
    }
}
