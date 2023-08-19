<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
        CREATE TRIGGER addriwayat_trigger AFTER UPDATE ON mitra_perusahaans
        FOR EACH ROW
        INSERT INTO riwayat (mitra_perusahaan_id, email, website, no_telp_1, no_telp_2, 
        no_telp_3, jenis_mitra, nama_perusahaan, 
        tanggal_kontrak_awal_perusahaan, tanggal_kontrak_akhir_perusahaan,
        no_kontrak_perusahaan, status_kontrak_perusahaan)
        VALUES
        (OLD.id, OLD.email, OLD.website, OLD.no_telp_1, OLD.no_telp_2, 
        OLD.no_telp_3, OLD.jenis_mitra, OLD.nama_perusahaan, 
        OLD.tanggal_kontrak_awal_perusahaan, OLD.tanggal_kontrak_akhir_perusahaan,
        OLD.no_kontrak_perusahaan, 
        OLD.tanggal_kontrak_akhir_perusahaan)
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS addriwayat_trigger');
    }
};
