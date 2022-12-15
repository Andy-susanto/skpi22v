<?php

namespace App\Models;

use App\Models\Concerns\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kewirausahaan extends Model
{
    use HasFactory, UuidTrait;
    protected $table      = 'kewirausahaan';
    protected $primaryKey = 'id_kewirausahaan';
    public $incrementing = false;
    protected $fillable    = [
        'siakad_mhspt_id',
        'ref_kategori_id',
        'file_kegiatan_ref_jenis_kegiatan_id',
        'validator_id',
        'file_kegiatan_id',
        'nama_usaha',
        'nama_usaha_eng',
        'alamat_unja',
        'no_izin',
        'status_validasi',
        'pesan',
        'tgl_mulai',
        'tgl_selesai',
    ];

    protected $append = ['tahun'];

    protected function tahun(): Attribute
    {
        return new Attribute(
            get: fn () => $this->tgl_mulai,
        );
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'ref_kategori_id');
    }

    public function mhspt()
    {
        return $this->belongsTo(SiakadMhspt::class, 'siakad_mhspt_id');
    }

    public function files()
    {
        return $this->belongsTo(Files::class, 'file_kegiatan_id', 'id_files');
    }
}
