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
       CREATE TRIGGER delpensiun_trigger AFTER DELETE ON pegawais
       FOR EACH ROW
       BEGIN
       DELETE FROM pensiuns WHERE pensiuns.nama_pegawai = OLD.nama_pegawai;
       END;
       ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS delpensiun_trigger');
    }
};
