<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilSaw extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
