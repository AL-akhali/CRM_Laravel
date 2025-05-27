<?php

use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class);

// تعريف القيم الصالحة
dataset('valid_activity_types', [
    'call',
    'email',
    'meeting',
    'note',
    'update',
]);

it('accepts valid activity types', function (string $type) {
    $data = ['type' => $type];
    $rules = ['type' => 'required|in:call,email,meeting,note,update'];

    $validator = Validator::make($data, $rules);

    expect($validator->fails())->toBeFalse();
})->with('valid_activity_types');

it('fails for invalid activity type', function () {
    $data = ['type' => 'invalid_type'];
    $rules = ['type' => 'required|in:call,email,meeting,note,update'];

    $validator = Validator::make($data, $rules);

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->toArray())->toHaveKey('type');
});
