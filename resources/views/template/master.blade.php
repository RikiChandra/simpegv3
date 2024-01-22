<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIMPEG | @yield('title')</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
    <!-- Theme style -->
    {{-- <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css?v=3.2.0') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>


            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->karyawan->nama }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">Change Password</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>

        </nav>

        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-white-primary">
            <!-- Brand Logo -->
            <h4 class="mx-2 text-bold">Atap Langit Indonesia</h4>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- SidebarSearch Form -->
                <div class="form-inline mt-3">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-header">UTAMA</li>
                        <li class="nav-item">
                            <a href="{{ url('dashboard') }}"
                                class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        @if (Auth::user()->role == 'hrd')
                            <li class="nav-header">HRD</li>
                            <li class="nav-item">
                                <a href="{{ url('lowongan') }}"
                                    class="nav-link {{ request()->is('lowongan*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-briefcase"></i>
                                    <!-- Change the icon to briefcase for Lowongan -->
                                    <p>
                                        Lowongan
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('lamaran') }}"
                                    class="nav-link {{ request()->is('lamaran*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-file-alt"></i>
                                    <!-- Change the icon to file-alt for Lamaran -->
                                    <p>
                                        Lamaran
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('karyawan') }}"
                                    class="nav-link {{ request()->is('karyawan*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-user"></i> <!-- Mengganti ikon dengan "fas fa-users" -->
                                    <p>
                                        Data Karyawan
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('user') }}"
                                    class="nav-link {{ request()->is('user*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-user-circle"></i>
                                    <!-- Mengganti ikon dengan "fas fa-user-circle" -->
                                    <p>
                                        Data Pengguna
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ url('lokasi') }}"
                                    class="nav-link {{ request()->is('lokasi*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-clock"></i>
                                    <!-- Keep the clock icon for Manajemen Jam Kerja -->
                                    <p>
                                        Lokasi dan jam kerja
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ url('/presensi/data/karyawan') }}"
                                    class="nav-link {{ request()->is('presensi/data/karyawan') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-users"></i>
                                    <!-- Keep the users icon for Data Presensi Karyawan -->
                                    <p>
                                        Data Presensi
                                    </p>
                                </a>
                            </li>
                            <li
                                class="nav-item {{ request()->is('jenis-cuti') || request()->is('cuti') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-table"></i>
                                    <p>
                                        Data Cuti
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('jenis-cuti') }}"
                                            class="nav-link {{ request()->is('jenis-cuti') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Jenis Cuti</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('cuti') }}"
                                            class="nav-link {{ request()->is('cuti') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Data Cuti Karyawan</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('izin') }}"
                                    class="nav-link {{ request()->is('izin') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-bookmark"></i>
                                    <!-- Change the icon to bookmark for Data Izin Karyawan -->
                                    <p>
                                        Data Izin Karyawan
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ url('phk') }}"
                                    class="nav-link {{ request()->is('phk') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-ban"></i>
                                    <!-- Change the icon to ban for Data PHK -->
                                    <p>
                                        Data PHK
                                    </p>
                                </a>
                            </li>
                        @endif
                        <li class="nav-header">KARYAWAN</li>
                        <li class="nav-item">
                            <a href="{{ url('presensi') }}"
                                class="nav-link {{ request()->is('presensi') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-calendar-alt"></i>
                                <!-- Use the clock icon for Presensi -->
                                <p>
                                    Presensi
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('cuti.data') }}"
                                class="nav-link {{ request()->is('data/cuti/karyawan') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-plane"></i>
                                <!-- Use the plane icon for Cuti -->
                                <p>
                                    Cuti
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('izin.data') }}"
                                class="nav-link {{ request()->is('izin/data/karyawan') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-pencil-alt"></i>
                                <!-- Use the pencil-alt icon for Izin -->
                                <p>
                                    Izin
                                </p>
                            </a>
                        </li>

                        @if (Auth::user()->role == 'direktur')
                            <li class="nav-header">Laporan</li>
                            <li class="nav-item">
                                <a href="{{ url('/presensi/data/karyawan') }}"
                                    class="nav-link {{ request()->is('/presensi/data/karyawan') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-calendar-alt"></i>
                                    <!-- Keep the calendar-alt icon for Presensi -->
                                    <p>
                                        Laporan Data Presensi
                                    </p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>@yield('title')</h1>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">

                @yield('content')

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        {{-- <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 1.0.0
            </div>
            <strong>Copyright &copy;
                <script>
                    document.write(new Date().getFullYear())
                </script> <a href="">Atap Langit Indonesia</a>.
            </strong> All rights reserved.
        </footer> --}}


        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    {{-- <script src="{{ asset('dist/js/demo.js') }}"></script> --}}
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
    </script>
    @stack('scripts')
</body>

</html>
