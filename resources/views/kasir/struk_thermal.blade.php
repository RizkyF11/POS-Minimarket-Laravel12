<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Struk Pembayaran</title>
    <style>
        @media print {
            @page {
                size: 58mm auto;
                margin: 0;
            }
        }

        body {
            font-family: monospace;
            width: 58mm;
            font-size: 12px;
            margin: 0 auto;
        }

        .center {
            text-align: center;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 2px 0;
        }
    </style>
</head>
<body onload="window.print();">

    <div class="center">
        <strong>RZMART</strong><br>
        Jl. Mangunsarkoro<br>
        0812-3456-7890
    </div>

    <div class="line"></div>

    <div>
        Invoice : {{ $order->invoice }}<br>
        Kasir   : {{ $order->user->name ?? 'kasir' }}<br>
        Tanggal : {{ $order->created_at->format('d-m-Y H:i') }}
    </div>

    <div class="line"></div>

    <table>
        @foreach ($order->details as $item)
        <tr>
            <td colspan="2">{{ $item->nama_product }}</td>
        </tr>
        <tr>
            <td>{{ $item->qty }} x {{ number_format($item->harga) }} <br>
             {{$item->product->nama_product}}</td>
            <td align="right">{{ number_format($item->qty * $item->harga) }}</td>
        </tr>
        @endforeach
    </table>

    <div class="line"></div>

    <p><strong>Total : Rp {{ number_format($order->total) }}</strong></p>

    <div class="line"></div>

    <div class="center">
        --- Terima Kasih ---
    </div>

    <script>
        window.onafterprint = function() {
            window.location.href = "{{ route('kasir') }}";
        };
    </script>
</body>
</html>
