<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\JenisCuti;
use App\Models\Karyawan;
use App\Models\Presensi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CutiController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
    }
    public function index()
    {
        $karyawan = Karyawan::where('users_id', Auth::user()->id)->first();

        $jenisCutis = JenisCuti::query();

        if ($karyawan->jenis_kelamin === 'L') {
            $jenisCutis->whereNotIn('jenis_cuti', ['Cuti Melahirkan', 'Cuti Haid', 'Cuti Keguguran']);
        }

        $jenisCutis = $jenisCutis->get();

        $this->authorize('HRD', $this->user);

        return view('cuti.index', [
            'cutis' => Cuti::with('karyawan')->get(),
            'karyawans' => Karyawan::all(),
            'jenis_cutis' => $jenisCutis
        ]);
    }



    public function getDatabyUser()
    {
        //
        $karyawan = Karyawan::where('users_id', Auth::user()->id)->first();
        $jenisCutis = JenisCuti::query();

        if ($karyawan->jenis_kelamin === 'L') {
            $jenisCutis->whereNotIn('jenis_cuti', ['Cuti Melahirkan', 'Cuti Haid', 'Cuti Keguguran']);
        }

        $jenisCutis = $jenisCutis->get();
        return view('cuti.index', [
            'cutis' => Cuti::with('karyawan')->where('users_id', Auth::user()->id)->get(),
            'karyawans' => Karyawan::all(),
            'jenis_cutis' => $jenisCutis
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
        // Validasi data input
        $request->validate([
            'jenis_cuti_id' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required',
        ]);

        // Hitung jumlah hari cuti
        $tanggalMulai = new \DateTime($request->tanggal_mulai);
        $tanggalSelesai = new \DateTime($request->tanggal_selesai);
        $jumlahHari = $tanggalMulai->diff($tanggalSelesai)->days + 1;

        // Cari cuti terakhir dari user ini untuk jenis cuti ini, jika ada
        $cutiTerakhir = Cuti::where('users_id', Auth::user()->id)
            ->where('jenis_cuti_id', $request->jenis_cuti_id)
            ->orderBy('created_at', 'desc')
            ->first();

        $sisaCuti = $cutiTerakhir ? $cutiTerakhir->sisa_cuti : JenisCuti::find($request->jenis_cuti_id)->jatah_cuti;

        if ($sisaCuti < $jumlahHari) {
            return back()->with('error', 'Jatah cuti tidak mencukupi.');
        }

        // Buat pengajuan cuti
        $cuti = new Cuti();
        $cuti->users_id = Auth::user()->id;
        $cuti->jenis_cuti_id = $request->jenis_cuti_id;
        $cuti->tanggal_mulai = $request->tanggal_mulai;
        $cuti->tanggal_selesai = $request->tanggal_selesai;
        $cuti->alasan = $request->alasan;
        $cuti->jumlah_hari = $jumlahHari;
        $cuti->sisa_cuti = $sisaCuti - $jumlahHari; // Menghitung sisa cuti
        $cuti->status = 'Diproses'; // Status awal
        $cuti->save();

        return redirect()->route('cuti.data')->with('success', 'Pengajuan cuti berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cuti $cuti)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cuti $cuti)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cuti $cuti)
    {
        //
        $this->authorize('HRD', $this->user);
        $cuti = Cuti::findOrFail($cuti->id);

        // Validasi input
        $request->validate([
            'status' => 'required|in:Diterima,Ditolak,Diproses', // Validasi status
            'keterangan' => 'required', // Validasi keterangan
        ]);

        // Jika status diubah menjadi 'ditolak', kembalikan sisa cuti
        if ($request->status == 'Ditolak' && $cuti->status != 'Ditolak') {
            $cuti->sisa_cuti += $cuti->jumlah_hari;
        }

        // Update status cuti
        $cuti->status = $request->status;
        $cuti->keterangan = $request->keterangan;
        $cuti->save();

        if ($request->status == 'Diterima') {
            // Loop through the date range and create Presensi record for each date
            $tanggalMulai = new \DateTime($cuti->tanggal_mulai);
            $tanggalSelesai = new \DateTime($cuti->tanggal_selesai);

            while ($tanggalMulai <= $tanggalSelesai) {
                $presensiDate = $tanggalMulai->format('Y-m-d');

                // Create Presensi record for each date
                Presensi::create([
                    'users_id' => $cuti->users_id,
                    'status' => 'Cuti',
                    'tanggal' => $presensiDate,
                    'jam_masuk' => '00:00:00',
                    'jam_keluar' => '00:00:00',
                ]);

                // Move to the next day
                $tanggalMulai->add(new \DateInterval('P1D'));
            }
        }

        $user = User::find($cuti->users_id);
        Mail::send('emails.validasi-cuti', ['cuti' => $cuti], function ($message) use ($user) {
            $message->to($user->email, $user->username)
                ->subject('Pemberitahuan Cuti');
        });

        return redirect()->route('cuti.index')->with('success', 'Status cuti berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cuti $cuti)
    {
        //
        Cuti::destroy($cuti->id);

        return redirect()->route('cuti.data')->with('success', 'Pengajuan cuti berhasil dihapus.');
    }
}
