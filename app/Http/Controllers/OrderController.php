<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use App\Models\Orders;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function bayar(Request $request)
    {
        $keranjang = session()->get('keranjang', []);
        if (!$keranjang || count($keranjang) == 0) {
            return back()->with('error', 'Keranjang belanja kosong.');
        }

        DB::beginTransaction();
        try {
            // menghitung total harga dari keranjang secara manual
            $total = 0;
            foreach ($keranjang as $item) {
                $total += $item['harga'] * $item['jumlah'];
            }


            $order = Orders::create([
                'invoice' => 'INV-'. time(),
                'id_user' => Auth::id(),
                'total' => $total,
            ]);

            foreach ($keranjang as $item) {
                // dd($item);
                $product = Products::where('nama_product', $item['nama_produk'])->first();

                if (!$product) {
                    throw new \Exception("Produk {$item['nama_produk']} Tidak ditemukan di database.");
                }

                if ($product->stok < $item['jumlah']) {
                    throw new \Exception("Stok tidak mencukupi untuk produk {$product->nama_product}");
                }

                OrderDetail::create([
                    'id_orders' => $order->id_orders,
                    'id_product' => $product->id_product,
                    'nama_product' => $item['nama_produk'],
                    'qty' => $item['jumlah'],
                    'harga' => $item['harga'],
                ]);

                // //kurangi stok produk
                // $product = Products::findOrFail($item['id']);
                // if ($product->stok< $item['qty']) {
                //     throw new \Exception("Stok tidak mencukupi untuk produk {$product->nama_product}");
                // }
                $product->stok -= $item['jumlah'];
                $product->save();
            }

            session()->forget('keranjang');
            DB::commit();

            return redirect()->route('kasir')->with('success', 'Transaksi berhasil.');
        }catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Transaksi gagal:' . $e->getMessage());
        }
    }
}
