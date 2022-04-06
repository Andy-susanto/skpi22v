<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriCapaian extends Model
{
    use HasFactory;
    protected $table      = 'kategori_capaian';
    protected $primaryKey = 'id_kategori_capaian';
    protected $guarded    = [];
}
