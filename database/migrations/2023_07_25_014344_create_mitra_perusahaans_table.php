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
        Schema::create('mitra_perusahaans', function (Blueprint $table) {
            $table->id();
            $table->string('no_kontrak_perusahaan',25);
            $table->string('nama_perusahaan');
            $table->string('jenis_mitra');
            $table->string('email');
            $table->string('website');
            $table->string('no_telp_1');
            $table->string('no_telp_2')->nullable();
            $table->string('no_telp_3')->nullable();
            $table->date('tanggal_kontrak_awal_perusahaan');
            $table->date('tanggal_kontrak_akhir_perusahaan');
            $table->date('status_kontrak_perusahaan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mitra_perusahaans');
    }
};
