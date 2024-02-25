<?php

namespace App\Enums;

use App\Enums\Currency;
use App\Helpers\ModelResolver;
use App\Models\PaymentRecord;
use App\Payments\EsewaPayment;
use App\Payments\KhaltiPayment;
use App\Payments\Payment;
use App\Payments\SajiloPayPayment;
use Filament\Support\Contracts\HasLabel;

enum PaymentProvider: string implements HasLabel
{
    case ESEWA = 'esewa';
    case KHALTI = 'khalti';
    // case SAJILO_PAY = 'sajilo-pay';

    public function resolvePaymentCodeFromValidationResponse(array $data): PaymentRecord
    {
        $paymentCodeKey = match($this){
            self::ESEWA => 'oid',
            self::KHALTI => 'purchase_order_id',
            // self::SAJILO_PAY => 'transaction_id',
            default => null
        };

        $paymentCode = null;

        if(!is_null($paymentCodeKey) && isset($data[$paymentCodeKey]))
        {
            $paymentCode = $data[$paymentCodeKey];
        }

        if(is_null($paymentCode))
        {
            throw new \Exception("Payment code could not be resolved from data");
        }

        return (new ModelResolver(PaymentRecord::class, 'Payment Record'))
        ->resolve('code', $paymentCode)
        ->get();

    }

    public function paymentService(bool $isTestMode = true): Payment
    {

        return match($this){
            self::ESEWA => new EsewaPayment(
                $isTestMode
            ),
            self::KHALTI => new KhaltiPayment(
                $isTestMode
            ),
            // self::SAJILO_PAY => new SajiloPayPayment(
            //     isTestMode: $isTestMode
            // ),
        };
    }

    public function getAllowedCurrencies(): array
    {
        return match($this){
            self::ESEWA => [
                Currency::NPR
            ],
            self::KHALTI => [
                Currency::NPR
            ],
            // self::SAJILO_PAY => [
            //     Currency::NPR
            // ],
        };
    }

    public function getLabel(): ?string
    {
        return match($this){
            self::ESEWA => 'Esewa',
            self::KHALTI => 'Khalti',
            // self::SAJILO_PAY => 'Sajilo Pay',
        };
    }
}
