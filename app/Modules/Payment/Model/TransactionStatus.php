<?php

namespace App\Modules\Payment\Model;

enum TransactionStatus:int
{
    case PENDING = 1;
    case SUCCEED = 2;
    case FAILED = 3;
}
