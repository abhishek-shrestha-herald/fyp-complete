<?php

namespace App\Payments;

class NullPayment extends Payment
{

    public function __construct() {

    }

    public function setUp(array $args): NullPayment
    {
        return $this;
    }

    public function initiate(): NullPayment
    {
        return $this;
    }

    public function redirectUrl(): string
    {
        return config('app.url');
    }

    public function validate(array $args): bool
    {
        return true;
    }
}
