<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $table = "order_details";
    protected $guarded = [];

    protected $with = [
        'product',
    ];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function total()
    {
        return $this->quantity * $this->sell_price;
    }
}
