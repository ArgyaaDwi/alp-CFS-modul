<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ALP Insight</title>
    <link rel="icon" type="image/jpg" href="images/logoalp.jpg">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('template/plugins/fontawesome-free/css/all.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('dataTables/dataTables.css') }}">
    <link rel="stylesheet" href="{{ asset('dataTables/dataTables.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('template/dist/css/adminlte.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('template/dist/css/adminlte.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    @stack('styles')
</head>
<style>
    #loading {
        position: fixed;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.7);
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
    }
    .spinner {
        border: 16px solid rgba(189, 189, 189, 0.1);
        width: 100px;
        height: 100px;
        border-radius: 50%;
        border-left-color: rgb(255, 232, 117);
        animation: spin 1s ease infinite;
    }
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    a {
        text-decoration: none;
    }

    table.data table.dataTable thead th {
        background-color: #FFF455;
        color: black;
    }

    table.dataTable tbody tr:nth-child(odd) {
        background-color: #f9f9f9;
    }

    table.dataTable tbody tr:nth-child(even) {
        background-color: #ffffff;
    }

    table.dataTable tbody tr:hover {
        background-color: #d1ecf1;
    }

    .navbar .nav-link.dropdown-toggle {
        background-color: #ffffff !important;
        color: inherit !important;
    }

    .navbar .nav-link.dropdown-toggle:hover,
    .navbar .nav-link.dropdown-toggle:focus {
        background-color: #ffffff !important;
        color: inherit !important;
        box-shadow: none !important;
    }
</style>

<body class="hold-transition sidebar-mini">
    <div id="loading">
        <div class="spinner"></div>
    </div>
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item">
                    <span class="nav-link" style="color: black;">
                        <strong>
                          {{ $currentDate ?? 'Unknown Day' }}
                        </strong>
                    </span>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown user-menu">
                    <a href="" class="nav-link bg-white dropdown-toggle " data-toggle="dropdown"
                        style="background-color: #ffffff; ">
                        <span class="d-none d-md-inline mr-2">{{ $user->name }}</span>
                        <img src="{{ asset('images/user.jpg') }}" class="user-image img-circle elevation-2"
                            alt="User Image">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <li class="user-header">
                            <img src="{{ asset('images/user.jpg') }}" class="img-circle elevation-2" alt="User Image">
                            <p>
                                {{ $user->name }}
                                <small>{{ $user->email }}</small>
                            </p>
                        </li>
                        <li class="user-footer">
                            <a href="" class="btn btn-outline-info  rounded btn-flat ">Profil</a>
                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger rounded btn-flat float-right">
                                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    </a>
                </li>
            </ul>
        </nav>
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-light-primary elevation-4">
            <!-- Brand Logo -->
            <a href="" class="brand-link">
                <img src="{{ asset('images/logoalp.jpg') }}" alt="Logo PT. ALP" class="brand-image "
                    style="opacity: .8">
                <span class="brand-text font-weight-bold">ALP </span>Insight
            </a>
            <!-- Sidebar -->
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('images/user.jpg') }}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="" class="d-block">{{ $user->name }}</a>
                    </div>
                </div>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('dashboard.sales') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-bars-progress"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>

                        <li class="nav-header">Kelola</li>
                        <li class="nav-item">
                            <a href="{{ route('sales.distributor.index') }}" class="nav-link">
                                <i class="nav-icon fa-regular fa-building"></i>
                                <p>Distributor</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('sales.complaint.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-comments"></i>
                                <p>Feedback</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <div class="content-wrapper">
            @yield('content')


        </div>


        <footer class="main-footer">
            <div class="text-center d-none d-sm-block">
                <strong>Copyright &copy; 2024 <a href="https://alppetro.co.id">ALP Petro Industry</a>.</strong> All
                rights reserved.
            </div>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="{{ asset('template/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    {{-- <script src="{{ asset('dataTables/dataTables.js') }}"></script>
    <script src="{{ asset('dataTables/dataTables.min.js') }}"></script> --}}
    <script src="{{ asset('template/dist/js/adminlte.min.js') }}"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script>
        window.addEventListener('beforeunload', function() {
            document.querySelector("#loading").style.display = "flex";
        });
        document.onreadystatechange = function() {
            if (document.readyState === "loading") {
                document.querySelector("#loading").style.display = "flex";
            }
        };

        // Saat halaman selesai loading, sembunyikan loading spinner setelah delay
        window.onload = function() {
            setTimeout(function() {
                document.querySelector("#loading").style.display = "none";
            }, 500); // Delay sebelum loading hilang
        };

        // Hilangkan spinner jika terjadi masalah render dobel
        window.onpageshow = function() {
            setTimeout(function() {
                document.querySelector("#loading").style.display = "none";
            }, 500); // Tambah delay untuk memastikan spinner tak tampil dobel
        };
    </script>

    @stack('scripts')
    <script>
        let table = new DataTable('#myTable');
    </script>
    <script src="https://kit.fontawesome.com/ba7a415507.js" crossorigin="anonymous"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>
