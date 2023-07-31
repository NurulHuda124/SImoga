<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kontrak extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function pegawai(): BelongsTo
    {
    return $this->belongsTo(Pegawai::class,'nama_pegawai');
    }
}