<?php

namespace App\Payments;

use App\Helpers\DataValidator;
use App\Http\Requests\Epayment\ValidateSajiloPayPaymentRequest;
use Illuminate\Support\Facades\Http;

class SajiloPayPayment extends Payment
{
    private bool $isInitiated;

    public function __construct(bool $isTestMode = true)
    {
        if ($isTestMode) {
            $this->apiEndPoint = 'https://wallet.silkinv.com/api';
        } else {
            $this->apiEndPoint = " https://api.sajilopay.com.np/api";
        }
    }

    public function setUp(array $args): SajiloPayPayment
    {
        $this->requestData = [
            'vendor_key' => config('services.payments.sajilo-pay.vendor-key'),
            'title' => "E Agriculture",
            'description' => 'Payment for E Agriculture',
            'amount' => $this->paymentRecord->amount * 100,
            'transaction_id' => $this->paymentRecord->code,
            'response_url' => config('app.url') . '/payment/sajilo-pay/validate',
            'cancellation_url' => config('app.url') . '/payment/sajilo-pay/validate',
        ];
        return $this;
    }

    public function initiate(): SajiloPayPayment
    {
        $this->isInitiated = false;

        $this->checkError();

        $apiEndPoint = $this->apiEndPoint . '/merchant/process-payment';

        try {

            $response = Http::withHeaders([
                'Accepts' => 'application/json',
                'Content-Type' => 'application/json',
            ])->withOptions([
                'verify' => true,
            ])->post($apiEndPoint, $this->requestData);
        } catch (\Exception $e) {
            throw new \Exception("Failed to initiate transaction");
        }

        if (!$response->ok()) {
            $this->errorResponse([
                'status' => $response->status(),
                ...$response->json(),
            ]);
            throw new \Exception("Failed to initiate transaction");
        }

        $this->successResponse(
            $response->json()
        );

        $this->isInitiated = true;

        return $this;
    }

    public function redirectUrl(): string
    {
        if (!$this->isInitiated) {
            throw new \Exception(
                "Payment not initiated",
            );
        }

        $response = $this->getResponse();

        return $response['data']['redirect_url'];
    }

    public function validate(array $args): bool
    {

        $this->checkError();

        $validator = DataValidator::usingRequest($args, (new ValidateSajiloPayPaymentRequest));

        $args = $validator->safe()->toArray();

        $apiEndPoint = $this->apiEndPoint . '/merchant/check-transaction-status';

        $paymentValidationResponse = Http::withHeaders([
            'Accepts' => 'application/json',
        ])->post(
            $apiEndPoint,
            [
                'vendor_key' => config('services.payments.sajilo-pay.vendor-key'),
                'transaction_id' => $this->paymentRecord->code
            ]
        )
            ->json();

        if (
            strtolower($paymentValidationResponse['status']) != 'complete'
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
