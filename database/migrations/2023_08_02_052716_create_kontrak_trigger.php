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
        INSERT INTO kontraks (nama_pegawai, email, tanggal_kontrak_awal, tanggal_kontrak_akhir , status_kontrak) 
        VALUES
        (NEW.nama_pegawai, NEW.email, NEW.tanggal_kontrak_awal, NEW.tanggal_kontrak_akhir, NEW.tanggal_kontrak_akhir)
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
