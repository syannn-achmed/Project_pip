<?php

namespace App\Models;

use App\Models\HasilSaw;
use App\Models\Penilaian;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siswa extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public function penilaians()
    {
        return $this->hasMany(Penilaian::class);
    }

    public function hasilSaws()
    {
        return $this->hasMany(HasilSaw::class);
    }

    public function hasilSaw() // Singular, relasi terbaru
    {
        return $this->hasOne(HasilSaw::class)->latestOfMany();
    }
}
