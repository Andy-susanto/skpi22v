<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Magang extends Model
{
    use HasFactory;
    protected $table      = 'magang';
    protected $primaryKey = 'id_magang';
    protected $fillable    = [
        'siakad_mhspt_id',
        'kepeg_pegawai_id',
        'file_kegiatan_id',
        'file_kegiatan_ref_jenis_kegiatan_id',
        'ref_bidang_id',
        'ref_divisi_id',
        'validator_id',
        'tgl_mulai',
        'tgl_selesai',
        'judul_laporan_akhir',
        'tugas_utama_magang',
        'nama',
        'alamat',
        'status_validasi',
        'pesan',
    ];

    protected $append = ['tahun'];

    protected function tahun(): Attribute
    {
        return new Attribute(
            get: fn () => $this->tgl_mulai,
        );
    }

    public function kepeg_pegawai()
    {
        return $this->belongsTo(KepegPegawai::class, 'kepeg_pegawai_id');
    }

    public function mhspt()
    {
        return $this->belongsTo(SiakadMhspt::class, 'siakad_mhspt_id');
    }

    public function files()
    {
        return $this->belongsTo(Files::class, 'file_kegiatan_id', 'id_files');
    }

    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'ref_bidang_id');
    }

    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'ref_divisi_id');
    }
}
