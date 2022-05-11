<?php

namespace App\Console\Commands;

use App\Models\Organisasi;
use Illuminate\Console\Command;
use App\Models\SeminarPelatihan;
use Illuminate\Support\Facades\DB;
use App\Models\PengabdianMasyarakat;
use App\Models\PenghargaanKejuaraan;

class rekap_bobot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bobot:rekap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Merekap Bobot total yang di dapatkan mahasiswa';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $data        = 0;
        //$penghargaan = PenghargaanKejuaraan::join('bobot_nilai', 'bobot_nilai.id_bobot_nilai', '=', 'penghargaan_kejuaraan.bobot_nilai_id')->with('bobot_nilai')->where('status_validasi',4)->select('bobot_nilai.bobot')->get();
        $penghargaan     = PenghargaanKejuaraan::where('status_validasi',4)->get();
        $seminar     = SeminarPelatihan::where('status_validasi',4)->get();
        $pengabdian  = PengabdianMasyarakat::where('status_validasi',4)->get();
        $organisasi  = Organisasi::where('status_validasi',4)->get();

        $mapPenghargaan = $penghargaan->map(function ($item) {
            return [
                'mhspt_id' => $item->siakad_mhspt_id,
                'bobot'    => $item->bobot_nilai->bobot,
            ];
        });

        $mapSeminar = $seminar->map(function ($item) {
            return [
                'mhspt_id' => $item->siakad_mhspt_id,
                'bobot'    => $item->bobot_nilai->bobot,
            ];
        });

        $mapPengabdian = $pengabdian->map(function ($item) {
            return [
                'mhspt_id' => $item->siakad_mhspt_id,
                'bobot'    => $item->bobot_nilai->bobot,
            ];
        });

        $mapOrganisasi = $organisasi->map(function ($item) {
            return [
                'mhspt_id' => $item->siakad_mhspt_id,
                'bobot'    => $item->bobot_nilai->bobot,
            ];
        });

        $collection = $mapPenghargaan->merge($mapSeminar)->merge($mapPengabdian)->merge($mapOrganisasi);

        $data = [];
        $dataFinal = [];

        foreach($collection as $item) {
            $temp = [];
            if(!array_key_exists($item['mhspt_id'], $data)) {
                $temp[$item['mhspt_id']] = $item['bobot'];

            }else{
                $temp[$item['mhspt_id']] += $item['bobot'];
            }

            array_push($data, $temp);
        }

        foreach($data as $key => $i) {
            array_push($dataFinal, ['id_mhspt' => key($i), 'bobot' => $i[key($i)]]);
        }

        foreach($dataFinal as $dataTotal){
            DB::table('rekap_bobot_mahasiswa')->updateOrInsert(
                ['siakad_mhspt_id' => $dataTotal['id_mhspt']],
                [
                'bobot'=> $dataTotal['bobot'],
            ]);
        }

        echo 'Rekap Bobot Berhasil';

    }
}
