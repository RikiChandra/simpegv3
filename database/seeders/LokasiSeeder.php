<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LokasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        DB::table('lokasi_kerjas')->insert([
            'nama_lokasi' => 'Home',
            'latitude' => '-2.9980690484339467',
            'longitude' => '104.74987012273495',
            'jam_masuk' => '08:00:00',
            'jam_keluar' => '17:00:00'
        ]);
        DB::table('lokasi_kerjas')->insert([
            'nama_lokasi' => 'UMDP',
            'latitude' => '-2.9736841324212677',
            'longitude' => '104.76405426499063',
            'jam_masuk' => '08:00:00',
            'jam_keluar' => '17:00:00'
        ]);
    }
}
