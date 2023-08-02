<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function divisi()
    {
        return $this->hasMany(Divisi::class);
    }

    public function kontrak()
    {
    return $this->hasMany(Kontrak::class, 'nama_pegawai');
    }

    public function jabatan()
    {
        return $this->hasMany(Jabatan::class);
    }
    // public function mitra_perusahaan(): BelongsTo
    // {
    //     return $this->belongsTo(MitraPerusahaan::class, 'jenis_mitra');
    // }
}
