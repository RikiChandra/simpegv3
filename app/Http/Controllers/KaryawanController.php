<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KaryawanController extends Controller
{
    //

    public function index()
    {
        return view('karyawan.index', [
            'karyawans' => Karyawan::all(),

        ]);
    }

    public function create()
    {
        return view('karyawan.create', [
            'user' => User::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'users_id' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
            'email' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'tempat_lahir' => 'required',
            'agama' => 'required',
            'pendidikan' => 'required',
            'jabatan' => 'required',
            'status' => 'required',
            'no_ktp' => 'required',
            'no_rekening' => 'required',
        ]);

        $validatedData['foto'] = $request->file('foto')->store('foto-image', 'public');

        Karyawan::create($validatedData);

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil ditambahkan');
    }

    public function edit(Karyawan $karyawan)
    {
        return view('karyawan.edit', [
            'karyawan' => $karyawan,
            'user' => User::all(),
        ]);
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'users_id' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
            'email' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'tempat_lahir' => 'required',
            'agama' => 'required',
            'pendidikan' => 'required',
            'jabatan' => 'required',
            'status' => 'required',
            'no_ktp' => 'required',
            'no_rekening' => 'required',
        ]);

        if (Storage::exists($karyawan->foto) && $request->file('foto')) {
            Storage::delete($karyawan->foto);
            $validatedData['foto'] = $request->file('foto')->store('foto-image', 'public');
        }
        // dd($validatedData);

        Karyawan::where('id', $karyawan->id)
            ->update($validatedData);

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil diupdate');
    }


    public function destroy(Karyawan $karyawan)
    {

        if (Storage::exists($karyawan->foto)) {
            Storage::delete($karyawan->foto);
        }
        $karyawan->destroy($karyawan->id);

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil dihapus');
    }
}
