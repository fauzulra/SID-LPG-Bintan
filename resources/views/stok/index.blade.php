@extends('layouts.app')

@section('title', 'Data Stok Subsidi')

@section('styles')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@endsection

@section('page-title', 'Data Stok Subsidi')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="text-lg text-info font-weight-bold mt-auto ">Data Stok Subsidi</div>
                <a href="#" data-toggle="modal" data-target="#CreateModal">
                    <button type="button" class="btn btn-outline-info">
                        <i class="fa-solid fa-plus mr-2"></i>Tambah Data
                    </button>
                </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama Distributor</th>
                            <th>Alamat Distributor</th>
                            <th>Jumlah Stok</th>
                            <th>Tanggal Stok Terbaru Masuk</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stok as $data)
                            <tr>
                                <td>{{ ucwords($data->distributor->nama_toko) }}</td>
                                <td>{{ ucwords($data->distributor->alamat) }}</td>
                                <td>{{ $data->jumlah_barang }}</td>
                                <td>{{ \Carbon\Carbon::parse($data->tanggal_masuk)->format('j F Y') }}</td>
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
                <form action="{{ route('stok.store') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Stok</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="id_toko">Nama Distributor</label>
                            <b class="text-danger">*</b>
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
                        <div class="form-group">
                            <label for="jumlah_barang">Jumlah Barang</label>
                            <input type="number" name="jumlah_barang" id="jumlah_barang"
                                class="form-control @error('jumlah_barang') is-invalid @enderror" placeholder="Masukkan Jumlah Barang">
                            @error('tanggal_masuk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>        
                        <div class="form-group">
                            <label for="tanggal_masuk">Tanggal Masuk</label>
                            <input type="date" name="tanggal_masuk" id="tanggal_masuk"
                                class="form-control @error('tanggal_masuk') is-invalid @enderror" placeholder="">
                            @error('tanggal_masuk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>        
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-info" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
@endsection


<!-- Page level plugins -->
<script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>

<!-- Page level custom scripts -->
<script src="{{ asset('js/demo/chart-area-demo.js') }}"></script>
<script src="{{ asset('js/demo/chart-pie-demo.js') }}"></script>