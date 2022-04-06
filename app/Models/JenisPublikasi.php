<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPublikasi extends Model
{
    use HasFactory;
    protected $table      = 'jenis_publikasi';
    protected $primaryKey = 'id_jenis';
    protected $guarded    = [];
}
