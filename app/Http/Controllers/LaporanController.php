<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function laporan()
    {
        $orders = Orders::with(['user', 'details'])
        ->select('id_orders', 'invoice', 'id_user', 'total', 'created_at')
        ->get();

    return view('laporan.index', compact('orders'));
    }
}
