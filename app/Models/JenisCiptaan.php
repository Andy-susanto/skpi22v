<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisCiptaan extends Model
{
    use HasFactory;
    protected $table      = 'jenis_ciptaan';
    protected $primaryKey = 'id_jenis_ciptaan';
    protected $guarded    = [];
}
