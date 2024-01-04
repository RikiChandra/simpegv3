<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('karyawans')->insert([
            'nama' => 'John Doe',
            'users_id' => 1,
            'alamat' => 'Jl. Contoh No. 123',
            'telepon' => '08123456789',
            'email' => 'johndoe@example.com',
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => '1990-05-15',
            'tempat_lahir' => 'Jakarta',
            'agama' => 'Islam',
            'pendidikan' => 'Sarjana/S1',
            'jabatan' => 'Manager',
            'status' => 'aktif',
            'no_ktp' => '1234567890',
            'no_rekening' => '0987654321',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
