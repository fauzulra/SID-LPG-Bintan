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
        @yield('print-button')
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
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
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