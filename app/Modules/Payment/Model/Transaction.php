<?php

namespace App\Modules\Payment\Model;

use App\Modules\Order\Model\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *@property int $order_id
 *@property Order $order
 *@property int $amount
 *@property int $status
 *@property string $reference_id
 *@property string $gateway
 */
class Transaction extends Model
{
    public const EMPTY_REFERENCE = "";

    public function order():BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public static function create(Order $order):Transaction
    {
        $trx = new Transaction;
        $trx->amount = $order->total;
        $trx->order()->associate($order);
        $trx->reference_id= self::EMPTY_REFERENCE;
        $trx->gateway = GATEWAY::ZARINPAL;
        $trx->status = TransactionStatus::PENDING;

        return $trx;

    }

    public static function refund(Order $order):Transaction
    {
        $trx = new Transaction;
        $trx->amount = -$order->total;
        $trx->order()->associate($order);
        $trx->reference_id= self::EMPTY_REFERENCE;
        $trx->gateway = GATEWAY::ZARINPAL;
        $trx->status = TransactionStatus::PENDING;

        return $trx;
    }

    public function successful():void
    {
        $this->status = TransactionStatus::SUCCEED;
    }

    public function fail():void
    {
        $this->status = TransactionStatus::FAILED;

    }

}
