@extends('layouts.app')
@section('title', 'Profil Pengguna')
@section('styles')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
    .bg-gradient {
    background: linear-gradient(to right, #b3cde0, #fceabb);!important;
    height: 60px; /* atur tinggi banner */
    }
    </style>
@endsection
@section('page-title', 'Profil Distributor')
@section('content')
    @if(Auth::user()->hasRole('distributor'))
        <div class="col-xl-12 col-lg-7">
            <div class="card shadow mb-4 " style="border-radius: 2rem; !important">
                <!-- Card Header - Dropdown -->
                <div class="card-header p-4 bg-gradient" style="border-top-left-radius: 1rem !important; border-top-right-radius: 1rem !important;">
                </div>
                <!-- Card Body -->
                <div class="card-body mb-5 ">
                    <div class="row px-2">
                        <div class="col-12">
                            <div class="d-flex align-items-center justify-content-between ">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('img/admin.svg') }}" class="rounded-circle"
                                    style="width: 60px; height: 60px; object-fit: cover;">
                                    <div class="ms-3">
                                        <h5 class="mb-0 ml-3 text-gray-800">{{ Auth::user()->name }}</h5>
                                        <small class="text-muted ml-3 text-gray-800">{{ Auth::user()->email }}</small>
                                    </div>
                                </div>
                                <button class="btn btn-outline-info px-3" id="editButton">Edit</button>
                            </div>
                        </div>
                    </div>
                    @if (session('error'))
                    <div class="alert alert-danger">
                        {!! session('error') !!}
                    </div>
                    @endif
                    <form action="{{ route('distributor.update') }}" method="POST" id="editForm">
                        @csrf
                        @method('PUT')
                        <div class="row px-2">
                            <div class="form-group col-lg-6 mt-4 ">
                                <label for="name" class="form-label text-gray-800">Username</label>
                                <input type="text" class="form-control h-75 rounded-4" id="Username" value="{{ ucwords(Auth::user()->name) }}" readonly>
                            </div>
                            <div class="form-group col-lg-6 mt-4 mr-auto">
                                <label for="name" class="form-label text-gray-800">Nama Toko</label>
                                <input type="text" class="form-control h-75 rounded-4" name="nama_toko" id="namaToko" value="{{ ucwords($distributor->nama_toko) }}" readonly>
                            </div>
                        </div>
                        <div class="row px-2">
                            <div class="form-group col-lg-6 mt-4 ">
                                <label for="name" class="form-label text-gray-800">Alamat</label>
                                <input type="text" class="form-control h-75 rounded-4" name="alamat" id="alamat" value="{{ ucwords($distributor->alamat) }}" readonly>
                            </div>
                            <div class="form-group col-lg-6 mt-4 mr-auto">
                                <label for="name" class="form-label text-gray-800">Nomor Telepon</label>
                                <input type="text" class="form-control h-75 rounded-4" name="no_hp" id="noHp" value="{{ $distributor->no_hp }}" readonly>
                            </div>
                        </div>
                        <div class="row px-2 mt-4 ml-auto d-none " id="saveButtonRow">
                            <button class="btn btn-success" id="saveButton">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @else
        <div class="col-xl-12 col-lg-7">
            <div class="card shadow mb-4 " style="border-radius: 2rem; !important">
                <!-- Card Header - Dropdown -->
                <div class="card-header p-4 bg-gradient" style="border-top-left-radius: 1rem !important; border-top-right-radius: 1rem !important;">
                </div>
                <!-- Card Body -->
                <div class="card-body mb-5 ">
                    <div class="row px-2">
                        <div class="col-12">
                            <div class="d-flex align-items-center justify-content-between ">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('img/admin.svg') }}" class="rounded-circle"
                                    style="width: 60px; height: 60px; object-fit: cover;">
                                    <div class="ms-3">
                                        <h5 class="mb-0 ml-3 text-gray-800">{{ $distributor->name }}</h5>
                                        <small class="text-muted ml-3 text-gray-800">{{ $distributor->email }}</small>
                                    </div>
                                </div>
                                <button class="btn btn-outline-info px-3" id="editButton">Edit</button>
                            </div>
                        </div>
                    </div>
                    @if (session('error'))
                    <div class="alert alert-danger">
                        {!! session('error') !!}
                    </div>
                    @endif
                    <form action="{{ route('distributor.update') }}" method="POST" id="editForm">
                        @csrf
                        @method('PUT')
                        <div class="row px-2">
                            <div class="form-group col-lg-6 mt-4 ">
                                <label for="name" class="form-label text-gray-800">Username</label>
                                <input type="text" class="form-control h-75 rounded-4" id="Username" value="{{ ucwords(Auth::user()->name) }}" readonly>
                            </div>
                            <div class="form-group col-lg-6 mt-4 mr-auto">
                                <label for="name" class="form-label text-gray-800">Nama Toko</label>
                                <input type="text" class="form-control h-75 rounded-4" name="nama_toko" id="namaToko" value="{{ ucwords($distributor->first()->nama_toko) }}" readonly>
                            </div>
                        </div>
                        <div class="row px-2">
                            <div class="form-group col-lg-6 mt-4 ">
                                <label for="name" class="form-label text-gray-800">Alamat</label>
                                <input type="text" class="form-control h-75 rounded-4" name="alamat" id="alamat" value="{{ ucwords($distributor->first()->alamat) }}" readonly>
                            </div>
                            <div class="form-group col-lg-6 mt-4 mr-auto">
                                <label for="name" class="form-label text-gray-800">Nomor Telepon</label>
                                <input type="text" class="form-control h-75 rounded-4" name="no_hp" id="noHp" value="{{ $distributor->first()->no_hp }}" readonly>
                            </div>
                        </div>
                        <div class="row px-2 mt-4 ml-auto d-none " id="saveButtonRow">
                            <button class="btn btn-success" id="saveButton">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
            <script>
                document.getElementById('editButton').addEventListener('click', function() {
                    // Aktifkan input
                    document.getElementById('namaToko').removeAttribute('readonly');
                    document.getElementById('alamat').removeAttribute('readonly');
                    document.getElementById('noHp').removeAttribute('readonly');
                    
                    // Fokuskan cursor ke namaToko
                    document.getElementById('namaToko').focus();
                    
                    // Tampilkan tombol Simpan
                    document.getElementById('saveButtonRow').classList.remove('d-none');
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
@endsection