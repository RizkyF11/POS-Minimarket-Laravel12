<?php

namespace App\Http\Controllers;

use App\Models\DailyReport;
use App\Models\Orders;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class LaporanController extends Controller
{
    public function laporan()
    {
        $orders = Orders::with(['user', 'details'])
        ->select('id_orders', 'invoice', 'id_user', 'total', 'created_at')
        ->get();

        return view('laporan.index', compact('orders'));
    }

    public function cetakPdf()
    {
        $orders = Orders::with(['user', 'details'])->get();

        //logic tambah laporan hari ini
        $today = Carbon::today();
        $laporan = DailyReport::firstOrCreate(
            ['report_date' => $today],
            ['print_count' => 0]
        );

        $laporan->increment('print_count'); // +1 untuk setiap cetak laporan

        //cetak pdf
        $pdf = PDF::loadView('laporan.pdf', compact('orders'));
        return $pdf->download('laporan.pdf');
    }
}
