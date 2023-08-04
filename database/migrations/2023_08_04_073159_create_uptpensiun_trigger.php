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
        CREATE TRIGGER uptpensiun_trigger AFTER UPDATE ON pegawais
        FOR EACH ROW
        BEGIN
        UPDATE pensiuns
        SET
        nama_pegawai = NEW.nama_pegawai,
        email = NEW.email,
        tanggal_lahir = NEW.tanggal_lahir,
        status_pensiun= NEW.tanggal_lahir
        WHERE pensiuns.id = NEW.id;
        END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS uptpensiun_trigger');
    }
};
