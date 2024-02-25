<?php

namespace App\Livewire;

use App\Enums\PaymentProvider;
use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;

class CartPayment extends Component
{

    use WireToast;

    public float $amount = 0.0;
    public ?string $paymentProvider = null;

    public function mount(float $amount)
    {
        $this->amount = $amount;
    }

    protected function checkAmount()
    {
        if ($this->amount < 10) {
            $this->paymentProvider = null;

            toast()
                ->danger("Minimum checkout amount is NRs. 10")
                ->push();
        }
    }

    public function selectPaymentProvider(string $paymentProvider)
    {
        $paymentProvider = PaymentProvider::tryFrom($paymentProvider);

        if (is_null($paymentProvider)) {
            $this->paymentProvider = null;
            return;
        }

        $this->paymentProvider = $paymentProvider->value;

        $this->checkAmount();
    }

    public function render()
    {
        return view('livewire.cart-payment');
    }
}
