<?php

namespace App\Models;

use App\Models\Concerns\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Beasiswa extends Model
{
    use HasFactory, UuidTrait;
    protected $table        = 'beasiswa';
    protected $primaryKey   = 'id_beasiswa';
    public    $incrementing = false;
    protected $fillable      = [
        'id_beasiswa',
        'siakad_mhspt_id',
        'nama',
        'nama_eng',
        'nama_promotor',
        'ref_kategori_id',
        'ref_cakupan_beasiswa_id',
        'file_kegiatan_id',
        'file_kegiatan_ref_jenis_kegiatan_id',
        'siakad_mhspt_id',
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

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'ref_kategori_id');
    }

    public function cakupan_beasiswa()
    {
        return $this->belongsTo(CakupanBeasiswa::class, 'ref_cakupan_beasiswa_id');
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
