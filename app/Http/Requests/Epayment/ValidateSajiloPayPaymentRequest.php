<?php

namespace App\Http\Requests\Epayment;

use App\Exceptions\GyanValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;


class ValidateSajiloPayPaymentRequest extends FormRequest
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
            'process_id' => [
                'required', 'string'
            ],
            'amount' => [
                'required', 'string'
            ],
            'customer' => [
                'required', 'string'
            ],
            'merchant' => [
                'required', 'string'
            ],
            'transaction_id' => [
                'required', 'string'
            ],
            'status' => [
                'required', 'string'
            ],
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
