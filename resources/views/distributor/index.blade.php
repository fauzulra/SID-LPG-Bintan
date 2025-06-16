@extends('layouts.app')

@section('title', 'Data Distributor')

@section('styles')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


@endsection

@section('page-title', 'Data Distributor')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="text-lg text-info font-weight-bold mt-auto ">Data Distributor</div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Username</th>
                            <th>Nama Toko</th>
                            <th>Alamat Toko</th>
                            <th>Nomor Telepon</th>
                            <th>Status Approval</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($distributor as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ ucwords($data->user->name) }}</td>
                                <td>{{ ucwords($data->nama_toko) }}</td>
                                <td>{{ ucwords($data->alamat) }}</td>
                                <td>{{ $data->no_hp }}</td>
                                <td class="text-center">
                                    @if ($data->user->is_approved)
                                        <span class="text-success"><i class="fas fa-check-circle"></i></span>
                                    @else
                                        <span class="text-danger"><i class="fas fa-times-circle"></i></span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group  d-flex align-items-center" role="group" aria-label="Actions">
                                        @if (!$data->user->is_approved)
                                            <form action="{{ route('admin.approval.toggle', $data->user->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button class="btn btn-sm btn-outline-success mr-2 d-flex align-items-center">
                                                <i class="fa-solid fa-check mr-2"></i>Setujui</button>
                                            </form>
                                        @endif
                                        <form action="{{ route('admin.distributor.destroy', $data->user->id) }}" method="POST" style="display:inline-block;"
                                            onsubmit="return confirm('Yakin ingin menghapus akun ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger d-flex align-items-center">
                                            <i class="fa-solid fa-trash mr-2"></i>Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
