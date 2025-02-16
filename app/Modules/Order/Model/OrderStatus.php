<?php

namespace App\Modules\Order\Model;

enum OrderStatus:int
{
    case PENDING =1;
    case CONFIRMED = 2;
    case CANCELED = 3;
}
