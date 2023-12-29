<?php

namespace App\Http\Controllers;

use App\Models\Lamaran;
use App\Models\Lowongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LamaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lamaran $lamaran)
    {
        //
        if (Storage::exists($lamaran->resume)) {
            Storage::delete($lamaran->resume);
        }

        $lamaran->delete();

        return redirect()->route('lamaran.index')->with('success', 'Lamaran berhasil dihapus');
    }
}
