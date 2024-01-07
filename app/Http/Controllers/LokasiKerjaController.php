<?php

namespace App\Http\Controllers;

use App\Models\LokasiKerja;
use Illuminate\Http\Request;

class LokasiKerjaController extends Controller
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
        return view('lokasi_kerja.index', [
            'lokasi_kerjas' => LokasiKerja::all()
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
        $this->authorize('HRD', $this->user);
        $validatedData = $request->validate([
            'nama_lokasi' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'jam_masuk' => 'required',
            'jam_keluar' => 'required',
        ]);

        LokasiKerja::create($validatedData);

        return redirect()->route('lokasi.index')->with('success', 'Lokasi kerja berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(LokasiKerja $lokasiKerja)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LokasiKerja $lokasiKerja)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LokasiKerja $lokasiKerja)
    {
        //
        $this->authorize('HRD', $this->user);
        $validatedData = $request->validate([
            'nama_lokasi' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'jam_masuk' => 'required',
            'jam_keluar' => 'required',
        ]);

        // dd($request->all());

        LokasiKerja::where('id', $lokasiKerja->id)->update($validatedData);

        return redirect()->route('lokasi.index')->with('success', 'Lokasi kerja berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LokasiKerja $lokasiKerja)
    {
        //
        $this->authorize('HRD', $this->user);
        LokasiKerja::destroy($lokasiKerja->id);

        return redirect()->route('lokasi.index')->with('success', 'Lokasi kerja berhasil dihapus');
    }
}
