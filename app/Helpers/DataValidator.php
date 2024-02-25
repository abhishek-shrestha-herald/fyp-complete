<?php

namespace App\Helpers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator as ValidatorInstance;

class DataValidator
{
    public static function usingRequest(array $data, FormRequest $request): ValidatorInstance
    {
        $validator = Validator::make(
            $data,
            $request->rules()
        );

        return self::validate($validator);
    }

    public static function usingRules(array $data, array $rules): ValidatorInstance
    {
        $validator = Validator::make(
            $data,
            $rules
        );

        return self::validate($validator);
    }

    private static function validate(ValidatorInstance $validator): ValidatorInstance
    {
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator;
    }
}
