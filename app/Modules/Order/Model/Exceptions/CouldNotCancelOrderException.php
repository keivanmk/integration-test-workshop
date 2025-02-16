<?php

namespace App\Modules\Order\Model\Exceptions;

class CouldNotCancelOrderException extends \RuntimeException
{
    public const CAUSE_ITS_ALREADY_ON_PENDING_MSG = "این سفارش در حالت انتظار قرار دارد";

    public static function causeItsOnPendingStatus():self
    {
        return new CouldNotCancelOrderException(self::CAUSE_ITS_ALREADY_ON_PENDING_MSG);
    }
}
