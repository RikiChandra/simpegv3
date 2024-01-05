<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisCuti extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'jenis_cuti',
        'jatah_cuti'
    ];

    public function cutis()
    {
        return $this->hasMany(Cuti::class);
    }

    public function karyawan()
    {
        return $this->belongsToMany(Karyawan::class, 'cutis', 'jenis_cuti_id', 'users_id');
    }
}
