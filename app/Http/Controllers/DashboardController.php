<?php

namespace App\Http\Controllers;

use App\Models\DailyReport;
use App\Models\Orders;
use App\Models\Products;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUser = User::count();
        $totalTransaksi = Orders::count();
        $produkTersedia = Products::count();

        $today = Carbon::today();

        //ambil atau buat laporan hari ini
        $laporanHariIni = DailyReport::firstOrCreate(
            ['report_date' => $today],
            ['print_count' => 0]
        );

        return view('dashboard.index', compact('totalUser', 'totalTransaksi', 'produkTersedia', 'laporanHariIni'));
    }
}
