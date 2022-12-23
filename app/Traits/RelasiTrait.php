<?php

namespace App\Traits;

use App\Http\Requests\BeasiswaRequest;
use App\Http\Requests\HibahRequest;
use App\Http\Requests\HkiRequest;
use App\Http\Requests\KBAsingRequest;
use App\Http\Requests\KewirausahaanRequest;
use App\Http\Requests\MagangRequest;
use App\Http\Requests\OrganisasiRequest;
use App\Http\Requests\PengabdianRequest;
use App\Http\Requests\PenghargaanRequest;
use App\Http\Requests\PublikasiRequest;
use App\Http\Requests\SeminarRequest;
use App\Models\Beasiswa;
use App\Models\Hki;
use App\Models\KemampuanBahasaAsing;
use App\Models\Kewirausahaan;
use App\Models\Magang;
use App\Models\Organisasi;
use App\Models\PenerimaHibah;
use App\Models\PengabdianMasyarakat;
use App\Models\PenghargaanKejuaraan;
use App\Models\Publikasi;
use App\Models\SeminarPelatihan;
use Illuminate\Support\Facades\View;

/**
 * Relasi Trait untuk menentukan kelas
 */
trait RelasiTrait
{

    public function relasiData($jenis)
    {
        $data = '';
        switch (true) {
            case ($jenis == 'penghargaan' || $jenis == config('kegiatan.PENGHARGAAN')):
                $data = [
                    'index' => 'penghargaan-kejuaraan.index',
                    'edit' => 'penghargaan-kejuaraan.edit',
                    'show' => 'penghargaan-kejuaraan.show',
                    'jenis' => config('kegiatan.PENGHARGAAN'),
                    'text' => 'penghargaan',
                    'model' => new PenghargaanKejuaraan(),
                    'request' => new PenghargaanRequest()
                ];
                break;
            case ($jenis == 'seminar' || $jenis == config('kegiatan.SEMINAR')):
                $data = [
                    'index' => 'seminar-pelatihan.index',
                    'edit' => 'seminar-pelatihan.edit',
                    'show' => 'seminar-pelatihan.show',
                    'jenis' => config('kegiatan.SEMINAR'),
                    'text' => 'seminar',
                    'model' => new SeminarPelatihan(),
                    'request' => new SeminarRequest()
                ];
                break;
            case ($jenis == 'hibah' || $jenis == config('kegiatan.HIBAH')):
                $data = [
                    'index' => 'penerima-hibah.index',
                    'edit' => 'penerima-hibah.edit',
                    'show' => 'penerima-hibah.show',
                    'jenis' => config('kegiatan.HIBAH'),
                    'text' => 'hibah',
                    'model' => new PenerimaHibah(),
                    'request' => new HibahRequest()
                ];
                break;
            case ($jenis == 'pengabdian' || $jenis == config('kegiatan.PENGABDIAN')):
                $data = [
                    'index' => 'pengabdian-masyarakat.index',
                    'edit' => 'pengabdian-masyarakat.edit',
                    'show' => 'pengabdian-masyarakat.show',
                    'jenis' => config('kegiatan.PENGABDIAN'),
                    'text' => 'pengabdian',
                    'model' => new PengabdianMasyarakat(),
                    'request' => new PengabdianRequest()
                ];
                break;
            case ($jenis == 'organisasi' || $jenis == config('kegiatan.ORGANISASI')):
                $data = [
                    'index' => 'organisasi.index',
                    'edit' => 'organisasi.edit',
                    'show' => 'organisasi.show',
                    'jenis' => config('kegiatan.ORGANISASI'),
                    'text' => 'organisasi',
                    'model' => new Organisasi(),
                    'request' => new OrganisasiRequest()
                ];
                break;
            case ($jenis == 'magang' || $jenis == config('kegiatan.MAGANG')):
                $data = [
                    'index' => 'magang.index',
                    'edit' => 'magang.edit',
                    'show' => 'magang.show',
                    'jenis' => config('kegiatan.MAGANG'),
                    'text' => 'magang',
                    'model' => new Magang(),
                    'request' => new MagangRequest()
                ];
                break;
            case ($jenis == 'beasiswa' || $jenis == config('kegiatan.BEASISWA')):
                $data = [
                    'index' => 'beasiswa.index',
                    'edit' => 'beasiswa.edit',
                    'show' => 'beasiswa.show',
                    'jenis' => config('kegiatan.BEASISWA'),
                    'text' => 'beasiswa',
                    'model' => new Beasiswa(),
                    'request' => new BeasiswaRequest()
                ];
                break;
            case ($jenis == 'bahasa-asing' || $jenis == config('kegiatan.BAHASAASING')):
                $data = [
                    'index' => 'kemampuan-bahasa-asing.index',
                    'edit' => 'kemampuan-bahasa-asing.edit',
                    'show' => 'kemampuan-bahasa-asing.show',
                    'jenis' => config('kegiatan.BAHASAASING'),
                    'text' => 'bahasaasing',
                    'model' => new KemampuanBahasaAsing(),
                    'request' => new KBAsingRequest()
                ];
                break;
            case ($jenis == 'kewirausahaan' || $jenis == config('kegiatan.KEWIRAUSAHAAN')):
                $data = [
                    'index' => 'kewirausahaan.index',
                    'edit' => 'kewirausahaan.edit',
                    'show' => 'kewirausahaan.show',
                    'jenis' => config('kegiatan.KEWIRAUSAHAAN'),
                    'text' => 'kewirausahaan',
                    'model' => new Kewirausahaan(),
                    'request' => new KewirausahaanRequest()
                ];
                break;
            case ($jenis == 'hki' || $jenis == config('kegiatan.HKI')):
                $data = [
                    'index' => 'hki.index',
                    'edit' => 'hki.edit',
                    'show' => 'hki.show',
                    'jenis' => config('kegiatan.HKI'),
                    'text' => 'seminar',
                    'model' => new Hki(),
                    'request' => new HkiRequest()
                ];
                break;
            case ($jenis == 'publikasi' || $jenis == config('kegiatan.PUBLIKASI')):
                $data = [
                    'index' => 'publikasi.index',
                    'edit' => 'publikasi.edit',
                    'show' => 'publikasi.show',
                    'jenis' => config('kegiatan.publikasi'),
                    'text' => 'publikasi',
                    'model' => new Publikasi(),
                    'request' => new PublikasiRequest()
                ];
                break;
            default:
                break;
        }
        return $data;
    }
}
