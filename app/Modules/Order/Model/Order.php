<?php

namespace App\Modules\Order\Model;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 *@property User $owner
 *@property int  $owner_id
 *@property int $total
 *@property OrderStatus $status
 */
class Order extends Model
{

    public function owner():BelongsTo
    {
        return $this->belongsTo(User::class,'owner_id');
    }

    public function orderItems():HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function place(int $owner):Order
    {
        $order = new Order;
        $order->owner_id= $owner;
        $order->total = 0;
        $order->status = OrderStatus::PENDING;
        return $order;
    }

    public function addItems(Collection $orderItems):void
    {
        $this->total = $orderItems->reduce(fn($total,OrderItem $item) => $total+= $item->subTotal() ,0);
        $this->orderItems()->saveMany($orderItems);
    }


}
