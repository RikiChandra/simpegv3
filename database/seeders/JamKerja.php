<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JamKerja extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        DB::table('jam_kerjas')->insert([
            'hari' => 'Senin',
            'jam_masuk' => '08:00:00',
            'jam_keluar' => '17:00:00',
            'latitude' => "-2.998066107459738",
            'longitude' => "104.74987115952074",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('jam_kerjas')->insert([
            'hari' => 'Selasa',
            'jam_masuk' => '08:00:00',
            'jam_keluar' => '17:00:00',
            'latitude' => "-2.998066107459738",
            'longitude' => "104.74987115952074",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('jam_kerjas')->insert([
            'hari' => 'Rabu',
            'jam_masuk' => '08:00:00',
            'jam_keluar' => '17:00:00',
            'latitude' => "-2.998066107459738",
            'longitude' => "104.74987115952074",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('jam_kerjas')->insert([
            'hari' => 'Kamis',
            'jam_masuk' => '08:00:00',
            'jam_keluar' => '17:00:00',
            'latitude' => "-2.998066107459738",
            'longitude' => "104.74987115952074",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('jam_kerjas')->insert([
            'hari' => 'Jumat',
            'jam_masuk' => '08:30:00',
            'jam_keluar' => '16:30:00',
            'latitude' => "-2.998066107459738",
            'longitude' => "104.74987115952074",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('jam_kerjas')->insert([
            'hari' => 'Sabtu',
            'jam_masuk' => '09:00:00',
            'jam_keluar' => '12:00:00',
            'latitude' => "-2.998066107459738",
            'longitude' => "104.74987115952074",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
