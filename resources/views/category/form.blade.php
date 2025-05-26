@extends('templates/header')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
     {{ empty($result) ? 'Tambah' : 'Edit'}} Data Kategori
    <small>Kategori</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/categories') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>Data Kategori</li>
    <li class="active">{{ empty($result) ? 'Tambah' : 'Edit'}} Data Kategori</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  @include('templates/feedback')
  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <a href="{{ url('/') }}" class="btn bg-purple"><i class="fa fa-chevron-left"></i>Kembali</a>

    </div>
    <div class="box-body">
        <form action="{{ empty($result) ? url('categories/add') : url("categories/$result->id_category/edit")  }}" class="form-horizontal" method="POST">
            {{ csrf_field()}}

            @if (!empty($result))
              {{ method_field('patch') }}
              @endif
            <div class="form-group">
                <label class="control-label col-sm-2">Nama Kategori</label>
                <div class="col-sm-10">
                    <input type="text" name="nama_kategori" class="form-control" placeholder="Masukkan Nama Kategori" value="{{ @$result->nama_kategori }}">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2">Deskripsi</label>
                <div class="col-sm-10">
                    <input type="text" name="deskripsi" class="form-control" placeholder="Masukkan deskripsi" value="{{ @$result->deskripsi }}">
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