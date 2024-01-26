<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Lamaran;
use App\Models\Lowongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class LamaranController extends Controller
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
        //
        $this->authorize('HRD', $this->user);
        return view('lamaran.index', [
            'lamarans' => Lamaran::with('lowongan')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        //
        return view('career.kirim-lamaran', [
            'lowongans' => Lowongan::findOrFail($id),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'lowongan_id' => 'required',
            'foto' => 'required|mimes:jpg,jpeg,png|max:2048',
            'nama_lengkap' => 'required',
            'email' => 'required',
            'nomor_telepon' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'tempat_lahir' => 'required',
            'agama' => 'required',
            'pendidikan' => 'required',
            'portofolio' => 'required',
            'resume' => 'required|mimes:pdf|max:2048',
            'ijazah' => 'required|mimes:pdf|max:2048',
            'ktp' => 'required|mimes:jpg,jpeg,png|max:2048',
        ]);


        $validatedData['foto'] = $request->file('foto')->store('foto-pelamar');
        $validatedData['ijazah'] = $request->file('ijazah')->store('ijazah-pdf');
        $validatedData['ktp'] = $request->file('ktp')->store('ktp-img');
        $validatedData['resume'] = $request->file('resume')->store('resume-pdf');

        Lamaran::create($validatedData);

        Mail::send('emails.konfirmasi-lamaran', [], function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Konfirmasi Lamaran');
        });

        return redirect()->route('career.index')->with('success', 'Lamaran berhasil dikirim');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lamaran $lamaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lamaran $lamaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lamaran $lamaran)
    {
        //

        $this->authorize('HRD', $this->user);

        $validatedData = $request->validate([
            'status' => 'required',
            'keterangan' => '',
            'tanggal' => '',
        ]);

        Lamaran::where('id', $lamaran->id)->update($validatedData);
        $lamaran = Lamaran::find($lamaran->id);

        Mail::send('emails.validasi-lamaran', ['lamaran' => $lamaran], function ($message) use ($lamaran) {
            $message->to($lamaran->email)
                ->subject('Konfirmasi Lamaran');
        });

        if ($request->status == 'Diterima') {
            Karyawan::create([
                'users_id' => Null,
                'nama' => $request->nama,
                'foto' => $request->foto,
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
                'email' => $request->email,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir,
                'tempat_lahir' => $request->tempat_lahir,
                'agama' => $request->agama,
                'pendidikan' => $request->pendidikan,
            ]);
        }


        return redirect()->route('lamaran.index')->with('success', 'Status lamaran berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lamaran $lamaran)
    {
        //
        $this->authorize('HRD', $this->user);
        if (Storage::exists($lamaran->resume)) {
            Storage::delete($lamaran->resume);
        }

        $lamaran->delete();

        return redirect()->route('lamaran.index')->with('success', 'Lamaran berhasil dihapus');
    }
}
