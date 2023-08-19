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
        CREATE TRIGGER addhistory_trigger AFTER UPDATE ON pegawais
        FOR EACH ROW
        INSERT INTO history (pegawai_id, no_induk_karyawan, file_ktp, file_nda, nama_karyawan, 
        nik, email, sex, tempat_lahir, tanggal_lahir, alamat, no_telp,
        jabatan, divisi, jenis_mitra, nama_perusahaan, tanggal_kontrak_awal_perusahaan,
        tanggal_kontrak_akhir_perusahaan,
        no_kontrak_perusahaan, tanggal_kontrak_awal, tanggal_kontrak_akhir,
        status_kontrak, status_pensiun)
        VALUES
        (OLD.id, OLD.no_induk_karyawan, OLD.file_ktp, OLD.file_nda, OLD.nama_karyawan,
        OLD.nik, OLD.email, OLD.sex, OLD.tempat_lahir, OLD.tanggal_lahir, OLD.alamat, OLD.no_telp,
        OLD.jabatan, OLD.divisi, OLD.jenis_mitra, OLD.nama_perusahaan, OLD.tanggal_kontrak_awal_perusahaan,
        OLD.tanggal_kontrak_akhir_perusahaan,
        OLD.no_kontrak_perusahaan, OLD.tanggal_kontrak_awal, OLD.tanggal_kontrak_akhir,
        OLD.tanggal_kontrak_akhir, OLD.tanggal_lahir)
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS addhistory_trigger');
    }
};
