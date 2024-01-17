<?php

namespace App\Http\Controllers;

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
            'nama_lengkap' => 'required',
            'email' => 'required',
            'nomor_telepon' => 'required',
            'portofolio' => 'required',
            'resume' => 'required|mimes:pdf|max:2048',
            'cover_letter' => 'required',
        ]);

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
            'keterangan' => 'required',
        ]);

        Lamaran::where('id', $lamaran->id)->update($validatedData);
        $lamaran = Lamaran::find($lamaran->id);

        Mail::send('emails.validasi-lamaran', ['lamaran' => $lamaran], function ($message) use ($lamaran) {
            $message->to($lamaran->email)
                ->subject('Konfirmasi Lamaran');
        });

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
