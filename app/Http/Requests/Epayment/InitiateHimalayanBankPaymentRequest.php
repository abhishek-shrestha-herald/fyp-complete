<?php

namespace App\Http\Requests\Epayment;

use App\Exceptions\GyanValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;


class InitiateHimalayanBankPaymentRequest extends FormRequest
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
            'creditCardDetails' => [
                'required', 'array'
            ],
            'creditCardDetails.cardNumber' => [
                'string', 'min:13', 'max:19', 'required'
            ],
            'creditCardDetails.cardExpiryMMYY' => [
                'string', 'required', 'date_format:my'
            ],
            'creditCardDetails.cvvCode' => [
                'string', 'min:3', 'max:4', 'required'
            ],
            'creditCardDetails.payerName' => [
                'string', 'max:255', 'required'
            ],
            'plan_id' => [
                'required', 'exists:plans,id'
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
