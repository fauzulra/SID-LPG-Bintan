<div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div class="text-lg text-info font-weight-bold mt-auto ">Data Penerima Subsidi</div>
        <a href="#" data-toggle="modal" data-target="#CreateModal">
            <button type="button" class="btn btn-outline-info">
                <i class="fa-solid fa-plus mr-2"></i>Tambah Data
            </button>
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <h6 class="text-dark">Pilih Data yang ingin ditampilkan:</h6>
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
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reciepents->where('jenis_pengguna', 'Rumah Tangga') as $data)
                        <tr>
                            <td>{{ $data->nama }}</td>
                            <td>{{ $data->nik }}</td>
                            <td>{{ $data->alamat }}</td>
                            <td>{{ $data->no_hp }}</td>
                            <td>
                                @if ($data->foto_ktp)
                                    <img src="{{ asset('storage/' . $data->foto_ktp) }}" style="height: 60px; cursor: zoom-in;"
                                        onclick="zoomImage(this)">
                                @endif
                            </td>
                            <td>
                                <a href="#" data-toggle="modal" data-target="#EditModal"
                                    class="btn btn-sm btn-outline-warning">Edit</a>
                                <form action="{{ route('penerima.destroy', $data->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Yakin hapus data ini?')">Delete</button>
                                </form>
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
                            <td>{{ $data->nama_usaha }}</td>
                            <td>{{ $data->nib }}</td>
                            <td>
                                @if ($data->foto_usaha)
                                    <img src="{{ asset('storage/' . $data->foto_usaha) }}"
                                        style="height: 60px; cursor: zoom-in;" onclick="zoomImage(this)">
                                @endif
                            </td>
                            <td>
                                <a href="#" data-toggle="modal" data-target="#EditModal"
                                    class="btn btn-sm btn-outline-warning">Edit</a>
                                <form action="{{ route('penerima.destroy', $data->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Yakin hapus data ini?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
{{-- CreateModal --}}
<div class="modal fade" id="CreateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('penerima.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Penerima</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="jenis_pengguna" class="form-label">Jenis Pengguna</label><br>
                        <select name="jenis_pengguna" id="jenis_pengguna" class="form-control">
                            <option value="Rumah Tangga" {{ old('jenis_pengguna') === 'Rumah Tangga' ? 'selected' : '' }}>
                                Rumah Tangga</option>
                            <option value="UMKM" {{ old('jenis_pengguna') === 'UMKM' ? 'selected' : '' }}>UMKM</option>
                        </select>
                        @error('jenis_pengguna')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div id="formRumahTangga">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukkan Nama">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nik">NIK</label>
                            <input type="text" name="nik" class="form-control " id="nik" placeholder="Masukkan NIK">
                            @error('nik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                <em><span style="color: red">*</span>16 Digit Angka</em>
                            </small>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea type="text" name="alamat" rows="3" class="form-control" id="alamat"
                                placeholder="Masukkan Alamat"></textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="no_hp">Nomor HP</label>
                            <input type="text" name="no_hp" class="form-control" id="no_hp"
                                placeholder="Masukkan Nomor HP">
                            @error('no_hp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="foto_ktp">Foto KTP</label> <br>
                            <input type="file" name="foto_ktp" id="foto_ktp" accept="image/*"
                                onchange="previewImage(event)">
                            <br>
                            <img id="preview" src="#" alt="Preview Gambar"
                                style="display: none; max-height: 200px; margin-top: 10px;">
                        </div>
                    </div>
                    <div id="formUMKM" style="display: none;">
                        <div class="form-group">
                            <label for="nama_usaha">Nama Usaha</label>
                            <input type="text" name="nama_usaha" class="form-control " id="name"
                                placeholder="Masukkan Nama">
                            @error('nama_usaha')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nik">NIB</label>
                            <input type="text" name="nib" class="form-control" id="nib" placeholder="Masukkan NIB">
                            @error('nib')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="foto_usaha">Foto Usaha</label> <br>
                            <input type="file" name="foto_usaha" id="foto_usaha" accept="image/*"
                                onchange="previewImage(event)">
                            <br>
                            <img id="preview" src="#" alt="Preview Gambar"
                                style="display: none; max-height: 200px; margin-top: 10px;">
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
{{-- Edit Modal --}}
{{-- <div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('penerima.update', $reciepent->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Data Penerima</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="jenis_pengguna">Jenis Pengguna</label>
                        <select name="jenis_pengguna" id="jenis_pengguna_edit" class="form-control">
                            <option value="Rumah Tangga" {{ $reciepent->jenis_pengguna == 'Rumah Tangga' ? 'selected' :
                                '' }}>Rumah Tangga</option>
                            <option value="UMKM" {{ $reciepent->jenis_pengguna == 'UMKM' ? 'selected' : '' }}>UMKM
                            </option>
                        </select>
                    </div>

                    {{-- Form Rumah Tangga --}}
                    {{-- <div id="formRumahTanggaEdit"
                        style="{{ $reciepent->jenis_pengguna == 'Rumah Tangga' ? '' : 'display:none;' }}">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" class="form-control" value="{{ $reciepent->nama }}">
                        </div>
                        <div class="form-group">
                            <label for="nik">NIK</label>
                            <input type="text" name="nik" class="form-control" value="{{ $reciepent->nik }}">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea name="alamat" class="form-control">{{ $reciepent->alamat }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="no_hp">Nomor HP</label>
                            <input type="text" name="no_hp" class="form-control" value="{{ $reciepent->no_hp }}">
                        </div>
                        <div class="form-group">
                            <label for="foto_ktp">Foto KTP</label><br>
                            <input type="file" name="foto_ktp" id="foto_ktp_edit">
                            @if($reciepent->foto_ktp)
                            <img src="{{ asset('storage/' . $reciepent->foto_ktp) }}" alt="Foto KTP"
                                style="max-height: 100px; margin-top: 10px;">
                            @endif
                        </div>
                    </div> --}}

                    {{-- Form UMKM --}}
                    {{-- <div id="formUMKMEdit"
                        style="{{ $reciepent->jenis_pengguna == 'UMKM' ? '' : 'display:none;' }}">
                        <div class="form-group">
                            <label for="nama_usaha">Nama Usaha</label>
                            <input type="text" name="nama_usaha" class="form-control"
                                value="{{ $reciepent->nama_usaha }}">
                        </div>
                        <div class="form-group">
                            <label for="nib">NIB</label>
                            <input type="text" name="nib" class="form-control" value="{{ $reciepent->nib }}">
                        </div>
                        <div class="form-group">
                            <label for="foto_usaha">Foto Usaha</label><br>
                            <input type="file" name="foto_usaha" id="foto_usaha_edit">
                            @if($reciepent->foto_usaha)
                            <img src="{{ asset('storage/' . $reciepent->foto_usaha) }}" alt="Foto Usaha"
                                style="max-height: 100px; margin-top: 10px;">
                            @endif
                        </div>
                    </div>
                </div> --}}

                {{-- <div class="modal-footer">
                    <button class="btn btn-outline-info" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>
</div> --}}

<script>
    //  $(document).ready(function () {
    //         const rumahTable = $('#dataTableRumah').DataTable();
    //         const umkmTable = $('#dataTableUMKM').DataTable();

    //         $('input[name="filter"]').change(function () {
    //             if (this.value === 'rumah') {
    //                 $('#dataTableUMKM_wrapper').hide();
    //                 $('#dataTableRumah_wrapper').show();
    //             } else {
    //                 $('#dataTableRumah_wrapper').hide();
    //                 $('#dataTableUMKM_wrapper').show();
    //             }
    //         });

    //         // default tampilkan rumah tangga
    //         $('#dataTableUMKM_wrapper').hide();
    //     });


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

    function previewImage(event) {
        const preview = document.getElementById('preview');
        const file = event.target.files[0];

        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    }

    function zoomImage(src) {
        document.getElementById('zoomedImage').src = src;
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


{{-- Edit Modal --}}
{{-- <div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('penerima.update', $reciepent->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Data Penerima</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="jenis_pengguna">Jenis Pengguna</label>
                        <select name="jenis_pengguna" id="jenis_pengguna_edit" class="form-control">
                            <option value="Rumah Tangga" {{ $reciepent->jenis_pengguna == 'Rumah Tangga' ? 'selected' :
                                '' }}>Rumah Tangga</option>
                            <option value="UMKM" {{ $reciepent->jenis_pengguna == 'UMKM' ? 'selected' : '' }}>UMKM
                            </option>
                        </select>
                    </div>

                    {{-- Form Rumah Tangga --}}
                    {{-- <div id="formRumahTanggaEdit"
                        style="{{ $reciepent->jenis_pengguna == 'Rumah Tangga' ? '' : 'display:none;' }}">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" class="form-control" value="{{ $reciepent->nama }}">
                        </div>
                        <div class="form-group">
                            <label for="nik">NIK</label>
                            <input type="text" name="nik" class="form-control" value="{{ $reciepent->nik }}">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea name="alamat" class="form-control">{{ $reciepent->alamat }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="no_hp">Nomor HP</label>
                            <input type="text" name="no_hp" class="form-control" value="{{ $reciepent->no_hp }}">
                        </div>
                        <div class="form-group">
                            <label for="foto_ktp">Foto KTP</label><br>
                            <input type="file" name="foto_ktp" id="foto_ktp_edit">
                            @if($reciepent->foto_ktp)
                            <img src="{{ asset('storage/' . $reciepent->foto_ktp) }}" alt="Foto KTP"
                                style="max-height: 100px; margin-top: 10px;">
                            @endif
                        </div>
                    </div> --}}

                    {{-- Form UMKM --}}
                    {{-- <div id="formUMKMEdit"
                        style="{{ $reciepent->jenis_pengguna == 'UMKM' ? '' : 'display:none;' }}">
                        <div class="form-group">
                            <label for="nama_usaha">Nama Usaha</label>
                            <input type="text" name="nama_usaha" class="form-control"
                                value="{{ $reciepent->nama_usaha }}">
                        </div>
                        <div class="form-group">
                            <label for="nib">NIB</label>
                            <input type="text" name="nib" class="form-control" value="{{ $reciepent->nib }}">
                        </div>
                        <div class="form-group">
                            <label for="foto_usaha">Foto Usaha</label><br>
                            <input type="file" name="foto_usaha" id="foto_usaha_edit">
                            @if($reciepent->foto_usaha)
                            <img src="{{ asset('storage/' . $reciepent->foto_usaha) }}" alt="Foto Usaha"
                                style="max-height: 100px; margin-top: 10px;">
                            @endif
                        </div>
                    </div>
                </div> --}}

                {{-- <div class="modal-footer">
                    <button class="btn btn-outline-info" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>
</div> --}}


div class="modal fade" id="CreateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                            <em><span style="color: red">*</span>Jika tidak ada data pembeli, tambah data pembeli
                                terlebih dahulu</em>
                        </small>
                        @error('id_penerima')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="id_toko">Nama Distributor</label>
                        <b class="text-danger">*</b>
                        <select name="id_toko" id="id_toko" class="form-control @error('id_toko') is-invalid @enderror">
                            <option value="">Nama Distributor</option>
                            @foreach ($distributor as $distributor)
                                <option value="{{ $distributor->id }}">{{ $distributor->nama_toko }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="jumlah_barang">Jumlah Barang</label>
                        <input type="number" name="jumlah_barang" id="jumlah_barang"
                            class="form-control w-50 @error('jumlah_barang') is-invalid @enderror" required required
                            min="1" max="2">
                        @error('tanggal_masuk')
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
                            <input type="text" name="harga_satuan" class="form-control bg-white " id="harga_satuan"
                                value="20.000" readonly>
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

<div class="form-row">
    <div class="form-group">
        <label for="id_toko">Nama Distributor</label>
        <b class="text-danger">*</b>
        <select name="id_toko" id="id_toko" class="form-control @error('id_toko') is-invalid @enderror">
            <option value="">Nama Distributor</option>
            @foreach ($distributor as $distributor)
                <option value="{{ $distributor->id }}">{{ $distributor->nama_toko }}</option>
            @endforeach
        </select>
    </div>
</div>