<?php

namespace App\Console\Commands;

use App\Models\Beasiswa;
use App\Models\Hki;
use App\Models\Kegiatan;
use App\Models\KemampuanBahasaAsing;
use App\Models\Kewirausahaan;
use App\Models\Magang;
use App\Models\Organisasi;
use App\Models\PenerimaHibah;
use App\Models\PengabdianMasyarakat;
use App\Models\PenghargaanKejuaraan;
use App\Models\Publikasi;
use App\Models\SeminarPelatihan;
use Illuminate\Cache\Events\KeyWritten;
use Illuminate\Console\Command;

class KegiatanMigrate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kegiatan:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $kegiatan = $this->ask('Pilih Kegiatan ! [ 1. Beasiswa , 2. HKI , 3. Publikasi, 4. Kemampuan Bahasa Asing, 5. Kewirausahaan, 6. Organisasi, 7. Penerima Hibah, 8. Pengabdian Masyarakat, 9. Penghargaan / Kejuaraan, 10. Magang, 11. Seminar Pelatihan, 0 . Semua]');
        $this->info('Sedang mengambil data...');
        switch ($kegiatan) {
            case 1:
                $this->get_data(new Beasiswa(), 7);
                break;
            case 2:
                $this->get_data(new Hki(), 10);
                break;
            case 3:
                $this->get_data(new Publikasi(), 11);
                break;
            case 4:
                $this->get_data(new KemampuanBahasaAsing(), 8);
                break;
            case 5:
                $this->get_data(new Kewirausahaan(), 9);
                break;
            case 6:
                $this->get_data(new Organisasi(), 5);
                break;
            case 7:
                $this->get_data(new PenerimaHibah(), 3);
                break;
            case 8:
                $this->get_data(new PengabdianMasyarakat(), 4);
                break;
            case 9:
                $this->get_data(new PenghargaanKejuaraan(), 1);
                break;
            case 10:
                $this->get_data(new Magang(), 6);
                break;
            case 11:
                $this->get_data(new SeminarPelatihan(), 2);
                break;
            default:
                $this->get_data(new PenghargaanKejuaraan(), 1);
                $this->get_data(new SeminarPelatihan(), 2);
                $this->get_data(new PenerimaHibah(), 3);
                $this->get_data(new PengabdianMasyarakat(), 4);
                $this->get_data(new Organisasi(), 5);
                $this->get_data(new Magang(), 6);
                $this->get_data(new Beasiswa(), 7);
                $this->get_data(new KemampuanBahasaAsing(), 8);
                $this->get_data(new Kewirausahaan(), 9);
                $this->get_data(new Hki(), 10);
                $this->get_data(new Publikasi(), 11);
                break;
        }
    }

    protected function get_data(object $model, $jenis)
    {
        $datas = $model->get();
            foreach ($datas as $data) {
                $this->line('Insert data ');
                if ($this->cek_data($data, $jenis)) {
                    $this->error('Data Exists ! SKIP !! ');
                    $this->newLine();
                    continue;
                }else {
                    Kegiatan::create([
                        'kegiatan_id'           => $data->{$data->getKeyName()},
                        'ref_jenis_kegiatan_id' => $jenis,
                        'siakad_mhspt_id'       => $data->siakad_mhspt_id,
                        'file_id'               => $data->file_kegiatan_id ?? $data->file_bukti_id,
                        'validasi'              => $data->status_validasi,
                        'pesan'                 => $data->pesan,
                    ]);
                    $this->info('Sukses Insert data ');
                }

            }
    }

    protected function cek_data($data, $jenis)
    {
        $data = Kegiatan::where('kegiatan_id', $data->{$data->getKeyName()})->where('ref_jenis_kegiatan_id', $jenis)->count();
        if ($data > 0) {
            return true;
        }
        return false;
    }
}
