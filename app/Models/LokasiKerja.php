<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiKerja extends Model
{
    use HasFactory;

    protected $fillable = ['nama_lokasi', 'latitude', 'longitude', 'jam_masuk', 'jam_keluar'];
}
