<?php

namespace App\Models;

use App\Models\Kriteria;
use App\Models\Periode;
use App\Models\Siswa;
use App\Models\SubKriteria;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
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
    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }
    public function subKriteria()
    {
        return $this->belongsTo(SubKriteria::class);
    }
}
