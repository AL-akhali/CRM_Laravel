<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Validator;

class ClientNoteValidationTest extends TestCase
{
    /** @test */
    public function content_field_must_not_be_empty()
    {
        $data = [
            'content' => '',  // فارغ - يجب أن يفشل
        ];

        $rules = [
            'content' => 'required|string',
        ];

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('content', $validator->errors()->messages());
    }
}
