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
        CREATE TRIGGER riwayat_trigger AFTER INSERT ON mitra_perusahaans
        FOR EACH ROW
        INSERT INTO riwayat (mitra_perusahaan_id, email, website, no_telp_1, no_telp_2, 
        no_telp_3, jenis_mitra, nama_perusahaan, 
        tanggal_kontrak_awal_perusahaan, tanggal_kontrak_akhir_perusahaan,
        no_kontrak_perusahaan, status_kontrak_perusahaan)
        VALUES
        (NEW.id, NEW.email, NEW.website, NEW.no_telp_1, NEW.no_telp_2, 
        NEW.no_telp_3, NEW.jenis_mitra, NEW.nama_perusahaan, 
        NEW.tanggal_kontrak_awal_perusahaan, NEW.tanggal_kontrak_akhir_perusahaan,
        NEW.no_kontrak_perusahaan, 
        NEW.tanggal_kontrak_akhir_perusahaan)
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS riwayat_trigger');
    }
};