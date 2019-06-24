<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Services\Cart\CartService;

class CartComposer
{
    protected $cart;

    public function __construct(CartService $cart)
    {
        $this->cart = $cart;
    }


    public function compose(View $view)
    {
        $items = $this->cart->getItems();

        $view
        ->with('cart', $this->cart)
        ->with('items', $items);
    }
}