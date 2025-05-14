@extends('templates/header')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
     {{ empty($result) ? 'Tambah' : 'Edit'}} Data Produk
    <small>Produk</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>Data Kategori</li>
    <li class="active">{{ empty($result) ? 'Tambah' : 'Edit'}} Data Produk</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  @include('templates/feedback')
  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <a href="{{ url('products') }}" class="btn bg-purple"><i class="fa fa-chevron-left"></i>Kembali</a>

    </div>
    <div class="box-body">
        <form action="{{ empty($result) ? url('products/add') : url("products/$result->id_product/edit")  }}" class="form-horizontal" method="POST"
          enctype="multipart/form-data">
            
            {{ csrf_field()}}

            @if (!empty($result))
              {{ method_field('patch') }}
              @endif
            <div class="form-group">
                <label class="control-label col-sm-2">Nama Produk</label>
                <div class="col-sm-10">
                    <input type="text" name="nama_product" class="form-control" placeholder="Masukkan Nama Produk" value="{{ @$result->nama_product }}">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2">Stock</label>
                <div class="col-sm-10">
                    <input type="text" name="stok" class="form-control" placeholder="Masukkan Stock" value="{{ @$result->stok }}">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2">Harga</label>
                <div class="col-sm-10">
                    <input type="text" name="harga" class="form-control" placeholder="Masukkan harga" value="{{ @$result->harga }}">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2">Kategori</label>
                <div class="col-sm-10">
                   <select name="id_category" class="form-control">
                    @foreach (\App\Models\Categories::all() as $categories)
                        <option value="{{ $categories->id_category}}" {{ @$result->id_category == $categories->id_category ? 'selected' : ''}}>{{ $categories->nama_kategori}}</option>
                    @endforeach
                   </select>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2">Gambar Produk</label>
                <div class="col-sm-10">
                    <input type="file" name="gambar_product">
                </div>
            </div>
            
            <div class="form-group">
                <div class="col-sm-10 col-sm-offset-2">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>Simpan</button>
                </div>
            </div>
        </form>
    </div>
    <!-- /.box-body -->
    <!-- /.box-footer-->
  </div>
  <!-- /.box -->

</section>
<!-- /.content -->
@endsection