<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publikasi extends Model
{
    use HasFactory;
    protected $table      = 'publikasi_mahasiswa';
    protected $primaryKey = 'id_publikasi';
    protected $guarded    = [];

    public function jenis_publikasi(){
        return $this->belongsTo('App\Models\JenisPublikasi', 'jenis_id');
    }

    public function kategori_capaian(){
        return $this->belongsTo('App\Models\KategoriCapaian', 'kategori_capaian_id');
    }

    public function files(){
        return $this->belongsTo('App\Models\Files', 'bukti', 'id_files');
    }

    public function mhspt(){
        return $this->belongsTo('App\Models\SiakadMhspt', 'siakad_mhspt_id');
    }

}
