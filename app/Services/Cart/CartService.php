<?php

namespace App\Services\Cart;

use App\Models\Store\Cart;
use App\Models\Admin\Product;

use Cookie;
use Auth;
class CartService {

    protected $identifier;
    protected $cart;

    public function __construct()
    {
        //check if the cookie is exists
        $identifier = !Cookie::get('cart_identifier') ? md5(uniqid(microtime())) : Cookie::get('cart_identifier');
        $user_id = 0; //default user_id

        $user = Auth::guard('web')->user();
        if($user)
        {
            $user_id = $user->id;

            $cart = Cart::belongs($user_id)->statusInUse()->first();

            if(!$cart)
            {
                Cookie::forget('cart_identifier');

                //issue new identifier
                $identifier = md5(uniqid(microtime()));

                Cookie::queue(Cookie::forever('cart_identifier', $identifier));

            }

            if($cart && $cart->identifier != $identifier)
            {
                Cart::getCart($identifier)->delete();
                $identifier = $cart->identifier;
            }
        }

        //update/create the cart based on unique identifier
        Cart::updateOrCreate(
        [ 'identifier' => $identifier ],
        [
            'identifier' => $identifier,
            'user_id' => $user_id,
            'status' => 1,
        ]);
        //
        Cookie::queue(Cookie::forever('cart_identifier', $identifier));

        $this->identifier = Cookie::get('cart_identifier');
        $this->cart = Cart::getCart($this->identifier)->withAssociates()->first();

    }

    public function info()
    {
        return Cart::getCart($this->identifier)->withAssociates()->first();
    }

    public function addItem($product_id, $quantity)
    {

        $update = $this->cart->items()->updateOrCreate(
        [
            'cart_id' => $this->cart->id,
            'product_id' => $product_id,
        ],
        [
            "quantity" => $quantity,
        ]);
        $this->refresh();

        if($update)
        {
            return true;
        }

        return false;
    }

    public function updateItem($product_id, $quantity)
    {
        return $this->addItem($product_id, $quantity);
    }

    public function deleteItem($product_id)
    {
        $items = $this->getItems();
        foreach($items as $item)
        {
            if($item->product_id == $product_id)
            {
                $item->delete();
                $this->updateValue();
                $this->refresh();
                return true;
            }
        }

        return false;
    }

    public function getItems()
    {
        return $this->cart->items()->related()->get();
    }

    public function setStatus($status)
    {
        $this->cart->status = $status;
        if($this->cart->save())
        {
            return true;
        }

        return false;
    }

    public function totalItems()
    {
        return $this->cart->items->count();
    }

    public function updateValue()
    {
        //get all items
        $total = 0;
        foreach($this->cart->items as $item)
        {
            $total += ($item->product->pricing->sell_price * $item->quantity);
        }

        $this->cart->value = $total;
        if($this->cart->save())
        {
            $this->refresh();
            return true;
        }

        return false;
    }

    public function getTotalValue()
    {
        $this->updateValue();
        return $this->cart->value;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function refresh()
    {
        return $this->cart = $this->cart->fresh();
    }

    public function updateStatus($val)
    {
        $this->cart->status = $val;

        if($this->cart->save())
        {
            $this->refresh();
            return true;
        }

        return false;
    }
}
