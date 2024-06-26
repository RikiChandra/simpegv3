<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class LowonganController extends Controller
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
        return view('lowongan.index', [
            'lowongans' => Lowongan::all(),
        ]);
    }

    public function career()
    {
        $now = Carbon::now();

        $lowongans = Lowongan::whereDate('batas_waktu_mulai', '<=', $now)
            ->whereDate('batas_waktu_selesai', '>=', $now)
            ->get();


        return view('career.index', ['lowongans' => $lowongans]);
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
        $this->authorize('HRD', $this->user);
        return view('lowongan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $this->authorize('HRD', $this->user);
        $validatedData = $request->validate([
            'nama_lowongan' => 'required',
            'jenis_pekerjaan' => 'required',
            'deskripsi' => 'required',
            'batas_waktu_mulai' => 'required',
            'batas_waktu_selesai' => 'required',
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
        $this->authorize('HRD', $this->user);
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
        $this->authorize('HRD', $this->user);
        $validatedData = $request->validate([
            'nama_lowongan' => 'required',
            'jenis_pekerjaan' => 'required',
            'deskripsi' => 'required',
            'batas_waktu_mulai' => 'required',
            'batas_waktu_selesai' => 'required',
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
        $this->authorize('HRD', $this->user);
        Lowongan::destroy($lowongan->id);

        return redirect('lowongan')->with('success', 'Lowongan berhasil dihapus!');
    }
}
