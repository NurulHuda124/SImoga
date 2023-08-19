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
        Schema::create('history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id');
            $table->string('no_induk_karyawan',25);
            $table->string('file_ktp');
            $table->string('file_nda');
            $table->string('nama_karyawan');
            $table->bigInteger('nik');
            $table->string('email');
            $table->string('sex');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('alamat');
            $table->string('no_telp');
            $table->string('jabatan');
            $table->string('divisi');
            $table->string('jenis_mitra');
            $table->string('nama_perusahaan');
            $table->string('no_kontrak_perusahaan',25);
            $table->date('tanggal_kontrak_awal_perusahaan');
            $table->date('tanggal_kontrak_akhir_perusahaan');
            $table->date('tanggal_kontrak_awal');
            $table->date('tanggal_kontrak_akhir');
            $table->date('status_kontrak');
            $table->date('status_pensiun');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history');
    }
};