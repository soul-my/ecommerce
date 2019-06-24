<?php

namespace App\Http\Controllers\User\Store;

//laravel
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//models
use App\Models\Admin\Category;
use App\Models\Admin\Product;
use App\Models\Customer\User;

//services
use App\Services\Cart\CartService;
use Storage;
use Auth;
use App\Models\Admin\ParentOrder;

use Response;


class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filter = \Request::only('search');

        //categories
        $products = Product::activeProducts()->withAssociates()->filter($filter)->get();
        $cart = new CartService;
        // $items = (new CartService)->getItems();
        // foreach($items as $item)
        // {
        //     $product = $item->product->withAssociates();
        //     dd($product->get());
        //     //$item = $item->product()->withAssociates()->first();
        // }

        return view('store.home', compact('products', 'cart'));
    }

    public function showCart($identifier)
    {
        $header_class = 'header-v4';
        $cart = new CartService;
        $cart->updateValue();
        $shipping  = 12;

        $hidden_detail = $cart->info()->id.',';

        foreach($cart->getItems() as $item)
        {
            $hidden_detail .= $item->product_id . ':' . $item->quantity . ',';
        }
        return view('store.cart', compact('cart', 'header_class', 'shipping', 'hidden_detail'));
    }

    public function addToCart(Request $request)
    {
        $cart = new CartService;
        $add = $cart->addItem($request->pro_id, $request->quantity);

        if($add)
        {
            return back()->with('success', 'your item has been added to cart');
        }
    }

    public function removeFromCart($pro_id)
    {
        $cart = new CartService;
        $add = $cart->deleteItem($pro_id);

        if($add)
        {
            $cart->refresh();
            return back()->with('success', 'your item has been added to cart');
        }
    }

    public function myOrders()
    {
        $header_class = 'header-v4';
        $cart = new CartService;

        $orders = User::find(Auth::user()->id);
        $parentOrders = $orders->orders()->get();

        //dd($parentOrders);

        return view('store.order', compact('cart', 'header_class', 'parentOrders'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $product = Product::where('id', $id)->withAssociates()->first();

        return view('store.partials.detail', compact('product'));
    }

    public function cancelorder($order_id)
    {
        $orders = User::find(Auth::user()->id);
        $parentOrder = $orders->orders()->where('id', $order_id)->first();

        if($parentOrder->status != ParentOrder::ORDER_STATUS_OUT_FOR_SHIPPING)
        {
            $parentOrder->status = ParentOrder::ORDER_STATUS_CANCELLED;
            if($parentOrder->save())
            {
                //reimburse value of product quantity
                $parentOrder = $parentOrder->fresh();

                foreach($parentOrder->orders()->get() as $item)
                {
                    $product = Product::find($item->product_id);
                    $product->quantity = ($product->quantity + $item->quantity);
                    $product->quantity_sold = ($product->quantity_sold - $item->quantity);

                    $product->save();
                }

                return response()->json(['status' => true]);
            }
        }

        return response()->json(['status' => false]);
    }

    public function completeorder($order_id)
    {
        $orders = User::find(Auth::user()->id);
        $parentOrder = $orders->orders()->where('id', $order_id)->first();
        $parentOrder->status = ParentOrder::ORDER_STATUS_COMPLETED;

        if($parentOrder->save())
        {
            //reimburse value of product quantity
            $parentOrder = $parentOrder->fresh();
            return response()->json(['status' => true]);
        }

        return response()->json(['status' => false]);
    }

    public function updateQuantity($product_id, $quantity)
    {
        $cart = new CartService;
        $update = $cart->updateItem($product_id, $quantity);

        dd($update);
    }

    public function tos()
    {
        $cart = new CartService;
        $header_class = 'header-v4';

        return view('store.pages.tos', compact('cart', 'header_class'));
    }
}
