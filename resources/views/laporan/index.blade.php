@extends('templates/header')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Laporan
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('laporan') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <!-- <li><a href="#">Examples</a></li> -->
    <li class="active">Laporan</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  @include('templates.feedback')
  <!-- Default box -->
  <div class="box">
   
    <div class="box-body">
      <table class="table table-stripped">
        <thead>
          <tr>
            <th>No</th>
            <th>Kasir</th>
            <th>Invoice</th>
            <th>Nama Produk</th>
            <th>Qty</th>
            <th>Total</th>
            <th>Tanggal</th>
          </tr>
        </thead>

        <tbody>
          @foreach($orders as $order)
          <tr>
            <td>{{$order->id_orders}}</td>
            <td>{{$order->user->nama_user}}</td>
            <td>{{$order->invoice}}</td>
            <td>
              <ul>
                @foreach($order->details as $detail)
                <li>{{ $detail->product->nama_product ?? 'Produk dihapus' }} ({{$detail->qty}})</li>
                @endforeach
              </ul>

            </td>
            <td>{{$order->details->sum('qty')}}</td>
            <td>{{number_format($order->total)}}</td>
            <td>{{$order->created_at->format('d-m-Y H:i')}}</td>
            
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
      Footer
    </div>
    <!-- /.box-footer-->
  </div>
  <!-- /.box -->

</section>
<!-- /.content -->
@endsection