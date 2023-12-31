<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MitraPerusahaan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function riwayat()
    {
    return $this->hasMany(Riwayat::class);
    }
}