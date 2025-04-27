<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Isi Data Distributor</title>
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css')}}" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('img/bintan.png') }}">

    <!-- css tambahan dari page-->
    @yield('styles')


</head>

<body id="page-top">
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">
        
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
                <div class="sidebar-brand-text mx-2 ">SID LPG Bintan</div>
            </a>
        
            <!-- Divider -->
            <hr class="sidebar-divider my-0">
        
            <!-- Nav Item - Dashboard -->
            <li class="nav-item ">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Data Penerima Subsidi</span></a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Data Stok Subsidi</span></a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-clipboard-list"></i>
                    <span>Data Penjualan Subsidi</span></a>
            </li>
        </ul>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow flex-justify-content-between">
                
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <div class="ml-2">
                            <h3 class="fs-6 font-weight-bold text-gray-800 my-0">Lengkapi Data Berikut</h3>
                        </div>
                    </ul>
                    
                
                </nav>
                <div class="container-fluid">
                    
                    <form action="{{ route('distributor.store') }}" method="POST" class="mt-5">
                        @csrf
                    
                        <div class="mb-3">
                            <label for="nama_pt" class="form-label">Nama PT</label>
                            <input type="text" class="form-control" name="nama_toko" placeholder="Contoh: PT. Migas Alam jaya" required>
                        </div>
                    
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="3" placeholder="Contoh: Jl. Serai RT, Kijang Kota, Kec. Bintan Timur, Kab. Bintan " required></textarea>
                        </div>
                    
                        <div class="mb-3">
                            <label for="no_hp" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control" name="no_hp" placeholder="Contoh: 081234567890" required>
                        </div>
                    
                        <button type="submit" class="btn btn-outline-info">Simpan</button>
                    </form>
                </div>
            </div>
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Pemerintah Kabupaten Bintan 2025</span>
                    </div>
                </div>
            </footer>

        </div>
    </div>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
    {{-- script tambahan dari page --}}
    @yield('script')
</body>

</html>