@extends('template.master')
@section('title', 'Dashboard')
@section('content')
    @if (Auth::user()->role == 'hrd')
        <div class="container mt-5">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <!-- Jumlah Pegawai -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box" style="background-color: #f4f6f9;">
                                <div class="inner">
                                    <h3>{{ $pegawai }}</h3>
                                    <p>Jumlah Pegawai</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-users"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Pegawai Hadir -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box" style="background-color: #007bff;">
                                <div class="inner text-white">
                                    <h3>{{ $hadir }}</h3>
                                    <p>Pegawai Hadir</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-user-check"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Pegawai Tidak Hadir -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box" style="background-color: #f4f6f9;">
                                <div class="inner">
                                    <h3>{{ $pegawaiTidakMasuk }}</h3>
                                    <p>Pegawai Tidak Hadir</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-user-times"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Pegawai Izin -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box" style="background-color: #007bff;">
                                <div class="inner text-white">
                                    <h3>{{ $izin }}</h3>
                                    <p>Pegawai Izin</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-user-clock"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <!-- Pengajuan Cuti -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box" style="background-color: #007bff;">
                                <div class="inner  text-white"">
                                    <h3>{{ $cuti }}</h3>
                                    <p>Pengajuan Cuti</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-calendar-alt"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Pengajuan Lamaran -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box" style="background-color: #f4f6f9;">
                                <div class="inner">
                                    <h3>{{ $pelamar }}</h3>
                                    <p>Pengajuan Lamaran</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-file-signature"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <div class="small-box" style="background-color: #007bff;">
                                <div class="inner  text-white"">
                                    <h3>{{ $Sedangcuti }}</h3>
                                    <p>Karyawan Cuti</p>
                                </div>
                                <div class="icon">
                                    <i class="nav-icon fas fa-plane"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <div class="small-box" style="background-color: #f4f6f9;">
                                <div class="inner">
                                    <h3>{{ $lowongan }}</h3>
                                    <p>Lowongan Aktif</p>
                                </div>
                                <div class="icon">
                                    <i class="nav-icon fas fa-briefcase"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="container mt-5">
            <div class="row">
                <!-- Vision Card -->
                <div class="col-lg-12 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white text-center">
                            <h4 class="mb-0">Visi</h4>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Menjadi perusahaan konstruksi dan desain bangunan yang terkemuka, diakui
                                secara global, yang mewujudkan visi klien kami menjadi realitas melalui inovasi,
                                keunggulan teknis, dan keberlanjutan.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- Mission Section -->
                <div class="col-lg-12">
                    <div class="card-deck">
                        <!-- Mission Point 1 -->
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title text-success">Kualitas Terbaik</h5>
                                    <p class="card-text">Memastikan kualitas konstruksi dan desain yang unggul.</p>
                                </div>
                            </div>
                        </div>
                        <!-- Mission Point 2 -->
                        <!-- ... Repeat for each mission point, changing the title and text as needed ... -->
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title text-success">Inovasi Berkelanjutan</h5>
                                    <p class="card-text">Menerapkan inovasi untuk meningkatkan keberlanjutan proyek.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title text-success">Pengembangan Komunitas</h5>
                                    <p class="card-text">Berkontribusi pada pengembangan dan kesejahteraan komunitas.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
