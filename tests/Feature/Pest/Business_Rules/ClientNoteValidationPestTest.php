<?php

use Illuminate\Support\Facades\Validator;

uses(Tests\TestCase::class);

it('fails if content field is empty', function () {
    $data = [
        'content' => '',
    ];

    $rules = [
        'content' => 'required|string',
    ];

    $validator = Validator::make($data, $rules);

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->toArray())->toHaveKey('content');
});
