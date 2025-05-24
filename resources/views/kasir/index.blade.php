    @extends('templates/header')

    @section('content')
    <!-- Content Header (Page header) -->
    <style>
        .img-square-wrapper {
            width: 100%;
            padding-top: 100%;
            /* membuat rasio 1:1 */
            position: relative;
            overflow: hidden;
            background: #fff;
        }

        .img-square-wrapper img.img-square {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
            /* atau 'cover' jika ingin gambar penuh */
            background-color: #f5f5f5;
        }

        .btn-group {
            display: flex;
            justify-content: space-between;
            /* Membuat tombol tersebar rata */
            width: 100%;
            /* Menyesuaikan lebar agar tombol penuh */
        }
    </style>
    <section class="content-header">
        <h1>
            Orders
            <small>Minimarket</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"> Orders </li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        @include('templates/feedback')
        <!-- Default box -->
        <div class="box">
            <!-- <div class="box-header">
                <a href="{{ url('products/add') }}" class="btn btn-success">
                    <i class="fa fa-fw fa-plus-circle"></i>
                    Tambah
                </a>
            </div> -->
            <!-- /.box-header -->
            <div class="row">
                <!-- Kolom Kiri: Daftar Produk -->
                <div class="col-md-8">
                    <div class="box-body">
                        @foreach($result->chunk(4) as $chunk)
                        <div class="row">
                            @foreach($chunk as $product)
                            <div class="col-sm-6 col-md-3">
                                <div class="thumbnail">
                                    <div class="img-square-wrapper">
                                        <img src="{{ asset('storage//' . @$product->gambar_product) }}" alt="Produk" class="img-square img-responsive">
                                    </div>
                                    <div class="caption text-center">
                                        <h4>{{ $product->nama_product }}</h4>
                                        <p><strong>Rp {{ number_format($product->harga, 0, ',', '.') }}</strong></p>
                                        <p>Stok: {{ $product->stok }}</p>
                                        <p>
                                        <form action="{{ url('keranjang/add') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id_product" value="{{ $product->id_product }}">
                                            <button type="submit" class="btn btn-primary btn-sm">Tambah</button>
                                        </form>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Kolom Kanan: Panel Transaksi -->
                <div class="col-md-4">
                    <div class="panel panel-default" style="padding: 15px;">

                        <div class="panel-body">
                            @php
                            $keranjang = session('keranjang', []);
                            @endphp
                            @foreach($keranjang as $id => $item)
                            <div class="cart-item">
                                <strong>{{ $item['nama_produk'] }}</strong><br>
                                <small>Rp. {{ number_format($item['harga'], 0, ',', '.') }} &nbsp;&nbsp; Stok: {{ $item['stok'] }}</small>

                                <div class="row" style="margin-top: 5px;">
                                    <div class="col-xs-7">
                                        <div class="form-inline">
                                            <div class="form-group">
                                                <form action="{{ url('keranjang/kurang/'.$id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary btn-sm">-</button>
                                                </form>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control input-sm text-center" value="{{ $item['jumlah'] }}" style="width: 50px;">
                                            </div>
                                            <div class="form-group">
                                                <form action="{{ url('keranjang/tambah/'.$id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary btn-sm">+</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 text-right">
                                        <strong>Rp {{ number_format($item['harga'] * $item['jumlah'], 0, ',', '.') }}</strong>
                                    </div>
                                </div>
                                <hr>
                            </div>
                            @endforeach

                            @if(session('keranjang') && count(session('keranjang')) >0)
                            <form action="{{ url('keranjang/hapus-semua') }}" method="POST" onsubmit="return confirm('Yakin hapus semua keranjang?');">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                            @endif
                            <hr>

                        </div>


                        @php
                        $subtotal = 0;
                        foreach ($keranjang as $id => $item) {
                        $subtotal += $item['harga'] * $item['jumlah'];
                        }
                        $diskon = $subtotal >= 100000 ? 10000 : 0; // Diskon Rp10.000 jika subtotal >= 100.000
                        $total = $subtotal - $diskon;
                        @endphp

                        <p><strong>Sub Total:</strong> <span class="pull-right" id="subtotal">Rp. {{ number_format($subtotal, 0, ',', '.') }}</span></p>
                        <p><strong>Diskon:</strong> <span class="pull-right" id="diskon">Rp. {{ number_format($diskon, 0, ',', '.') }}</span></p>
                        <hr>
                        <h4><strong>Total:</strong> <span class="pull-right text-purple" id="total">Rp. {{ number_format($total, 0, ',', '.') }}</span></h4>
                        <hr>

                        <div class="form-group">
                            <label for="uang_diterima">Uang Diterima</label>
                            <input type="text" id="uang_diterima" class="form-control" placeholder="Masukkan uang yang diterima">
                        </div>

                        <div class="form-group">
                            <label for="kembalian">Kembalian</label>
                            <input type="text" id="kembalian" class="form-control" readonly>
                        </div>

                    </div>

                    <div class="panel-footer text-center">
                        <button class="btn btn-success btn-lg btn-block"><strong> Bayar</strong></button>
                    </div>

                </div>
            </div>
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
    <script>
        document.getElementById('uang_diterima').addEventListener('input', function() {
            //ambil nilai uang yang diketik dan total dari kasir
            let uangDiterima = parseInt(this.value.replace(/\D/g, '')) || 0;
            let totalText = document.getElementById('total').innerText;
            let total = parseInt(totalText.replace(/[^\d]/g, '')) || 0;

            //hitung kembalian
            let kembalian = uangDiterima - total;

            //format hasil menjadi rupiah
            const formatRupiah = (angka) => {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(angka);
            };

            //tampilkan hasil
            const inputKembalian = document.getElementById('kembalian');
            if (kembalian < 0) {
                inputKembalian.value = 'Uang tidak cukup';
            } else {
                inputKembalian.value = formatRupiah(kembalian);
            }
        });
    </script>





    @endsection