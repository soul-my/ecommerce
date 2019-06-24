<?php

namespace App\Models\Store;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Product;

class CartItem extends Model
{
    //
    protected $table = 'cart_items';
    protected $guarded = [];
    
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function scopeRelated($query)
    {
        return $query->with('product');
    }
}
