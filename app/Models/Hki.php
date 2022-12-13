<?php

namespace App\Models;

use App\Models\Concerns\UuidTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hki extends Model
{
    use HasFactory, UuidTrait;
    protected $table      = 'hki_mahasiswa';
    protected $primaryKey = 'id_hki_mahasiswa';
    protected $fillable    = [
        'id_hki_mahasiswa',
        'siakad_mhspt_id',
        'jenis_hki_id',
        'jenis_ciptaan_id',
        'file_bukti_id',
        'nomor_sertifikat',
        'tgl_mulai_berlaku',
        'tgl_berakhir',
        'nama_hki',
        'nama_hki_eng',
        'pemegang_hki',
        'deskripsi_hki',
        'status_validasi'
    ];

    protected $append = ['nama'];

    protected function nama(): Attribute
    {
        return new Attribute(
            get: fn () => $this->nama_hki,
        );
    }

    public function jenis_hki()
    {
        return $this->belongsTo(JenisHki::class, 'jenis_hki_id');
    }

    public function jenis_ciptaan()
    {
        return $this->belongsTo(JenisCiptaan::class, 'jenis_ciptaan_id');
    }

    public function files()
    {
        return $this->belongsTo(Files::class, 'file_bukti_id', 'id_files');
    }

    public function mhspt()
    {
        return $this->belongsTo(SiakadMhspt::class, 'siakad_mhspt_id');
    }
}
