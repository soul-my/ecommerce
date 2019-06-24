<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Customer\User;
use \Carbon\Carbon;

class ParentOrder extends Model
{
    //
    protected $table = 'parent_orders';
    protected $guarded = [];

    const PAYMENT_UNPAID = 0;
    const PAYMENT_SUCCESSFUL = 1;
    const PAYMENT_REFUNDED = 2;
    const PAYMENT_WAS_DECLINED = 3;

    const ORDER_STATUS_RECEIVED = 0;
    const ORDER_STATUS_OUT_FOR_SHIPPING = 2;
    const ORDER_STATUS_CANCELLED = 3;
    const ORDER_STATUS_COMPLETED = 4;
    const ORDER_STATUS_REFUNDED = 5;

    protected $with = [
        'orders',
        'shippinglocation',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'parent_id', 'id');
    }

    public function shippinglocation()
    {
        return $this->hasOne(OrderShippingLocation::class, 'parent_order_id', 'id');
    }

    public function scopeTransactionsBetween($query, $from, $to)
    {
        return $query->whereBetween('created_at', [$from, $to]);
    }

    public function scopeFilter($query, $request)
    {
        return $query->where(function($query) use ($request)
        {
            if(isset($request['status']))
            {
                $query->where('status', $request['status']);
            }

            if(isset($request['search']))
            {
                $query->where('order_id', 'like', '%'. $request['search'] . '%')
                ->orWhere('txn', 'like', '%'. $request['search'] . '%');
            }
        });
    }

    public function grandTotal()
    {
        $total = 0;
        foreach($this->orders as $order)
        {
            $total += $order->total();
        }

        return $total;
    }

    public function statusText($upper = false)
    {
        $status = $this->status;
        $text = null;

        switch($status)
        {
            case ParentOrder::ORDER_STATUS_RECEIVED;
                $text = "received";
            break;

            case ParentOrder::ORDER_STATUS_OUT_FOR_SHIPPING;
                $text = "out for shipping";
            break;

            case ParentOrder::ORDER_STATUS_CANCELLED;
                $text = "cancelled";
            break;

            case ParentOrder::ORDER_STATUS_COMPLETED;
                $text = "completed";
            break;

            case ParentOrder::ORDER_STATUS_REFUNDED;
                $text = "refunded";
            break;

            default:
                $text = "unknown";
            break;
        }

        if($upper)
            return ucfirst($text);

        return $text;
    }

    public function paymentStatus($upper = false)
    {
        $status = $this->payment_status;
        $text = null;
        switch($status)
        {
            case ParentOrder::PAYMENT_UNPAID:
            $text = "unpaid";
            break;

            case ParentOrder::PAYMENT_SUCCESSFUL:
            $text = "success";
            break;

            case ParentOrder::PAYMENT_REFUNDED:
            $text = "refunded";
            break;

            case ParentOrder::PAYMENT_WAS_DECLINED:
            $text = "declined";
            break;

            default:
                $text = "unknown";
                break;
        }

        if($upper)
            return ucfirst($text);

        return $text;
    }
}
