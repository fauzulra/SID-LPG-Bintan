@extends('layouts.app')
@section('title', 'SID LPG Bintan')
@section('styles')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@endsection
@section('page-title', 'Dashboard')
@section('content')
@if(Auth::user()->hasRole('distributor'))
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
                <a href="/penjualan" class="text-decoration-none text-reset d-block">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Terjual</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $salesdata }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-600"></i>

                            </div>
                        </div>
                    </div>
                </div>
            </a> 
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
                <a href="/stok" class="text-decoration-none text-reset d-block">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Stok Tersedia </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stokdata }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-warehouse fa-2x text-gray-600"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>  
        <div class="col-xl-3 col-md-6 mb-4 w-100">
            <a href="#" data-toggle="modal" data-target="#CreateModal" class="text-decoration-none text-reset d-block">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1 ">
                                    Buat transaksi Baru </div>
                                <div class="h5 mb-0 font-weight-bold text-white">Buat transaksi</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-plus fa-2x text-gray-600"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-md-6 mb-4 w-100">
                <a href="#" data-toggle="modal" data-target="#PrintModal" class="text-decoration-none text-reset d-block">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Print Laporan </div>
                                <div class="h5 mb-0 font-weight-bold text-white">Cetak Laporan</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-download fa-2x text-gray-600"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>  
    </div>
    <div class="row">
        <div class="col-xl-7 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="text-lg text-info font-weight-bold mb-0">Transaksi terbaru</div>
                </div>
                <div class="card-body">
                    @if ($sales->count() > 0)
                        @foreach ($sales as $data)
                            <div class="card shadow-sm mb-3">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="font-weight-bold text-primary mb-0">#{{ $data->nomor_transaksi }}</h6>
                                        <small
                                            class="text-muted">{{ \Carbon\Carbon::parse($data->created_at)->locale('id')->translatedFormat('d M Y, H:i') }}
                                            WIB</small>
                                    </div>
                                    <div class="mb-2">
                                        <div class="small text-gray-600">Pembeli:
                                            <strong>{{ $data->penerima->nama ?? $data->penerima->nama_usaha ?? 'Data tidak ditemukan' }}</strong>
                                        </div>
                                        <div class="small text-gray-600">Distributor:
                                            <strong>{{ ucwords($data->distributor->nama_toko) }}</strong></div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="text-success font-weight-bold">{{ $data->jumlah_barang }} Tabung</div>
                                        <div class="text-dark font-weight-bold">Rp {{ number_format($data->total_harga * 1000, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center text-muted">
                            Tidak ada data penjualan.
                        </div>
                    @endif
                </div>

            </div>
        </div>
        <div class="col-xl-5 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Data Stok</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="myPieChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i> Total Stok
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Terjual
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="/penjualan" class="text-decoration-none text-reset d-block">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Terjual</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $salesdata }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-600"></i>

                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="/stok" class="text-decoration-none text-reset d-block">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Stok Tersedia </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stokdata }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-warehouse fa-2x text-gray-600"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-md-6 mb-4 ">
            <a href="#" data-toggle="modal" data-target="#CreateModal" class="text-decoration-none text-reset d-block   ">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1 ">
                                    Buat transaksi Baru </div>
                                <div class="h5 mb-0 font-weight-bold text-white">Buat transaksi</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-plus fa-2x text-gray-600"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="#" data-toggle="modal" data-target="#PrintModal" class="text-decoration-none text-reset d-block   ">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Print Laporan </div>
                                <div class="h5 mb-0 font-weight-bold text-white">Cetak Laporan</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-download fa-2x text-gray-600"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-7 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="text-lg text-info font-weight-bold mb-0">Transaksi Terbaru</div>
                </div>
                <div class="card-body">
                    @if ($sales->count() > 0)
                        @foreach ($sales as $data)
                            <div class="card shadow-sm mb-3">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="font-weight-bold text-primary mb-0">#{{ $data->nomor_transaksi }}</h6>
                                        <small
                                            class="text-muted">{{ \Carbon\Carbon::parse($data->created_at)->locale('id')->translatedFormat('d M Y, H:i') }}
                                            WIB</small>
                                    </div>
                                    <div class="mb-2">
                                        <div class="small text-gray-600">Pembeli:
                                            <strong>{{ $data->penerima->nama ?? $data->penerima->nama_usaha ?? 'Data tidak ditemukan' }}</strong>
                                        </div>
                                        <div class="small text-gray-600">Distributor:
                                            <strong>{{ ucwords($data->distributor->nama_toko) }}</strong>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="text-success font-weight-bold">{{ $data->jumlah_barang }} Tabung</div>
                                        <div class="text-dark font-weight-bold">Rp
                                            {{ number_format($data->total_harga * 1000, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center text-muted">
                            Tidak ada data penjualan.
                        </div>
                    @endif
                </div>

            </div>
        </div>
        <div class="col-xl-5 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Data Stok</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="myPieChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i> Total Stok
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Terjual
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
    {{-- CreateModal --}}
    <div class="modal fade" id="CreateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('penjualan.store') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Penjualan</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body ml-2">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {!! session('error') !!}
                            </div>
                        @endif
                        <div class="form-row">
                            <div class="form-group">
                                <label for="id_penerima">Nama Pembeli <b class="text-danger">*</b></label>
                                <div class="d-flex">
                                    <select name="id_penerima" id="id_penerima"
                                        class="form-control @error('id_penerima') is-invalid @enderror mr-2" required
                                        style="flex-grow: 1;">
                                        <option value="">Nama Pembeli</option>

                                        <optgroup label="Rumah Tangga">
                                            @foreach ($penerima->where('jenis_pengguna', 'Rumah Tangga') as $data)
                                                <option value="{{ $data->id }}" @if(old('id_penerima') == $data->id) selected
                                                @endif>
                                                    {{ $data->nama }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                        <optgroup label="UMKM">
                                            @foreach ($penerima->where('jenis_pengguna', 'UMKM') as $data)
                                                <option value="{{ $data->id }}" @if(old('id_penerima') == $data->id) selected
                                                @endif>
                                                    {{ $data->nama_usaha }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                    <a href="{{ route('penerima.create') }}" style="text-decoration: none;">
                                        <button type="button"
                                            class="btn btn-outline-info d-flex align-items-center justify-content-center"
                                            style="width: 38px; height: 38px;">
                                            <i class="fa-solid fa-plus p-0"></i>
                                        </button>
                                    </a>
                                </div>
                                <small class="form-text text-muted mt-1">
                                    <em><span style="color: red">*</span>Jika tidak ada data pembeli, tambah data pembeli
                                        terlebih
                                        dahulu</em>
                                </small>
                                @error('id_penerima')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="id_toko">Nama Distributor</label> <b class="text-danger">*</b>
                                @if(Auth::user()->hasRole('admin'))
                                    <select name="id_toko" id="id_toko"
                                        class="form-control @error('id_toko') is-invalid @enderror">
                                        <option value="">Nama Distributor</option>
                                        @foreach ($distributor as $dist)
                                            <option value="{{ $dist->id }}">{{ $dist->nama_toko }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <input type="hidden" name="id_toko" value="{{ $distributor->first()->id }}">
                                    <input type="text" class="form-control" value="{{ $distributor->first()->nama_toko }}"
                                        readonly>
                                @endif
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="jumlah_barang">Jumlah Barang</label>
                                <input type="number" name="jumlah_barang" id="jumlah_barang"
                                    class="form-control w-50 @error('jumlah_barang') is-invalid @enderror" required min="1"
                                    max="2">
                                @error('jumlah_barang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted mt-1">
                                    <em><span style="color: red">*</span>max 2 dalam sehari</em>
                                </small>
                            </div>
                            <div class="form-group">
                                <label for="harga_satuan">Harga Satuan</label>
                                <div class="input-group bg-white">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white" id="basic-addon1">Rp</span>
                                    </div>
                                    <input type="text" name="harga_satuan" class="form-control bg-white" id="harga_satuan"
                                        value="20000" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="total_harga">Total Harga</label>
                                <div class="input-group bg-white">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white" id="basic-addon1">Rp</span>
                                    </div>
                                    <input type="text" name="total_harga" class="form-control bg-white" id="total_harga"
                                        readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-info" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Print Modal -->
    <div class="modal fade" id="PrintModal" tabindex="-1" aria-labelledby="PrintModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('penjualan.print.range') }}" method="GET" target="_blank">
                    <div class="modal-header">
                        <h5 class="modal-title" id="PrintModalLabel">Pilih Rentang Waktu</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="from" class="form-label">Tanggal Awal</label>
                            <input type="date" name="from" id="from" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="to" class="form-label">Tanggal Akhir</label>
                            <input type="date" name="to" id="to" class="form-control" required>
                        </div>
    
                        @if (Auth::user()->hasRole('admin'))
                            <div class="mb-3">
                                <label for="id_toko" class="form-label">Pilih Distributor</label>
                                <select name="id_toko" id="id_toko" class="form-control">
                                    <option value="">Semua Distributor</option>
                                    @foreach ($distributor as $distro)
                                        <option value="{{ $distro->id }}">{{ $distro->nama_toko }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <input type="hidden" name="id_toko" value="{{ $distributor->first()->id }}">
                        @endif
    
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-file-pdf"></i> Cetak PDF
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const jumlahInput = document.getElementById('jumlah_barang');
            const hargaInput = document.getElementById('harga_satuan');
            const totalInput = document.getElementById('total_harga');

            function updateTotal() {
                const jumlah = parseInt(jumlahInput.value) || 0;
                const harga = parseInt(hargaInput.value.replace(/\./g, '')) || 0; // Remove dot if formatted like "20.000"
                const total = jumlah * harga;

                totalInput.value = new Intl.NumberFormat('id-ID').format(total); // Format as currency
            }

            jumlahInput.addEventListener('input', updateTotal);
        }); 

        window.chartData = {
            data: [{{ $totalStok }}, {{ $totalTerjual }}]
        };
    </script>


@endsection
@section('script')
    <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('js/demo/chart-pie-demo.js') }}"></script>
@endsection