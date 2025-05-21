<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    public function index()
    {
        $data['result'] = Products::all();
        return view('kasir.index', $data);
    }

    //tambah item ke keranjang
    public function tambahKeKeranjang(Request $request)
    {
        $product = Products::findOrFail($request->id_product);
        $keranjang = session()->get('keranjang', []);

        if(isset($keranjang[$request->id_product])) {
            $keranjang[$product->id_product]['jumlah'] += 1;
        }else {
            $keranjang[$product->id_product] = [
                'nama_produk'=> $product->nama_product,
                'harga'=> $product->harga,
                'stok'=> $product->stok,
                'jumlah'=> 1
            ];
        }

        session(['keranjang'=> $keranjang]);
        return redirect()->back()->with('success', 'item berhasil ditambahkan ke keranjang');
    }

    //tambah jumlah item di keranjang
    public function tambahJumlah($id)
    {
        $keranjang = session()->get('keranjang', []);

        if(isset($keranjang[$id])) {
            $keranjang[$id]['jumlah'] += 1;
            session(['keranjang'=> $keranjang]);
        }

        return redirect()->back();
    }

    //kurang jumlah item di keranjang
    public function kurangJumlah($id)
    {
        $keranjang = session()->get('keranjang', []);

        if(isset($keranjang[$id])) {
            $keranjang[$id]['jumlah'] -= 1;
            
            if($keranjang[$id]['jumlah'] <= 0) {
                unset($keranjang[$id]);
            }

            session(['keranjang' => $keranjang]);
        }

        return redirect()->back();
    }

    //hapus semua item di keranjang
    public function hapusSemua()
    {
        session()->forget('keranjang');
        return redirect()->back()->with('success', 'Keranjang dikosongkan');
    }
}
