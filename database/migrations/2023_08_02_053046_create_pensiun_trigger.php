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
        CREATE TRIGGER pensiun_trigger AFTER INSERT ON pegawais
        FOR EACH ROW
        INSERT INTO pensiuns (nama_pegawai, email, tanggal_lahir, status_pensiun)
        VALUES (NEW.nama_pegawai, NEW.email, NEW.tanggal_lahir,
        CASE
        WHEN FLOOR(DATEDIFF(CURDATE(), NEW.tanggal_lahir) / 365.25) >= 54 THEN "Pensiun" ELSE "Aktif" END )
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS pensiun_trigger');
    }
};