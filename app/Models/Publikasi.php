<?php

namespace App\Models;

use App\Models\Concerns\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publikasi extends Model
{
    use HasFactory,UuidTrait;
    protected $table      = 'publikasi_mahasiswa';
    protected $primaryKey = 'id_publikasi';
    protected $fillable    = [
        'id_publikasi',
        'siakad_mhspt_id',
        'kategori_capaian_id',
        'id_usulan',
        'jenis_id',
        'validator_id',
        'file_bukti_id',
        'judul',
        'tgl_terbit',
        'penerbit',
        'tautan_eksternal',
    ];

    public function jenis_publikasi(){
        return $this->belongsTo('App\Models\JenisPublikasi', 'jenis_id');
    }

    public function kategori_capaian(){
        return $this->belongsTo('App\Models\KategoriCapaian', 'kategori_capaian_id');
    }

    public function files(){
        return $this->belongsTo('App\Models\Files', 'file_bukti_id', 'id_files');
    }

    public function mhspt(){
        return $this->belongsTo('App\Models\SiakadMhspt', 'siakad_mhspt_id');
    }

    public function kepeg_pegawai(){
        return $this->belongsTo(KepegPegawai::class,'kepeg_pegawai_id');
    }

    public function penyelenggara(){
        return $this->belongsTo(Penyelenggara::class,'ref_penyelenggara_id');
    }

    public function tingkat(){
        return $this->belongsTo(Tingkat::class,'ref_tingkat_id');
    }

    public function prestasi(){
        return $this->belongsTo(Prestasi::class,'ref_peran_prestasi_id');
    }

}
