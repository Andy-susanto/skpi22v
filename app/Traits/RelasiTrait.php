<?php

namespace App\Traits;

use App\Http\Requests\BeasiswaRequest;
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
    public function relasiClass($jenis)
    {
        $data = '';
        switch ($jenis) {
            case config('kegiatan.PENGHARGAAN'):
                $data = new PenghargaanKejuaraan();
                break;
            case config('kegiatan.SEMINAR'):
                $data = new SeminarPelatihan();
                break;
            case config('kegiatan.HIBAH'):
                $data = new PenerimaHibah();
                break;
            case config('kegiatan.PENGABDIAN'):
                $data = new PengabdianMasyarakat();
                break;
            case config('kegiatan.ORGANISASI'):
                $data = new Organisasi();
                break;
            case config('kegiatan.MAGANG'):
                $data = new Magang();
                break;
            case config('kegiatan.BEASISWA'):
                $data = new Beasiswa();
                break;
            case config('kegiatan.BAHASAASING'):
                $data = new KemampuanBahasaAsing();
                break;
            case config('kegiatan.KEWIRAUSAHAAN'):
                $data = new Kewirausahaan();
                break;
            case config('kegiatan.HKI'):
                $data = new Hki();
                break;
            case config('kegiatan.PUBLIKASI'):
                $data = new Publikasi();
                break;
            default:
                break;
        }

        return $data;
    }
    public function relasiView($jenis)
    {
        $view = '';
        switch ($jenis) {
            case 'penghargaan':
                $view = [
                    'view' => 'penghargaan-kejuaraan.index',
                    'edit' => 'penghargaan-kejuaraan.edit',
                    'show' => 'penghargaan-kejuaraan.show',
                    'jenis' => config('kegiatan.PENGHARGAAN')
                ];
                break;
            case 'seminar':
                $view = [
                    'view' => 'seminar-pelatihan.index',
                    'edit' => 'seminar-pelatihan.edit',
                    'show' => 'seminar-pelatihan.show',
                    'jenis' => config('kegiatan.SEMINAR')
                ];
                break;
            case 'hibah':
                $view = [
                    'view' => 'penerima-hibah.index',
                    'edit' => 'penerima-hibah.edit',
                    'show' => 'penerima-hibah.show',
                    'jenis' => config('kegiatan.HIBAH')
                ];
                break;
            case 'pengabdian':
                $view = [
                    'view' => 'pengabdian-masyarakat.index',
                    'edit' => 'pengabdian-masyarakat.edit',
                    'show' => 'pengabdian-masyarakat.show',
                    'jenis' => config('kegiatan.PENGABDIAN')
                ];
                break;
            case 'organisasi':
                $view = [
                    'view' => 'organisasi.index',
                    'edit' => 'organisasi.edit',
                    'show' => 'organisasi.show',
                    'jenis' => config('kegiatan.ORGANISASI')
                ];
                break;
            case 'magang':
                $view = [
                    'view' => 'magang.index',
                    'edit' => 'magang.edit',
                    'show' => 'magang.show',
                    'jenis' => config('kegiatan.MAGANG')
                ];
                break;
            case 'beasiswa':
                $view = [
                    'view' => 'beasiswa.index',
                    'edit' => 'beasiswa.edit',
                    'show' => 'beasiswa.show',
                    'jenis' => config('kegiatan.BEASISWA')
                ];
                break;
            case 'bahasa-asing':
                $view = [
                    'view' => 'kemampuan-bahasa-asing.index',
                    'edit' => 'kemampuan-bahasa-asing.edit',
                    'show' => 'kemampuan-bahasa-asing.show',
                    'jenis' => config('kegiatan.BAHASAASING')
                ];
                break;
            case 'kewirausahaan':
                $view = [
                    'view' => 'kewirausahaan.index',
                    'edit' => 'kewirausahaan.edit',
                    'show' => 'kewirausahaan.show',
                    'jenis' => config('kegiatan.KEWIRAUSAHAAN')
                ];
                break;
            case 'hki':
                $view = [
                    'view' => 'hki.index',
                    'edit' => 'hki.edit',
                    'show' => 'hki.show',
                    'jenis' => config('kegiatan.HKI')
                ];
                break;
            case 'publikasi':
                $view = [
                    'view' => 'publikasi.index',
                    'edit' => 'publikasi.edit',
                    'show' => 'publikasi.show',
                    'jenis' => config('kegiatan.publikasi')
                ];
                break;
            default:
                break;
        }
        return $view;
    }
    public function relasiRequest($jenis)
    {
        $data = '';
        switch ($jenis) {
            case config('kegiatan.PENGHARGAAN'):
                $data = new PenghargaanKejuaraan();
                break;
            case config('kegiatan.SEMINAR'):
                $data = new SeminarPelatihan();
                break;
            case config('kegiatan.HIBAH'):
                $data = new PenerimaHibah();
                break;
            case config('kegiatan.PENGABDIAN'):
                $data = new PengabdianMasyarakat();
                break;
            case config('kegiatan.ORGANISASI'):
                $data = new Organisasi();
                break;
            case config('kegiatan.MAGANG'):
                $data = new Magang();
                break;
            case config('kegiatan.BEASISWA'):
                $data = new BeasiswaRequest();
                break;
            case config('kegiatan.BAHASAASING'):
                $data = new KemampuanBahasaAsing();
                break;
            case config('kegiatan.KEWIRAUSAHAAN'):
                $data = new Kewirausahaan();
                break;
            case config('kegiatan.HKI'):
                $data = new Hki();
                break;
            case config('kegiatan.PUBLIKASI'):
                $data = new Publikasi();
                break;
            default:
                break;
        }
        return $data;
    }
}
