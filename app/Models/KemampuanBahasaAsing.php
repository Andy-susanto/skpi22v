<?php

namespace App\Models;

use App\Models\Concerns\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KemampuanBahasaAsing extends Model
{
    use HasFactory, UuidTrait;
    protected $table      = 'kemampuan_bahasa_asing';
    protected $primaryKey = 'id_kemampuan_bahasa_asing';
    protected $fillable    = [
        'id_kemampuan_bahasa_asing',
        'siakad_mhspt_id',
        'nilai_tes',
        'ref_bahasa_id',
        'ref_level_bahasa_id',
        'ref_jenis_tes_id',
        'file_kegiatan_id',
        'file_kegiatan_ref_jenis_kegiatan_id',
        'status_validasi',
        'pesan',
        'validator_id',
        'tgl_mulai',
        'tgl_selesai'
    ];

    protected $append = ['tahun'];

    protected function tahun(): Attribute
    {
        return new Attribute(
            get: fn () => $this->tgl_mulai,
        );
    }

    public function bahasa()
    {
        return $this->belongsTo(Bahasa::class, 'ref_bahasa_id');
    }

    public function level_bahasa()
    {
        return $this->belongsTo(LevelPenguasaan::class, 'ref_level_bahasa_id');
    }

    public function jenis_tes()
    {
        return $this->belongsTo(JenisTes::class, 'ref_jenis_tes_id');
    }

    public function files()
    {
        return $this->belongsTo(Files::class, 'file_kegiatan_id', 'id_files');
    }

    public function mhspt()
    {
        return $this->belongsTo(SiakadMhspt::class, 'siakad_mhspt_id');
    }
}
