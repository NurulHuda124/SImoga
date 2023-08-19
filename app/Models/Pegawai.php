<?php

namespace App\Models;

use App\Models\History;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function history()
    {
    return $this->hasMany(History::class);
    }
}