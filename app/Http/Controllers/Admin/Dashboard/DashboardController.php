<?php

namespace App\Http\Controllers\Admin\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Report\ReportService;

class DashboardController extends Controller
{
    //

    public function index()
    {
        $reportService = (new ReportService);

        return view('admin.dashboard', [
            'report' => $reportService,

        ]);
    }
}
