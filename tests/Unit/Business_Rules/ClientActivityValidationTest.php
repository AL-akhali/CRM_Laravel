<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Validator;

class ClientActivityValidationTest extends TestCase
{
    /** @test */
    public function type_must_be_a_valid_enum_value()
    {
        $validTypes = ['call', 'email', 'meeting', 'note', 'update'];

        foreach ($validTypes as $type) {
            $data = ['type' => $type];
            $rules = ['type' => 'required|in:call,email,meeting,note,update'];

            $validator = Validator::make($data, $rules);
            $this->assertFalse($validator->fails(), "Validation failed for valid type: $type");
        }

        // اختبار قيمة غير صالحة
        $data = ['type' => 'invalid_type'];
        $rules = ['type' => 'required|in:call,email,meeting,note,update'];

        $validator = Validator::make($data, $rules);
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('type', $validator->errors()->messages());
    }
}

