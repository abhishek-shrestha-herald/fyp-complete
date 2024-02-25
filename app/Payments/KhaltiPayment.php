<?php

namespace App\Payments;

use App\Helpers\DataValidator;
use App\Http\Requests\Epayment\InitiateKhaltiPaymentRequest;
use App\Http\Requests\Epayment\ValidateKhaltiPaymentRequest;
use Illuminate\Support\Facades\Http;


class KhaltiPayment extends Payment
{
    private string $secretKey;

    private bool $isInitiated;

    public function __construct(bool $isTestMode = true)
    {
        if ($isTestMode) {
            $this->apiEndPoint = 'https://a.khalti.com/api/v2';
        } else {
            $this->apiEndPoint = "https://khalti.com/api/v2";
        }
        $this->secretKey = config('services.payments.khalti.secret-key');
        $this->isInitiated = false;
        $this->errors = [];
        $this->response = [];
    }

    public function setUp(array $args): KhaltiPayment
    {
        /**
         * returnUrl
         * websiteUrl
         * amount
         * purchaseOrderId
         * purchaseOrderName
         */

        $argsValidator = DataValidator::usingRequest($args, (new InitiateKhaltiPaymentRequest));

        $this->isInitiated = false;

        $data = $argsValidator->safe();

        $this->requestData = [
            'return_url' => config('app.url') . '/payment/khalti/validate',
            'website_url' => config('app.url'),
            'amount' => $this->paymentRecord->amount * 100,
            'purchase_order_id' => $this->paymentRecord->code,
            'purchase_order_name' => "Bill Payment for E Agriculture",
            'customer_info' => [
                'name' => $this->paymentRecord->user->name,
                'email' => $this->paymentRecord->user->email,
            ]
        ];

        return $this;
    }

    public function initiate(): KhaltiPayment
    {
        $this->isInitiated = false;


        if ($this->hasErrors()) {
            return $this;
        }

        $apiEndPoint = $this->apiEndPoint . '/epayment/initiate/';

        $response = Http::withHeaders([
            'Authorization' => 'Key ' . $this->secretKey,
        ])
            ->post($apiEndPoint, $this->requestData);


        if (!$response->ok()) {
            $this->errorResponse([
                'status' => $response->status(),
                ...$response->json(),
            ]);

            return $this;
        }

        $this->successResponse(
            $response->json()
        );

        $this->isInitiated = true;


        return $this;
    }

    public function redirectUrl(): string
    {
        $this->checkError();

        $response = $this->getResponse();

        return $response['data']['payment_url'];

    }

    public function validate(array $args): bool
    {
        $validator = DataValidator::usingRequest($args, (new ValidateKhaltiPaymentRequest));

        $args = $validator->safe()->toArray();

        $apiEndPoint = $this->apiEndPoint . '/epayment/lookup/';

        $paymentValidationResponse = Http::withHeaders([
            'Authorization' => 'Key ' . $this->secretKey
        ])->post(
                $apiEndPoint,
                [
                    'pidx' => $args['pidx']
                ]
            )
            ->json();

        if (
            strtolower($paymentValidationResponse['status']) != 'completed' ||
            $paymentValidationResponse['transaction_id'] != $args['transaction_id'] ||
            $paymentValidationResponse['total_amount'] != $args['amount'] ||
            $paymentValidationResponse['refunded']
        ) {
            $this->errorResponse($paymentValidationResponse);

            $this->paymentRecord->update([
                'validate_response' => $this->response
            ]);

            return false;
        }

        $this->successResponse($paymentValidationResponse);

        $this->paymentRecord->update([
            'validate_response' => $this->response
        ]);

        return true;
    }
}
