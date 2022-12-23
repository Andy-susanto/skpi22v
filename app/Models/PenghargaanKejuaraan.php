<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class PenghargaanKejuaraan extends Model
{
    use HasFactory;
    protected $table      = 'penghargaan_kejuaraan_kompetensi';
    protected $primaryKey = 'id_penghargaan_kejuaraan_kompetensi';
    protected $fillable    = [
        'siakad_mhspt_id',
        'kepeg_pegawai_id',
        'ref_penyelenggara',
        'ref_tingkat_id',
        'ref_peran_prestasi_id',
        'bobot_nilai_id',
        'file_kegiatan_id',
        'file_sk_id',
        'file_kegiatan_ref_jenis_kegiatan_id',
        'ref_jenis_id',
        'validator_id',
        'nama',
        'nama_eng',
        'tgl_mulai',
        'tgl_selesai',
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


    public function penyelenggara()
    {
        return $this->belongsTo(Penyelenggara::class, 'ref_penyelenggara_id');
    }

    public function tingkat()
    {
        return $this->belongsTo(Tingkat::class, 'ref_tingkat_id');
    }

    public function prestasi()
    {
        return $this->belongsTo(Prestasi::class, 'ref_peran_prestasi_id');
    }

    public function kepeg_pegawai()
    {
        return $this->belongsTo(KepegPegawai::class, 'kepeg_pegawai_id');
    }

    public function files()
    {
        return $this->belongsTo(Files::class, 'file_kegiatan_id', 'id_files');
    }

    public function file_sk()
    {
        return $this->belongsTo(Files::class, 'file_sk_id', 'id_files');
    }

    public function bobot_nilai()
    {
        return $this->belongsTo(BobotNilai::class, 'bobot_nilai_id', 'id_bobot_nilai');
    }

    public function mhspt()
    {
        return $this->belongsTo(SiakadMhspt::class, 'siakad_mhspt_id');
    }
}
