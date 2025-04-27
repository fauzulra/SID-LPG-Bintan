@extends('layouts.app')

@section('title', 'Data Penjualan Subsidi')

@section('styles')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection

@section('page-title', 'Data Penjualan Subsidi')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="text-lg text-info font-weight-bold mb-0">Data Penjualan Subsidi</div>

            <div class="d-flex">
                <a href="#" data-toggle="modal" data-target="#PrintModal">
                    <button type="button" class="btn btn-outline-info mr-2">
                        <i class="fa-solid fa-download mr-2"></i>Print
                    </button>
                </a>
                <a href="#" data-toggle="modal" data-target="#CreateModal">
                    <button type="button" class="btn btn-outline-info">
                        <i class="fa-solid fa-plus mr-2"></i>Tambah Data
                    </button>
                </a>
            </div>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nomor Transaksi</th>
                            <th>Nama Pembeli</th>
                            <th>Nama Distributor</th>
                            <th>Jumlah Barang</th>
                            <th>Total Harga</th>
                            <th>Tanggal Transaksi</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales as $data)
                            <tr>
                                <td>{{ $data->nomor_transaksi }}</td>
                                <td>{{ $data->penerima->nama ?? $data->penerima->nama_usaha ?? 'Data tidak ditemukan' }}</td>
                                <td>{{ ucwords($data->distributor->nama_toko)   }}</td>
                                <td>{{ $data->jumlah_barang }} Item</td>
                                <td>Rp {{ $data->total_harga }}.000</td>
                                <td>{{ \Carbon\Carbon::parse($data->created_at)->locale('id')->translatedFormat('l, j F Y, H:i') }} WIB</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Create Modal --}}
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
                
                        {{-- Alert error --}}
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {!! session('error') !!}
                            </div>
                        @endif
                
                        {{-- Nama Pembeli --}}
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
                                                <option value="{{ $data->id }}" @if(old('id_penerima') == $data->id) selected @endif>
                                                    {{ $data->nama }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                        <optgroup label="UMKM">
                                            @foreach ($penerima->where('jenis_pengguna', 'UMKM') as $data)
                                                <option value="{{ $data->id }}" @if(old('id_penerima') == $data->id) selected @endif>
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
                                    <em><span style="color: red">*</span>Jika tidak ada data pembeli, tambah data pembeli terlebih
                                        dahulu</em>
                                </small>
                                @error('id_penerima')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                
                        {{-- Nama Distributor --}}
                        <div class="form-row">
                            <div class="form-group">
                                <label for="id_toko">Nama Distributor</label> <b class="text-danger">*</b>
                                @if(Auth::user()->hasRole('admin'))
                                    {{-- Admin bisa pilih --}}
                                    <select name="id_toko" id="id_toko" class="form-control @error('id_toko') is-invalid @enderror">
                                        <option value="">Nama Distributor</option>
                                        @foreach ($distributor as $dist)
                                            <option value="{{ $dist->id }}">{{ $dist->nama_toko }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    {{-- Distributor tidak bisa pilih, langsung hidden --}}
                                    <input type="hidden" name="id_toko" value="{{ $distributor->first()->id }}">
                                    <input type="text" class="form-control" value="{{ $distributor->first()->nama_toko }}" readonly>
                                @endif
                            </div>
                        </div>
                
                        {{-- Jumlah Barang --}}
                        <div class="form-row">
                            <div class="form-group">
                                <label for="jumlah_barang">Jumlah Barang</label>
                                <input type="number" name="jumlah_barang" id="jumlah_barang"
                                    class="form-control w-50 @error('jumlah_barang') is-invalid @enderror" required min="1" max="2">
                                @error('jumlah_barang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted mt-1">
                                    <em><span style="color: red">*</span>max 2 dalam sehari</em>
                                </small>
                            </div>
                
                            {{-- Harga Satuan --}}
                            <div class="form-group">
                                <label for="harga_satuan">Harga Satuan</label>
                                <div class="input-group bg-white">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white" id="basic-addon1">Rp</span>
                                    </div>
                                    <input type="text" name="harga_satuan" class="form-control bg-white" id="harga_satuan" value="20000"
                                        readonly>
                                </div>
                            </div>
                        </div>
                
                        {{-- Total Harga --}}
                        <div class="form-row">
                            <div class="form-group">
                                <label for="total_harga">Total Harga</label>
                                <div class="input-group bg-white">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white" id="basic-addon1">Rp</span>
                                    </div>
                                    <input type="text" name="total_harga" class="form-control bg-white" id="total_harga" readonly>
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
    </script>

@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- SweetAlert for flash messages --}}
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2500
            });
        </script>
    @endif
    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    @endif
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
@endsection