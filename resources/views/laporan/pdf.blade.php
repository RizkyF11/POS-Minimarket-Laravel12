<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi</title>
    <style>
        body { font-family: sans-serif; font-size: 12px;}
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 5px;}
        ul { margin: 0; padding-left: 15px;}
    </style>
</head>
<body>
    <h2 style="text-align: center">Laporan Transaksi</h2>
    <p>Tanggal cetak: {{now()->format('d-m-Y H:i')}}</p>

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
</body>
</html>