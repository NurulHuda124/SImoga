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
        Schema::create('kontraks', function (Blueprint $table) {
            $table->id();
            $table->string('no_induk_karyawan');
            $table->string('nama_karyawan');
            $table->string('email');
            $table->date('tanggal_lahir');
            $table->string('no_kontrak_perusahaan');
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
        Schema::dropIfExists('kontraks');
    }
};
