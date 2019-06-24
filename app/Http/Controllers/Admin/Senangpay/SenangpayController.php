<?php

namespace App\Http\Controllers\Admin\Senangpay;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use App\Models\Admin\ParentOrder;
use App\Models\Admin\Order;
use App\Services\Cart\CartService;
use App\Models\Store\Cart;
use App\Models\Admin\OrderShippingLocation;
use App\Models\Admin\Product;

use Auth;
class SenangpayController extends Controller
{
    //

    private $merchant_id = '272153974587695';
    private $secretkey = '110-629';
    private $endpoint = 'https://sandbox.senangpay.my/payment/';

    //sample of response
    //successful payment
    // array:5 [▼
    //     "status_id" => "1"
    //     "order_id" => "919b117b51b6b75ddd8f384d4ebc293d"
    //     "transaction_id" => "15447259145521100"
    //     "msg" => "Payment_was_successful"
    //     "hash" => "a1c0946cae5c321b0572477dfefbdff8"
    // ]

    //unsuccessful payment
    // array:5 [▼
    //     "status_id" => "0"
    //     "order_id" => "919b117b51b6b75ddd8f384d4ebc293d"
    //     "transaction_id" => null
    //     "msg" => "Hash_value_is_incorrect"
    //     "hash" => "551e4cb93a61ee8f6a3a65aa693aab9c"
    // ]
    public function backend()
    {
        $response = request()->all();
        $cart = new CartService;
        $identifier = $cart->getIdentifier();

        if($identifier)
        {
            $parentOrder = ParentOrder::updateOrCreate(
                [
                    'order_id' => $response['order_id'],
                ],
                [
                    'order_id' => $response['order_id'],
                    'user_id' => Auth::user()->id,
                    'txn' => $response['transaction_id'],
                    'total_amount' => $cart->getTotalValue(),
                    'payment_status' => $response['status_id'],
                    'remark' => $response['msg'],
                ]);

            foreach($cart->getItems() as $item)
            {
                Order::updateOrCreate([
                    'parent_id' => $parentOrder->id,
                    'product_id' => $item->product->id,
                ],
                [
                    'parent_id' => $parentOrder->id,
                    'product_id' => $item->product->id,
                    'sell_price' => $item->product->pricing->sell_price,
                    'quantity' => $item->quantity,
                ]);

                //deduct product quantity add to sold quantity
                $product = Product::find($item->product_id);
                $product->quantity = ($product->quantity - $item->quantity);
                $product->quantity_sold = ($product->quantity_sold + $item->quantity);

                $product->save();
            }
        }

        if($response['status_id'] == 1)
        {
            $cart->updateStatus(Cart::STATUS_SUCCESFUL_CHECKOUT);

            return redirect()->route('store.orders.show');
        }

    }


    public function prepareRequest(Request $request)
    {
        $hashed_string = md5($this->secretkey.$request->detail.$request->amount.$request->order_id);
        $endpoint = $this->endpoint . $this->merchant_id;
        $body = [
            "order_id" => $request->order_id,
            "amount" => $request->amount,
            "detail" => $request->detail,
            "name" => $request->name,
            "addr_1" => $request->addr_1,
            "addr_2" => $request->addr_2,
            "addr_3" => $request->addr_3,
            "state" => $request->state,
            "city" => $request->city,
            "postcode" => $request->postcode,
            "phone" => $request->phone,
            "hash" => $hashed_string,
            "transaction_id" => uniqid(),
            "endpoint" => $endpoint,
        ];

        //create new transaction in parent order table, order shipping location and order details
        $cart = new CartService;
        $identifier = $cart->getIdentifier();

        if($identifier)
        {
            $parentOrder = ParentOrder::updateOrCreate(
            [
                'order_id' => $request->order_id,
            ],
            [
                'order_id' => $request->order_id,
                'user_id' => Auth::user()->id,
                'total_amount' => $request->amount,
                'status' => ParentOrder::PAYMENT_UNPAID,
            ]);

            $location = OrderShippingLocation::updateOrCreate(
            [
                'parent_order_id' => $parentOrder->id,
            ],
            [
                'receiver_name' => $request->name,
                'address_1' => $request->addr_1,
                'address_2' => $request->addr_2,
                'address_3' => $request->addr_3,
                'state' => $request->state,
                'city' => $request->city,
                'postcode' => $request->postcode,
                'phone_no' => $request->phone,
            ]);

            foreach($cart->getItems() as $item)
            {
                Order::updateOrCreate([
                    'parent_id' => $parentOrder->id,
                    'product_id' => $item->product->id,
                ],
                [
                    'parent_id' => $parentOrder->id,
                    'product_id' => $item->product->id,
                    'sell_price' => $item->product->pricing->sell_price,
                    'quantity' => $item->quantity,
                ]);
            }
        }

        return view('store.payment.payment', ['body' => $body]);
    }

    // private function sendRequest($body)
    // {

    //     $client = new Client();
    //     $response = $client->request('post', $endpoint, [
    //         "query" => $body
    //     ]);

    //     if($response->getStatusCode() == 200)
    //     {
    //         return true;
    //     }
    // }
}
