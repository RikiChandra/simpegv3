<?php

namespace App\Http\Controllers;

use App\Models\JamKerja;
use Illuminate\Http\Request;

class JamKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('manajemen.index', [
            'jamKerjas' => JamKerja::all(),
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

        $validatedData = $request->validate([
            'hari' => 'required',
            'jam_masuk' => 'required',
            'jam_keluar' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        JamKerja::create($validatedData);

        return redirect()->route('jam-kerja.index')->with('success', 'Jam Kerja berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(JamKerja $jamKerja)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JamKerja $jamKerja)
    {
        //
        $jamKerja = JamKerja::find($jamKerja->id);
        return response()->json($jamKerja);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JamKerja $jamKerja)
    {
        //

        $validatedData = $request->validate([
            'hari' => 'required',
            'jam_masuk' => 'required',
            'jam_keluar' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        JamKerja::where('id', $jamKerja->id)->update($validatedData);

        return redirect()->route('jam-kerja.index')->with('success', 'Jam Kerja berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JamKerja $jamKerja)
    {
        //

        JamKerja::destroy($jamKerja->id);

        return redirect()->route('jam-kerja.index')->with('success', 'Jam Kerja berhasil dihapus');
    }
}
