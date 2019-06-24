<?php

namespace App\Http\Controllers\User\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\ParentOrder;

class InvoiceController extends Controller
{
    //
    public function invoice($order_id)
    {
        $parentOrder = ParentOrder::where('order_id', $order_id)->first();

        //dd($parentOrder->user);
        return view('store.invoice.index', compact('parentOrder'));
    }
}
