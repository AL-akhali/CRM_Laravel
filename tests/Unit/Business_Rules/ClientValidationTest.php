<?php

namespace Tests\Unit\Requests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;
use App\Models\Client;
use App\Http\Requests\StoreClientRequest;

class ClientValidationTest extends TestCase
{
    use RefreshDatabase; // ← مهم جدًا

    public function test_name_must_be_unique()
    {
        Client::create([
            'name' => 'مكرر',
            'email' => 'test1@example.com',
        ]);

        $request = new StoreClientRequest();

        $data = [
            'name' => 'مكرر', // مكرر
            'email' => 'test2@example.com', // جديد
        ];

        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('name', $validator->errors()->toArray());
    }

    public function test_email_must_be_unique()
    {
        Client::create([
            'name' => 'Client A',
            'email' => 'duplicate@example.com',
        ]);

        $request = new StoreClientRequest();

        $data = [
            'name' => 'Client B',
            'email' => 'duplicate@example.com', // مكرر
        ];

        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('email', $validator->errors()->toArray());
    }
}
