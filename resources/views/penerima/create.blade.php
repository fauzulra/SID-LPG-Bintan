@extends('layouts.app')

@section('title', 'Tambah Data Penerima Subsidi')

@section('styles')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@endsection

@section('page-title', ' Tambah Data Penerima Subsidi')

@section('content')
    <form action="{{ route('penerima.store') }}" method="post" enctype="multipart/form-data" class="mb-5">
        @csrf
        <div class="row">
            <div class="form-group col-md-4 ">
                <label for="jenis_pengguna" class="form-label">Jenis Pengguna</label><b class="text-danger">*</b><br>
                <select name="jenis_pengguna" id="jenis_pengguna" class="form-control">
                    <option value="Rumah Tangga" {{ old('jenis_pengguna') === 'Rumah Tangga' ? 'selected' : '' }}>
                        Rumah Tangga</option>
                    <option value="UMKM" {{ old('jenis_pengguna') === 'UMKM' ? 'selected' : '' }}>UMKM</option>
                </select>
                @error('jenis_pengguna')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div id="formRumahTangga">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="nama">Nama</label>
                    <b class="text-danger">*</b>
                    <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukkan Nama" required>
                    @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="nik">NIK</label>
                    <b class="text-danger">*</b>
                    <input type="text" name="nik" class="form-control " id="nik" placeholder="Masukkan NIK" required pattern="\d{16}" minlength="16" maxlength="16" title="NIK harus berisi tepat 16 digit angka">
                    @error('nik')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">
                        <em><span style="color: red">*</span>16 Digit Angka</em>
                    </small>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="alamat">Alamat</label>
                    <b class="text-danger">*</b>
                    <textarea type="text" name="alamat" rows="3" class="form-control" id="alamat"
                    placeholder="Masukkan Alamat" required></textarea>
                    @error('alamat')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="no_hp">Nomor HP</label>
                    <b class="text-danger">*</b>
                    <input type="text" name="no_hp" class="form-control" id="no_hp" placeholder="Masukkan Nomor HP" required>
                    @error('no_hp')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="foto_ktp">Foto KTP</label> 
                    <b class="text-danger">*</b>
                    <br>
                    <input type="file" name="foto_ktp" id="foto_ktp" accept="image/*" onchange="previewImage(event)" required>
                    <br>
                    <img id="preview" src="#" alt="Preview Gambar" style="display: none; max-height: 200px; margin-top: 10px;">
                </div>
            </div>
        </div>
        <div id="formUMKM" style="display: none;">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="nama_usaha">Nama Usaha</label>
                    <b class="text-danger">*</b>
                    <input type="text" name="nama_usaha" class="form-control " id="name" placeholder="Masukkan Nama" required>
                    @error('nama_usaha')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="nik">NIB</label>
                    <b class="text-danger">*</b>
                    <input type="text" name="nib" class="form-control" id="nib" placeholder="Masukkan NIB" required>
                    @error('nib')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mb-3">
                <label for="foto_usaha">Foto Usaha</label> 
                <b class="text-danger">*</b><br>
                <input type="file" name="foto_usaha" id="foto_usaha" accept="image/*" onchange="previewImage(event)" required>
                <br>
                <img id="preview1" src="#" alt="Preview Gambar" style="display: none; max-height: 200px; margin-top: 10px;">
            </div>
        </div>
        <button class="btn btn-outline-info mt-2" type="submit" onclick="return confirm('Data Sudah Sesuai?')">Submit</button>
    </form>

    <script>
        const selectTipe = document.getElementById('jenis_pengguna');
            const formRT = document.getElementById('formRumahTangga');
            const formUMKM = document.getElementById('formUMKM');

            selectTipe.addEventListener('change', function () {
                const isUMKM = this.value === 'UMKM';

                // Toggle tampil/hidden
                formRT.style.display = isUMKM ? 'none' : 'block';
                formUMKM.style.display = isUMKM ? 'block' : 'none';

                // Enable/disable semua input di formRumahTangga
                formRT.querySelectorAll('input, textarea, select').forEach(el => {
                    el.disabled = isUMKM;       // disable RT jika UMKM dipilih
                    if (!isUMKM && el.hasAttribute('required')) {
                        el.setAttribute('required', 'required'); // pastikan required
                    }
                });

                // Enable/disable semua input di formUMKM
                formUMKM.querySelectorAll('input, textarea, select').forEach(el => {
                    el.disabled = !isUMKM;      // disable UMKM jika RT dipilih
                    if (isUMKM && el.hasAttribute('required')) {
                        el.setAttribute('required', 'required');
                    }
                });
            });

            // Inisialisasi sekali saat halaman load,
            // supaya kondisi default langsung sesuai pilihan awal.
            selectTipe.dispatchEvent(new Event('change'));


        function previewImage(event) {
                const preview = document.getElementById(['preview', 'preview1'][event.target.id === 'foto_ktp' ? 0 : 1]);
                const file = event.target.files[0];

                if (file) {
                    preview.src = URL.createObjectURL(file);
                    preview.style.display = 'block';
                }
            }

    </script>

@endsection
