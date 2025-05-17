<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    use ValidatesRequests;
    public function index()
    {
        $data['result'] = \App\Models\Products::all();
        return view('products/index')->with($data);
    }

    public function create()
    {
        return view('products/form');

    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_product' => 'required|max:100',
            'stok' => 'required|max:100',
            'harga' => 'required|numeric|min:0',
            'id_category' => 'required|exists:categories,id_category',
            'gambar_product' => 'required|mimes:jpeg,jpg,png|max:512',
        ]);


        $input = $validated;

        // menambah SKU
        do {
            $generatedSku = 'PROD-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        }while (Products::where('sku', $generatedSku)->exists());

        $input['sku'] = $generatedSku;

        //end sku

        if ($request->hasFile('gambar_product') && $request->file('gambar_product')->isValid()) {
            // Simpan ke storage/app/public/products
            $filename = $request->file('gambar_product')->store('products', 'public');
    
            // Tambahkan ke input
            $input['gambar_product'] = $filename;
        }
        $status = \App\Models\Products::create($input);


        if($status) return redirect('products')->with('success', 'Data berhasil disimpan');
        else return redirect('products')->with('error', 'Data gagal ditambahkan');
    }



    public function edit($id)
    {
        $data['result'] = \App\Models\Products::where('id_product', $id)->first();
        return view('products/form')->with($data);
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_product' => 'required|max:100',
            'stok' => 'required|max:100',
            'harga' => 'required|numeric|min:0',
            'id_category' => 'required|exists:categories,id_category',
            'gambar_product' => 'nullable|mimes:jpeg,jpg,png|max:1024',
        ]);

        $input = $validated;
        // dd($input);
        // $result = \App\Models\Products::where('id_category', $id)->first();
        $product = Products::where('id_product', $id)->first();
        //pertahan sku
         $input['sku'] = $product->sku;
        //end sku

        if ($request->hasFile('gambar_product') && $request->file('gambar_product')->isValid()) {
            if ($product->gambar_product) {
                Storage::disk('public')->delete($product->gambar_product);
             }
            // Simpan ke storage/app/public/products
            $filename = $request->file('gambar_product')->store('products', 'public');
            // Tambahkan ke input
            $input['gambar_product'] = $filename;

        }

        $status = $product->update($input);
        // dd($product, $status);

        if ($status) return redirect('products')->with('success', 'Data berhasil diubah');
        else return redirect('products')->with('error', 'Data gagal diubah');
    }



    public function destroy(Request $request, $id)
    {
        $result = \App\Models\Products::where('id_product', $id)->first();
        $status = $result->delete();

        if ($status) return redirect('products')->with('success', 'Data berhasil dihapus');
        else return redirect('products')->with('error', 'Data gagal dihapus');


    }
    
}
