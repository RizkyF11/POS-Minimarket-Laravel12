<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;

class CategoriesController extends Controller
{
    use ValidatesRequests;
    public function index()
    {
        $data['result'] = \App\Models\Categories::all();
        return view('category/index')->with($data);

    }

    public function create()
    {
        return view('category/form');
    }

    public function store(Request $request)
    {
        $rules = [
            'nama_kategori' => 'required|max:100',
            'deskripsi'     => 'required|max:100',
        ];

        $this->validate($request, $rules);

        $input = $request->all();
        $status = \App\Models\Categories::create($input);

        if ($status) return redirect('/categories')->with('success', 'Data berhasil disimpan');
        else return redirect('/categories')->with('error', 'Data gagal ditambahkan');
    }

    public function edit($id)
    {
        $data['result'] = \App\Models\Categories::where('id_category', $id)->first();
        return view('category/form')->with($data);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'nama_kategori' => 'required|max:100',
            'deskripsi'     => 'required|max:100',
        ];

        $this->validate($request, $rules);

        $input = $request->all();
        $result = \App\Models\Categories::where('id_category', $id)->first();
        $status = $result->update($input);

        if ($status) return redirect('/categories')->with('success', 'Data berhasil diubah');
        else return redirect('/categories')->with('error', 'Data gagal diubah');
    }

    public function destroy(Request $request, $id)
    {
        $result = \App\Models\Categories::where('id_category', $id)->first();
        $status = $result->delete();

        if ($status) return redirect('/categories')->with('success', 'Data berhasil dihapus');
        else return redirect('/categories')->with('error', 'Data gagal dihapus');
    }
}
