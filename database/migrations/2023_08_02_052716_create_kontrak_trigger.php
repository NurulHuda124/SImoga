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
        (NEW.nama_pegawai, NEW.email, NEW.tanggal_kontrak_awal, NEW.tanggal_kontrak_akhir, 
        CASE WHEN
        FLOOR(DATEDIFF(CURDATE(), NEW.tanggal_kontrak_akhir) / 365.25) < 0 THEN "Berlaku" ELSE "Tidak Berlaku" END )
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
