<?php

namespace App\Http\Controllers;

use App\Models\JamKerja;
use App\Models\Presensi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PresensiController extends Controller
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
        $user = Auth::user();
        $presensis = $user->presensis;
        $jam_kerja = JamKerja::select('id', 'latitude', 'longitude')->first();

        // Check if the user has attended today
        $hasAttended = $presensis->where('tanggal', Carbon::now()->format('Y-m-d'))->isNotEmpty();

        return view('presensi.index', compact('presensis', 'jam_kerja', 'hasAttended'));
    }

    public function dataPresensi(Request $request)
    {
        $presensis = Presensi::query();


        if ($request->filled('bulan') && $request->filled('tahun')) {
            $presensis->whereMonth('tanggal', $request->bulan)
                ->whereYear('tanggal', $request->tahun);
        }
        $this->authorize('HRD', $this->user);
        return view('presensi.data-presensi', [
            'presensis' => $presensis->get(),
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
        $photoBase64 = $request->input('photo');
        $photoPath = $this->savePhoto($photoBase64);
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $isWithinRadius = $this->checkUserLocation($latitude, $longitude);

        $currentTime = \Carbon\Carbon::now('Asia/Jakarta');
        $status = $isWithinRadius ? 'Hadir' : 'Tidak Masuk'; // Default status

        if ($isWithinRadius && $currentTime->format('H:i:s') > '08:15:00') {
            $status = 'Terlambat';
        }

        $attendance = new Presensi();
        $attendance->users_id = Auth::user()->id;
        $attendance->status = $status;
        $attendance->jam_masuk = $currentTime->format('H:i:s');
        $attendance->tanggal = $currentTime->format('Y-m-d');
        $attendance->photo = $photoPath;

        $attendance->save();

        if ($isWithinRadius) {
            return response()->json(['success' => true, 'message' => 'Absensi berhasil']);
        } else {
            return response()->json(['success' => false, 'message' => 'Anda diluar area perusahaan']);
        }
    }




    private function savePhoto($photoBase64)
    {
        $decodedPhoto = explode('base64,', $photoBase64);
        $decodedPhoto = end($decodedPhoto);
        $decodedPhoto = str_replace(' ', '+', $decodedPhoto);
        $photoPath = 'attendance/' . uniqid() . '.jpg';
        Storage::disk('public')->put($photoPath, base64_decode($decodedPhoto));

        return $photoPath;
    }

    function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000;

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $earthRadius * $c;

        return $distance;
    }

    private function checkUserLocation($latitude, $longitude)
    {
        $company = JamKerja::first();
        if ($company) {
            $companyLatitude = $company->latitude;
            $companyLongitude = $company->longitude;
            $radius = 50;
            $distance = $this->calculateDistance($latitude, $longitude, $companyLatitude, $companyLongitude);
            return $distance <= $radius;
        }
        return false;
    }

    /**
     * Display the specified resource.
     */
    public function show(Presensi $presensi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Presensi $presensi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Presensi $presensi)
    {
        //
        $presensi->update([
            'jam_keluar' => \Carbon\Carbon::now('Asia/Jakarta')->format('H:i:s'),
        ]);

        return redirect()->route('presensi.index')->with('success', 'Selamat anda telah menyelesaikan pekerjaan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Presensi $presensi)
    {
        //
    }
}
