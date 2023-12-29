<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LowonganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('lowongan.index', [
            'lowongans' => Lowongan::all(),
        ]);
    }

    public function career()
    {
        //
        return view('career.index', [
            'lowongans' => Lowongan::all(),
        ]);
    }

    public function detailCareer($id)
    {
        //
        return view('career.detail', [
            'lowongans' => Lowongan::find($id)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('lowongan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'nama_lowongan' => 'required',
            'jenis_pekerjaan' => 'required',
            'deskripsi' => 'required',
        ]);

        $validatedData['excerpt'] = Str::limit(strip_tags($request->deskripsi), 200);

        Lowongan::create($validatedData);

        return redirect('lowongan')->with('success', 'Lowongan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lowongan $lowongan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lowongan $lowongan)
    {
        //
        return view('lowongan.edit', [
            'lowongan' => $lowongan,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lowongan $lowongan)
    {
        //

        $validatedData = $request->validate([
            'nama_lowongan' => 'required',
            'jenis_pekerjaan' => 'required',
            'deskripsi' => 'required',
        ]);

        $validatedData['excerpt'] = Str::limit(strip_tags($request->deskripsi), 200);

        Lowongan::where('id', $lowongan->id)
            ->update($validatedData);

        return redirect('lowongan')->with('success', 'Lowongan berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lowongan $lowongan)
    {
        //

        Lowongan::destroy($lowongan->id);

        return redirect('lowongan')->with('success', 'Lowongan berhasil dihapus!');
    }
}
