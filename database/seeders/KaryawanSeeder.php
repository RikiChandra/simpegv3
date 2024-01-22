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
            'nama' => 'Riki Chandra',
            'users_id' => 1,
            'alamat' => 'Jl. Contoh No. 123',
            'telepon' => '08123456789',
            'email' => 'rikichandra37@gmail.com',
            'foto' => 'foto-image/fm87KJO5jQzv6M0LcQwaSzGQqIxGUvrQCl2DXD28.png',
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => '1990-05-15',
            'tempat_lahir' => 'Jakarta',
            'agama' => 'Islam',
            'pendidikan' => 'Sarjana/S1',
            'jabatan' => 'HRD',
            'status' => 'aktif',
            'no_ktp' => '1234567890',
            'no_rekening' => '0987654321',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('karyawans')->insert([
            'nama' => 'Chandra',
            'users_id' => 2,
            'alamat' => 'Jl. Contoh No. 123',
            'telepon' => '08123456789',
            'email' => 'rikichandra11317@gmail.com',
            'foto' => 'foto-image/fm87KJO5jQzv6M0LcQwaSzGQqIxGUvrQCl2DXD28.png',
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => '1990-05-15',
            'tempat_lahir' => 'Jakarta',
            'agama' => 'Islam',
            'pendidikan' => 'Sarjana/S1',
            'jabatan' => 'Karyawan',
            'status' => 'aktif',
            'no_ktp' => '1234567890',
            'no_rekening' => '0987654321',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('karyawans')->insert([
            'nama' => 'Mark Zuckerberg',
            'users_id' => 3,
            'alamat' => 'Jl. Contoh No. 123',
            'telepon' => '08123456789',
            'email' => 'rikichandra246@gmail.com',
            'foto' => 'foto-image/fm87KJO5jQzv6M0LcQwaSzGQqIxGUvrQCl2DXD28.png',
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => '1990-05-15',
            'tempat_lahir' => 'Jakarta',
            'agama' => 'Islam',
            'pendidikan' => 'Sarjana/S1',
            'jabatan' => 'Direktur Utama',
            'status' => 'aktif',
            'no_ktp' => '1234567890',
            'no_rekening' => '0987654321',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
