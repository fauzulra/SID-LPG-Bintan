    @extends('layouts.app')

    @section('title', 'Data Penerima Subsidi')

    @section('styles')
        <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        
    @endsection

    @section('page-title', 'Data Penerima Subsidi')

    @section('content')

        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="text-lg text-info font-weight-bold mt-auto ">Data Penerima Subsidi</div>
                <a href="{{ route('penerima.create') }}"> 
                    <button type="button" class="btn btn-outline-info">
                        <i class="fa-solid fa-plus mr-2"></i>Tambah Data
                    </button>
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <h6 class="text-dark">Pilih data yang ingin ditampilkan:</h6>
                    <div class="my-3">
                        <label><input type="radio" name="filter" value="rumah" checked> Rumah Tangga</label><br>
                        <label class="mt-1"><input type="radio" name="filter" value="umkm"> UMKM</label>
                    </div>
                    {{-- Tabel Rumah Tangga --}}
                    <table id="dataTableRumah" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>NIK</th>
                                <th>Alamat</th>
                                <th>Nomor HP</th>
                                <th>Foto KTP</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reciepents->where('jenis_pengguna', 'Rumah Tangga') as $data)
                                <tr>
                                    <td>{{ ucwords($data->nama) }}</td>
                                    <td>{{ $data->nik }}</td>
                                    <td>{{ ucwords($data->alamat) }}</td>
                                    <td>{{ $data->no_hp }}</td>
                                    <td>
                                        @if ($data->foto_ktp)
                                            <img src="{{ asset('storage/' . $data->foto_ktp) }}" style="height: 60px; cursor: zoom-in;"
                                                onclick="zoomImage(this)">
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group" aria-label="Actions">
                                            <form action="{{ route('penerima.edit', $data->id) }}" method="PUT">
                                                <button class="btn btn-sm btn-outline-warning mr-2">
                                                    <i class="fa-solid fa-pencil mr-2"></i>Edit
                                                </button>
                                            </form> 
                                            <form action="{{ route('penerima.destroy', $data->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Yakin hapus data ini?')">
                                                    <i class="fa-solid fa-trash mr-2"></i>Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- Tabel UMKM --}}
                    <table id="dataTableUMKM" class="table table-bordered" style="display: none;">
                        <thead>
                            <tr>
                                <th>Nama Usaha</th>
                                <th>NIB</th>
                                <th>Foto Usaha</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reciepents->where('jenis_pengguna', 'UMKM') as $data)
                                <tr>
                                    <td>{{ ucwords($data->nama_usaha) }}</td>
                                    <td>{{ $data->nib }}</td>
                                    <td>
                                        @if ($data->foto_usaha)
                                            <img src="{{ asset('storage/' . $data->foto_usaha) }}"
                                                style="height: 60px; cursor: zoom-in;" onclick="zoomImage(this)">
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Actions">
                                            <form action="{{ route('penerima.edit', $data->id) }}" method="PUT">
                                                <button class="btn btn-sm btn-outline-warning mr-2">
                                                    <i class="fa-solid fa-pencil mr-2"></i>Edit
                                                </button>
                                            </form>
                                            <form action="{{ route('penerima.destroy', $data->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin hapus data ini?')">
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
        <!-- Modal untuk zoom foto -->
        <div class="modal fade" id="zoomModal" tabindex="-1" role="dialog" aria-labelledby="zoomModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <img id="zoomedImage" src="" class="img-fluid" alt="Zoomed Image">
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function () {
                // Saat radio button berubah
                $('input[name="filter"]').on('change', function () {
                    let selected = $(this).val();

                    if (selected === 'rumah') {
                        $('#dataTableRumah').show();
                        $('#dataTableUMKM').hide();
                    } else if (selected === 'umkm') {
                        $('#dataTableRumah').hide();
                        $('#dataTableUMKM').show();
                    }
                });
            });

            let tableRumah = null;
            let tableUMKM = null;

            function initRumah() {
                if (!$.fn.DataTable.isDataTable('#dataTableRumah')) {
                    tableRumah = $('#dataTableRumah').DataTable();
                }
            }

            function initUMKM() {
                if (!$.fn.DataTable.isDataTable('#dataTableUMKM')) {
                    tableUMKM = $('#dataTableUMKM').DataTable();
                }
            }

            $(document).ready(function () {
                // Default: tampilkan Rumah Tangga
                $('#dataTableUMKM_wrapper').hide();
                initRumah();

                $('input[name="filter"]').on('change', function () {
                    const selected = $(this).val();

                    if (selected === 'rumah') {
                        if (tableUMKM) {
                            tableUMKM.destroy();
                            $('#dataTableUMKM_wrapper').remove(); // Hapus tampilan DataTable lama
                        }
                        $('#dataTableUMKM').hide();
                        $('#dataTableRumah').show();
                        initRumah();
                    } else {
                        if (tableRumah) {
                            tableRumah.destroy();
                            $('#dataTableRumah_wrapper').remove(); // Hapus tampilan DataTable lama
                        }
                        $('#dataTableRumah').hide();
                        $('#dataTableUMKM').show();
                        initUMKM();
                    }
                });
            });

            const selectTipe = document.getElementById('jenis_pengguna');
            const formRT = document.getElementById('formRumahTangga');
            const formUMKM = document.getElementById('formUMKM');

            selectTipe.addEventListener('change', function () {
                if (this.value === 'UMKM') {
                    formRT.style.display = 'none';
                    formUMKM.style.display = 'block';
                } else {
                    formRT.style.display = 'block';
                    formUMKM.style.display = 'none';
                }
            });

            function zoomImage(imgElement) {
                const zoomedImage = document.getElementById('zoomedImage');
                zoomedImage.src = imgElement.src;

                const modal = new bootstrap.Modal(document.getElementById('zoomModal'));
                modal.show();
            }
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