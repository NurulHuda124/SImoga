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
        CREATE TRIGGER history_trigger AFTER INSERT ON pegawais
        FOR EACH ROW
        INSERT INTO history (pegawai_id, no_induk_karyawan, file_ktp, file_nda, nama_karyawan,
        nik, email, sex, tempat_lahir, tanggal_lahir, alamat, no_telp,
        jabatan, divisi, jenis_mitra, nama_perusahaan, tanggal_kontrak_awal_perusahaan,
        tanggal_kontrak_akhir_perusahaan,
        no_kontrak_perusahaan, tanggal_kontrak_awal, tanggal_kontrak_akhir,
        status_kontrak, status_pensiun)
        VALUES
        (NEW.id, NEW.no_induk_karyawan, NEW.file_ktp, NEW.file_nda, NEW.nama_karyawan,
        NEW.nik, NEW.email, NEW.sex, NEW.tempat_lahir, NEW.tanggal_lahir, NEW.alamat, NEW.no_telp,
        NEW.jabatan, NEW.divisi, NEW.jenis_mitra, NEW.nama_perusahaan, NEW.tanggal_kontrak_awal_perusahaan,
        NEW.tanggal_kontrak_akhir_perusahaan,
        NEW.no_kontrak_perusahaan, NEW.tanggal_kontrak_awal, NEW.tanggal_kontrak_akhir,
        NEW.tanggal_kontrak_akhir, NEW.tanggal_lahir)
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS history_trigger');
    }
};