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
        Schema::create('cutis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('users_id');
            $table->foreign('users_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->unsignedBigInteger('jenis_cuti_id');
            $table->foreign('jenis_cuti_id')
                ->references('id')
                ->on('jenis_cutis')
                ->onDelete('cascade');
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->string('keterangan')->nullable();
            $table->enum('status', ['Diterima', 'Ditolak', 'Diproses'])->nullable();
            $table->string('alasan')->nullable();
            $table->integer('jumlah_hari')->nullable();
            $table->string('sisa_cuti')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cutis');
    }
};
