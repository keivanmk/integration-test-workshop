<?php

namespace App\Modules\Order\Contracts;

interface TaxProviderInterface
{
    public function rate():int;
}
