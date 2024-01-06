<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\phk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhkController extends Controller
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
        return view('phk.index', [
            'phks' => phk::with('karyawan')->get(),
            'karyawans' => Karyawan::all(),
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
        $this->authorize('HRD', $this->user);
        // Validate the request data
        $validatedData = $request->validate([
            'karyawans_id' => 'required',
            'keterangan' => 'required',
            'file' => 'required|mimes:pdf',
            'tanggal' => 'required',
        ]);

        // Add 'karyawans_id' to the validated data
        $validatedData['file'] = $request->file('file')->store('phk');

        // Create a new 'phk' record
        phk::create($validatedData);

        // Redirect with success message
        return redirect()->route('phk.index')->with('success', 'Data berhasil ditambahkan');
    }


    /**
     * Display the specified resource.
     */
    public function show(phk $phk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(phk $phk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, phk $phk)
    {
        //
        $this->authorize('HRD', $this->user);
        $validatedData = $request->validate([
            'karyawans_id' => 'required',
            'keterangan' => 'required',
            'file' => 'required|mimes:pdf',
            'tanggal' => 'required',
        ]);



        if (Storage::exists($phk->file)) {
            Storage::delete($phk->file);
        }

        $validatedData['file'] = $request->file('file')->store('phk');



        phk::where('id', $phk->id)
            ->update($validatedData);


        return redirect()->route('phk.index')->with('success', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(phk $phk)
    {
        //
        $this->authorize('HRD', $this->user);
        if (Storage::exists($phk->file)) {
            Storage::delete($phk->file);
        }

        phk::destroy($phk->id);

        return redirect()->route('phk.index')->with('success', 'Data berhasil dihapus');
    }
}
