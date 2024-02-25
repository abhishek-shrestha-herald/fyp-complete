<?php

namespace App\Payments;

use App\Enums\Currency;
use App\Models\PaymentRecord;

abstract class Payment
{
    protected string $apiEndPoint;

    protected array $requestData;

    protected array $requestHeader;

    protected $errors = [];

    protected array $response;

    protected PaymentRecord $paymentRecord;
    protected Currency $currency = Currency::NPR;
    protected bool $isPaymentRecordSet = false;

    abstract public function setUp(array $args): Payment;

    abstract public function initiate(): Payment;

    abstract public function validate(array $args): bool;

    abstract public function redirectUrl(): string;

    protected function errorResponse($data = []): void
    {
        $this->errors = array_merge($this->errors, $data);

        $this->response = [
            'success' => false,
            'errors' => $this->errors,
        ];
    }

    public function checkError(): void
    {
        if(!$this->isPaymentRecordSet)
        {
            throw new \Exception("Payment record is not set");
        }
        if($this->hasErrors())
        {
            throw new \Exception("Payment has errors");
        }
    }

    public function payment(PaymentRecord $paymentRecord): Payment
    {
        $this->paymentRecord = $paymentRecord;
        $this->currency = $paymentRecord->currency;
        $this->isPaymentRecordSet = true;
        return $this;
    }

    protected function successResponse($data = []): void
    {
        $this->response = [
            'success' => true,
            'data' => $data,
        ];
    }

    public function hasErrors(): bool
    {
        return count($this->errors) != 0;
    }

    public function getResponse(): array
    {
        return $this->response;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getPayment(): PaymentRecord
    {
        $this->checkError();
        return $this->paymentRecord;
    }
}
