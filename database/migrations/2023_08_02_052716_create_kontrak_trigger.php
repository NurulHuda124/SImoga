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
        CREATE TRIGGER kontrak_trigger AFTER INSERT ON pegawais
        FOR EACH ROW
        INSERT INTO kontraks (no_induk_karyawan, nama_karyawan, email, tanggal_lahir, 
        no_kontrak_perusahaan, tanggal_kontrak_awal, tanggal_kontrak_akhir,
        status_kontrak, status_pensiun)
        VALUES
        (NEW.no_induk_karyawan, NEW.nama_karyawan, NEW.email,NEW.tanggal_lahir,
        NEW.no_kontrak_perusahaan, NEW.tanggal_kontrak_awal, NEW.tanggal_kontrak_akhir,
        NEW.tanggal_kontrak_akhir, NEW.tanggal_lahir)
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS kontrak_trigger');
    }
};
