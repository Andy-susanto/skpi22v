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
        $collect     = collect();
        $penghargaan = PenghargaanKejuaraan::where('status_validasi',4)->get();
        $seminar     = SeminarPelatihan::where('status_validasi',4)->get();
        $pengabdian  = PengabdianMasyarakat::where('status_validasi',4)->get();
        $organisasi  = Organisasi::where('status_validasi',4)->get();

        $mapPenghargaan = $penghargaan->map(function ($item) {
            return [
                'mhspt_id' => $item->siakad_mhspt_id,
                'bobot'    => $item->bobot_nilai->bobot,
            ];
        });
        $collect = $collect->merge($mapPenghargaan);

        $mapSeminar = $seminar->map(function ($item) {
            return [
                'mhspt_id' => $item->siakad_mhspt_id,
                'bobot'    => $item->bobot_nilai->bobot,
            ];
        });
        $collect = $collect->merge($mapSeminar);
        $mapPengabdian = $pengabdian->map(function ($item) {
            return [
                'mhspt_id' => $item->siakad_mhspt_id,
                'bobot'    => $item->bobot_nilai->bobot,
            ];
        });
        $collect = $collect->merge($mapPengabdian);
        $mapOrganisasi = $organisasi->map(function ($item) {
            return [
                'mhspt_id' => $item->siakad_mhspt_id,
                'bobot'    => $item->bobot_nilai->bobot,
            ];
        });
        $collect = $collect->merge($mapOrganisasi);
        $collect->each(function ($item,$key) {
            DB::table('rekap_bobot_mahasiswa')->insert([
                'siakad_mhspt_id'=>$item['mhspt_id'],
                'bobot'=> $item['bobot']
            ]);
        });

        $total = DB::table('rekap_bobot_mahasiswa')->select("*",DB::raw("SUM(bobot) as total_bobot"))->groupBy('siakad_mhspt_id')->get();

        foreach($total as $dataTotal){
            DB::table('rekap_bobot_mahasiswa')->updateOrInsert(
                ['siakad_mhspt_id' => $dataTotal->siakad_mhspt_id],
                [
                'bobot'=> $dataTotal->total_bobot,
                'aktif' => 1
            ]);
        }

        DB::table('rekap_bobot_mahasiswa')->where('aktif',2)->delete();

        echo 'Rekap Bobot Berhasil';

    }
}
