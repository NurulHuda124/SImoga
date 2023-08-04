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
       CREATE TRIGGER delkontrak_trigger AFTER DELETE ON pegawais
       FOR EACH ROW
       BEGIN
       DELETE FROM kontraks WHERE kontraks.id = OLD.id;
       END;
       ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS delkontrak_trigger');
    }
};
