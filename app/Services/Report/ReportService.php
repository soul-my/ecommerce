<?php

namespace App\Services\Report;

use App\Models\Store\Cart;
use App\Models\Admin\Product;
use App\Models\Admin\ParentOrder;
use Carbon\Carbon;

class ReportService
{
    protected $fromToday;
    protected $toToday;

    protected $fromMonth;
    protected $toMonth;

    public function __construct()
    {
        $this->fromToday = Carbon::today();
        $this->toToday = (new Carbon)->endOfDay();

        $this->fromMonth = (new Carbon)->startOfMonth();
        $this->toMonth = (new Carbon)->endOfMonth();
    }

    public function dailyOrders()
    {
        $daily = ParentOrder::transactionsBetween($this->fromToday, $this->toToday)->get();

        return $daily;
    }

    public function completedOrders()
    {
        $completedOrders = ParentOrder::transactionsBetween($this->fromMonth, $this->toMonth)->where('status', 4)->get();

        return $completedOrders;
    }

    public function monthlySales()
    {
        $sales  = ParentOrder::transactionsBetween($this->fromMonth, $this->toMonth)->where('status', 4)->sum('total_amount');

        return $sales;
    }

    public function getPopularProducts($limit = 5, $thisMonth = true, $from = null, $to = null)
    {
        $popular = Product::orderBy('quantity_sold', 'desc')->limit($limit);

        if($thisMonth)
        {
            $popular = $popular->transactionsBetween($this->fromMonth, $this->toMonth)->get();
        }
        else
        {
            $popular = $popular->transactionsBetween($from, $to)->get();
        }


        return $popular;
    }

    public function getSoldOutProducts()
    {
        $soldout = Product::where('quantity', 0)->get();
        return $soldout;
    }

    public function getLoyalCustomers()
    {
        $loyalcust = ParentOrder::select('user_id', 'COUNT(id) as totalTransactions')->where('status', 2)->get();
    }
}
