@extends('templates/header')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
     {{ empty($result) ? 'Tambah' : 'Edit'}} Data Kategori
    <small>Multiuser</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('users') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>Data Kategori</li>
    <li class="active">{{ empty($result) ? 'Tambah' : 'Edit'}} Data User</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  @include('templates/feedback')
  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <a href="{{ url('users') }}" class="btn bg-purple"><i class="fa fa-chevron-left"></i>Kembali</a>

    </div>
    <div class="box-body">
        <form action="{{ empty($result) ? url('users/add') : url("users/$result->id_user/edit")  }}" class="form-horizontal" method="POST">
            {{ csrf_field()}}

            @if (!empty($result))
              {{ method_field('patch') }}
              @endif
            <div class="form-group">
                <label class="control-label col-sm-2">Nama user</label>
                <div class="col-sm-10">
                    <input type="text" name="nama_user" class="form-control" placeholder="Masukkan Nama User" value="{{ @$result->nama_user}}">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2">Password</label>
                <div class="col-sm-10">
                    <input type="password" name="password" class="form-control" placeholder="Masukkan Password">
                    @if (!empty($result)) <small>Kosongkan jika tidak ingin mengubah password</small> @endif
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2">Role</label>
                <div class="col-sm-10">
                    <select name="role" class="form-control">
                        <option value=""> --Pilih Role-- </option>
                        <option value="admin" {{ @$result->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="kasir" {{ @$result->role == 'kasir' ? 'selected' : '' }}>Kasir</option>
                    </select>
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