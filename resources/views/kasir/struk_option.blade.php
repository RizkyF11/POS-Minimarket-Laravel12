@extends('templates/header')

@section('content')
<div class="container mt-4">
    <div class="alert alert-success">
        <strong>Transaksi Berhasil!</strong>
        Invoice: {{ $order->invoice}} <br>
        Total: Rp. {{ number_format($order->total, 0, ',', '.') }} <br>
    </div>

    <div class="d-flex gap-2 mt-3">
        <a href="{{route('struk.thermal', $order->id_orders)}}" class="btn btn-primary">
            <i class="fa fa-print"></i> Cetak Struk
        </a>
        <a href="{{ route('kasir') }}" class="btn btn-success">
            Selesaikan Pembayaran
        </a>
    </div>
</div>
@endsection