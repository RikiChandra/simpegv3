<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lamarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lowongan_id')->constrained('lowongans')->onDelete('cascade')->onUpdate('cascade');
            $table->string('nama_lengkap');
            $table->string('email');
            $table->string('nomor_telepon');
            $table->string('alamat')->nullable();
            $table->string('foto')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->string('agama')->nullable();
            $table->string('pendidikan')->nullable();
            $table->string('portofolio');
            $table->string('resume');
            $table->string('ijazah');
            $table->string('ktp');
            $table->string('keterangan')->nullable();
            $table->date('tanggal')->nullable();
            $table->enum('status', ['Diterima', 'Ditolak', 'Diproses', 'Interview'])->default('Diproses');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lamarans');
    }
};
