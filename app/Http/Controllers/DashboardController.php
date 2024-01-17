<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\Izin;
use App\Models\Karyawan;
use App\Models\Lamaran;
use App\Models\Lowongan;
use App\Models\Presensi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $today = now('Asia/Jakarta')->toDateString();
        $pegawai = Karyawan::count();
        $hadir = Presensi::whereIn('status', ['Hadir', 'Terlambat'])
            ->whereDate('tanggal', $today)
            ->count();
        $pegawaiTidakMasuk = max($pegawai - $hadir, 0);
        $cuti = Cuti::where('status', 'Diproses')->count();
        $Sedangcuti = Cuti::where('status', 'Diterima')->whereDate('tanggal_mulai', '<=', $today)->whereDate('tanggal_selesai', '>=', $today)->count();
        $izin = Izin::where('tanggal', $today)->count();
        $pelamar = Lamaran::where('status', 'Diproses')->count();
        $lowongan = Lowongan::where('batas_waktu_selesai', '>=', $today)->count();


        return view('dashboard.index', [
            'pegawai' => $pegawai,
            'hadir' => $hadir,
            'pegawaiTidakMasuk' => $pegawaiTidakMasuk,
            'cuti' => $cuti,
            'Sedangcuti' => $Sedangcuti,
            'izin' => $izin,
            'pelamar' => $pelamar,
            'lowongan' => $lowongan,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
