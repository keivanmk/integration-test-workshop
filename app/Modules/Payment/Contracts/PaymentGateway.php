<?php

namespace App\Modules\Payment\Contracts;

interface PaymentGateway
{
    public function pay(int $amount);

    public function refund(\App\Models\User $owner, int $total):bool;
}
