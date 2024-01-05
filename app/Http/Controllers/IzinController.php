<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use Illuminate\Http\Request;

class IzinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('izin.index', [
            'izins' => Izin::all()
        ]);
    }

    public function getDatabyUser()
    {
        //
        return view('izin.index', [
            'izins' => Izin::where('users_id', auth()->user()->id)->get()
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
            'tanggal' => 'required',
            'alasan' => 'required',
        ]);

        $validatedData['users_id'] = auth()->user()->id;

        Izin::create($validatedData);

        return redirect()->route('izin.data')->with('success', 'Izin berhasil diajukan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Izin $izin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Izin $izin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Izin $izin)
    {
        //
        $validatedData = $request->validate([
            'status' => 'required',
            'keterangan' => 'required',
        ]);

        Izin::where('id', $izin->id)->update($validatedData);

        return redirect()->route('izin.index')->with('success', 'Izin berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Izin $izin)
    {
        //
        Izin::destroy($izin->id);

        return redirect()->route('izin.data')->with('success', 'Izin berhasil dihapus');
    }
}
