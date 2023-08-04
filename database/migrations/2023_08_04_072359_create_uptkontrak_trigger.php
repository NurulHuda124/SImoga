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
        CREATE TRIGGER uptkontrak_trigger AFTER UPDATE ON pegawais
        FOR EACH ROW
        BEGIN
        UPDATE kontraks
        SET
        nama_pegawai = NEW.nama_pegawai,
        email = NEW.email,
        tanggal_kontrak_awal = NEW.tanggal_kontrak_awal,
        tanggal_kontrak_akhir = NEW.tanggal_kontrak_akhir,
        status_kontrak = NEW.tanggal_kontrak_akhir
        WHERE kontraks.id = NEW.id;
        END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS uptkontrak_trigger');
    }
};
