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
            'username' => 'admin',
            'email' => 'rikichandra37@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
        DB::table('users')->insert([
            'username' => 'rchndr',
            'email' => 'rikichandra@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'karyawan',
        ]);
    }
}
