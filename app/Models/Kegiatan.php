<?php

namespace App\Models;

use App\Models\Concerns\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory, UuidTrait;
    protected $table = 'kegiatan';
    public $fillable = [
        'id',
        'kegiatan_id',
        'ref_jenis_kegiatan_id',
        'siakad_mhspt_id',
        'file_id',
        'detail_id',
        'validasi',
        'pesan',
    ];

    const PENGHARGAAN   = PenghargaanKejuaraan::class;
    const SEMINAR       = SeminarPelatihan::class;
    const HIBAH         = PenerimaHibah::class;
    const PENGABDIAN    = PengabdianMasyarakat::class;
    const ORGANISASI    = Organisasi::class;
    const MAGANG        = Magang::class;
    const BEASISWA      = Beasiswa::class;
    const BAHASAASING   = Bahasa::class;
    const KEWIRAUSAHAAN = Kewirausahaan::class;
    const HKI           = Hki::class;
    const PUBLIKASI     = Publikasi::class;

    public function jenis_kegiatan()
    {
        return $this->belongsTo(JenisKegiatan::class, 'ref_jenis_kegiatan_id');
    }

    public function mhs_pt()
    {
        return $this->belongsTo(SiakadMhspt::class, 'siakad_mhspt_id');
    }

    public function relasi()
    {
        return $this->belongsTo($this->getData($this->ref_jenis_kegiatan_id), 'kegiatan_id');
    }

    public function getData($jenisKegiatan)
    {
        $data = '';
        switch ($jenisKegiatan) {
            case config('kegiatan.PENGHARGAAN'):
                $data = Kegiatan::PENGHARGAAN;
                break;
            case config('kegiatan.SEMINAR'):
                $data = Kegiatan::SEMINAR;
                break;
            case config('kegiatan.HIBAH'):
                $data = Kegiatan::HIBAH;
                break;
            case config('kegiatan.PENGABDIAN'):
                $data = Kegiatan::PENGABDIAN;
                break;
            case config('kegiatan.ORGANISASI'):
                $data = Kegiatan::ORGANISASI;
                break;
            case config('kegiatan.MAGANG'):
                $data = Kegiatan::MAGANG;
                break;
            case config('kegiatan.BEASISWA'):
                $data = Kegiatan::BEASISWA;
                break;
            case config('kegiatan.BAHASAASING'):
                $data = Kegiatan::BAHASAASING;
                break;
            case config('kegiatan.KEWIRAUSAHAAN'):
                $data = Kegiatan::KEWIRAUSAHAAN;
                break;
            case config('kegiatan.HKI'):
                $data = Kegiatan::HKI;
                break;
            case config('kegiatan.PUBLIKASI'):
                $data = Kegiatan::PUBLIKASI;
                break;
            default:
                break;
        }

        return $data;
    }
}
