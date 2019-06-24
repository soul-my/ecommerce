<?php

namespace App\Http\Controllers\Admin\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\ParentOrder;
use function GuzzleHttp\json_encode;
use App\Models\Admin\OrderShippingLocation;

class OrderController extends Controller
{
    //
    public function listing()
    {
        //
        $request = \Request::only('status', 'search');
        $orders = ParentOrder::filter($request)->get();
        return view('admin.orders.listing', ['parentOrders' => $orders, 'request' => $request]);
    }

    public function trackerModal($parent_id)
    {
        $parentOrder = ParentOrder::find($parent_id);
        return view('admin.partials.trackercontent', compact('parentOrder'));
    }

    public function trackerSubmit(Request $request)
    {
        $parentOrder = ParentOrder::find($request->parent_id);
        $parentOrder->status = ParentOrder::ORDER_STATUS_OUT_FOR_SHIPPING;
        $parentOrder->tracking = $request->tracking_no;

        if($parentOrder->save())
        {
            return back()->with('status', 'tracking no has been updated');
        }
    }

    public function shippingDetail($shipping_id)
    {
        $shipping  = OrderShippingLocation::find($shipping_id);

        return view('admin.partials.shippingcontent', compact('shipping'));
    }

    public function refund($order_id)
    {
        $parentOrder = ParentOrder::where('order_id', $order_id)->first();
        $parentOrder->status = ParentOrder::ORDER_STATUS_REFUNDED;

        if($parentOrder->save())
        {
            //reimburse value of product quantity
            $parentOrder = $parentOrder->fresh();
            return response()->json(['status' => true]);
        }

        return response()->json(['status' => false]);
    }
}
