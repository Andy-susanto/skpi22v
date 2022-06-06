<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapBobot extends Model
{
    use HasFactory;
    protected $table      = 'skpi.rekap_bobot_mahasiswa';
    protected $guarded    = [];
    protected $primaryKey = 'id_rekap_bobot_mahasiswa';

    public function mhspt(){
        return $this->belongsTo(SiakadMhspt::class,'siakad_mhspt_id');
    }
}
