<?php

namespace App\Modules\Cart\Tests;

use UserVerifier;

class PaymentService
{

    public function __construct(private UserVerifier $userVerifier)
    {
    }

    public function pay():void
    {
        $this->userVerifier->verify();
    }
}
