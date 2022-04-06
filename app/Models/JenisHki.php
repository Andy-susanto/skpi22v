<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisHki extends Model
{
    use HasFactory;
    protected $table      = 'jenis_hki';
    protected $primaryKey = 'id_jenis_hki';
    protected $guarded    = [];
}
