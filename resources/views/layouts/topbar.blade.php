<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow flex-justify-content-between">
    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>
    <!-- Topbar Navbar -->
    <ul class="navbar-nav mr-auto">
        <div class="ml-2">
            <h3 class="fs-6 font-weight-bold text-gray-800 my-0">@yield('page-title')</h3>
        </div>
    </ul>
    <ul class="navbar-nav ml-auto flex-justify-content-between items-center">
        @if(Route::currentRouteName() === 'dashboard') 
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bell fa-fw"></i>
                    <!-- Counter - Alerts -->
                    @if(Auth::user()->hasRole('admin') && count($lowStockAdmin) > 0)
                        <span class="badge badge-danger badge-counter">{{ count($lowStockAdmin) }}</span>
                    @elseif(Auth::user()->hasRole('distributor') && count($lowStockDistributor) > 0)
                        <span class="badge badge-danger badge-counter">{{ count($lowStockDistributor) }}</span>
                    @endif
                </a>
                <!-- Dropdown - Alerts -->
                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                    aria-labelledby="alertsDropdown">
                    <h6 class="dropdown-header">
                        Notification
                    </h6>
                    @if(Auth::user()->hasRole('admin'))
                        @if(count($lowStockAdmin) > 0)
                            @foreach($lowStockAdmin as $stok)
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-danger">
                                            <i class="fas fa-warehouse text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">{{ \Carbon\Carbon::now()->format('d M Y') }}</div>
                                        <span class="font-weight-bold ">Stok di {{ $stok->nama_toko }} tersisa {{$stok->total_stok  }}
                                            unit!</span>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            <div class="dropdown-item text-center small text-gray-500">Tidak ada notifikasi terbaru</div>
                        @endif
                    @elseif(Auth::user()->hasRole('distributor'))
                        @if(count($lowStockDistributor) > 0)
                            @foreach($lowStockDistributor as $stok)
                                <a class="dropdown-item d-flex align-items-center"  href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-danger">
                                            <i class="fas fa-warehouse text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">{{ \Carbon\Carbon::now()->toDateString() }}</div>
                                        <span class="text-gray-700">Stok Anda tersisa {{ $stok->jumlah_barang }} unit, segera hubungi admin!</span>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            <div class="dropdown-item text-center small text-gray-500">Tidak ada notifikasi terbaru</div>
                        @endif
                    @endif

                </div>
            </li>
        @endif
        <div class="topbar-divider d-none d-sm-block"></div>
        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class=" d-none d-lg-inline text-gray-600 small mr-5">
                    {{ ucwords(auth()->user()->name ?? 'Guest') }}
                </span>
                <img class="img-profile rounded-circle" src="{{ asset('img/admin.svg') }}">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                @if(Auth::user()->hasRole('distributor'))
                    <a class="dropdown-item" href="{{ route('distributor.profile') }}">
                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400 mb-2"></i>
                        Profil
                    </a>
                    <div class="dropdown-divider"></div>   
                @endif 
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Keluar
                </a>
            </div>
        </li>

    </ul>

</nav>


<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Keluar dari sesi?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Pilih "Logout" di bawah jika Anda siap mengakhiri sesi Anda saat ini.</div>
            <div class="modal-footer">
                
                <form action="/logout" method="post">
                @csrf
                <button class="btn btn-outline-secondary" type="button" data-dismiss="modal">Batal</button>
                    <button class="btn btn-outline-danger" type="submit" >Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>