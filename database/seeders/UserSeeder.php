<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('users')->insert([
            'username' => 'hrd',
            'email' => 'rikichandra37@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'hrd',
        ]);
        DB::table('users')->insert([
            'username' => 'rchndr',
            'email' => 'rikichandra11317@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'karyawan',
        ]);
        DB::table('users')->insert([
            'username' => 'direktur',
            'email' => 'rikichandra246@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'direktur',
        ]);
    }
}
