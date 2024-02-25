<?php

namespace App\Payments;

use App\Helpers\DataValidator;
use App\Http\Requests\Epayment\ValidateEsewaPaymentRequest;
use Illuminate\Support\Facades\Http;


class EsewaPayment extends Payment
{
    private string $scd;

    private bool $isInitiated;

    public function __construct(bool $isTestMode = true)
    {
        if ($isTestMode) {
            $this->apiEndPoint = 'https://uat.esewa.com.np/epay';
        } else {
            $this->apiEndPoint = "https://esewa.com.np/epay";
        }
        $this->scd = config('services.payments.esewa.scd');
        $this->isInitiated = false;
        $this->errors = [];
        $this->response = [];
    }

    public function setUp(array $args): EsewaPayment
    {
        /**
         * amount
         * taxAmount
         * productServiceCharge
         * productDeliveryCharge
         * productId
         * successUrl
         * failureUrl
         */

        $this->checkError();

        $notFilled = [
            // 'taxAmount' =>  $this->paymentRecord->amount*0.13,
            'taxAmount' =>  0,
            'productServiceCharge' => 0,
            'productDeliveryCharge' => 0,
        ];

        $data = array_merge($notFilled, $args);

        $data['totalAmount'] = $this->paymentRecord->amount + $data['productServiceCharge'] + $data['productDeliveryCharge'] + $data['taxAmount'];

        $this->requestData = [
            'amt' => $this->paymentRecord->amount,
            'psc' => $data['productServiceCharge'],
            'pdc' => $data['productDeliveryCharge'],
            'txAmt' => $data['taxAmount'],
            'tAmt' => $data['totalAmount'],
            'pid' => $this->paymentRecord->code,
            'scd' => $this->scd,
            'su' => config('app.url') . '/payment/esewa/validate',
            'fu' => config('app.url') . '/payment/esewa/validate',
        ];

        return $this;
    }

    public function initiate(): EsewaPayment
    {
        $this->isInitiated = false;

        if ($this->hasErrors()) {
            return $this;
        }

        $this->isInitiated = true;

        return $this;
    }

    public function redirectUrl(): string
    {
        $this->checkError();

        return $this->apiEndPoint . '/main?' . http_build_query($this->requestData);

    }

    public function validate(array $args): bool
    {
        $validator = DataValidator::usingRequest($args, (new ValidateEsewaPaymentRequest));


        $args = $validator->safe()->toArray();

        $apiEndPoint = $this->apiEndPoint . '/transrec';

        $paymentValidationResponse = Http::get($this->apiEndPoint . '/transrec', [
            'amt' => $args['amt'],
            'rid' => $args['refId'],
            'pid' => $args['oid'],
            'scd' => $this->scd
        ]);

        $paymentResponse = trim(
            simplexml_load_string($paymentValidationResponse->body())->response_code
        );

        if (
            strtolower($paymentResponse) != 'success'
        ) {
            $this->errorResponse([
                'esewa' => $paymentResponse
            ]);
            return false;
        }

        $this->successResponse([
            'esewa' => $paymentResponse
        ]);

        return true;
    }
}
