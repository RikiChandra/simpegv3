<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class phk extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'karyawans_id',
        'keterangan',
        'file',
        'tanggal',
    ];

    protected $dates = ['deleted_at'];

    public function karyawan()
    {
        return $this->belongsTo(karyawan::class, 'karyawans_id', 'id');
    }
}
