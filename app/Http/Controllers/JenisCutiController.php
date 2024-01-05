<?php

namespace App\Http\Controllers;

use App\Models\JenisCuti;
use Illuminate\Http\Request;

class JenisCutiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('cuti.jenisCuti', [
            'jenisCutis' => JenisCuti::all()
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
            'jenis_cuti' => 'required',
            'jatah_cuti' => 'required'
        ]);

        JenisCuti::create($validatedData);

        return redirect()->route('jenis-cuti.index')->with('success', 'Jenis Cuti berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(JenisCuti $jenisCuti)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisCuti $jenisCuti)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JenisCuti $jenisCuti)
    {
        //
        $validatedData = $request->validate([
            'jenis_cuti' => 'required',
            'jatah_cuti' => 'required'
        ]);

        JenisCuti::where('id', $jenisCuti->id)->update($validatedData);

        return redirect()->route('jenis-cuti.index')->with('success', 'Jenis Cuti berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisCuti $jenisCuti)
    {
        //

        JenisCuti::destroy($jenisCuti->id);

        return redirect()->route('jenis-cuti.index')->with('success', 'Jenis Cuti berhasil dihapus');
    }
}
