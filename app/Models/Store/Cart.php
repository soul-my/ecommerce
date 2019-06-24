<?php

namespace App\Models\Store;

use Illuminate\Database\Eloquent\Model;
use App\Models\Customer\User;

class Cart extends Model
{
    //
    protected $table = 'carts';
    protected $guarded = [];

    const STATUS_ABANDON = 0;
    const STATUS_IN_USE = 1;
    const STATUS_SUCCESFUL_CHECKOUT = 2;

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function items()
    {
        return $this->hasMany(CartItem::class, 'cart_id', 'id');
    }

    public function scopeGetCart($query, $identifier)
    {
        return $query->where('identifier', $identifier);
    }

    public function scopeWithAssociates($query)
    {
        return $query->with('user')->with('items');
    }

    public function scopeStatusInUse($query)
    {
        return $query->where('status', self::STATUS_IN_USE);
    }

    public function scopeBelongs($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }

}
