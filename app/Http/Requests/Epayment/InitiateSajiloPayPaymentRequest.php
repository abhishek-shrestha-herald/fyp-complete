<?php

namespace App\Http\Requests\Epayment;

use App\Exceptions\GyanValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;


class InitiateSajiloPayPaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'amount' => [
                'required'
            ]
        ];
    }



    public function all($keys = null)
    {
        return array_merge(
            parent::all($keys),
            $this->route()->parameters()
        );
    }
}
