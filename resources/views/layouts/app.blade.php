<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title')</title>
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css')}}" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('img/bintan.png') }}">
    <style>
        html, body {
        height: 100%; !important
        }

        #content-wrapper {
            min-height: 100vh; !important
        }

        #content {
            flex: 1; !important
        }

        .sticky-footer {
            margin-top: auto; !important
        }
    </style>

    <!-- css tambahan dari page-->
    @yield('styles')


</head>

<body id="page-top">
    <div id="wrapper">
        @include('layouts.sidebar')
        <div id="content-wrapper" class="d-flex flex-column ">
            <div id="content">
               @include('layouts.topbar')
                <div class="container-fluid min-vh-100">
                    @yield('content')
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