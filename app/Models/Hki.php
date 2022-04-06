<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hki extends Model
{
    use HasFactory;
    protected $table      = 'hki_mahasiswa';
    protected $primaryKey = 'id_hki_mahasiswa';
    protected $guarded    = [];

    public function jenis_hki(){
        return $this->belongsTo(JenisHki::class,'jenis_hki_id');
    }

    public function jenis_ciptaan(){
        return $this->belongsTo(JenisCiptaan::class,'jenis_ciptaan_id');
    }

    public function files(){
        return $this->belongsTo(Files::class,'file_bukti_id','id_files');
    }

}
