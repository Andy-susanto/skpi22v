<?php

namespace App\Http\Controllers;

use App\Models\UnitKerja;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected $data = [];
    protected $perpage = 10;
    protected $mhspt;
    public function __construct()
    {
    }

    protected function UnitKerja($user)
    {
        $unit = ['nol'];
        if ($user->level_user == 1)
            $unit[] = $user->kepeg_pegawai->unit_kerja->id_unit_kerja_siakad;
        foreach ($user->instansi as $v) {
            $unit[] = (int) $v->id_unit_kerja_siakad;
            $cekParent = UnitKerja::where('id_unit_kerja_siakad', $v->id_unit_kerja_siakad)->first();
            if ($cekParent->parent_unit_id == 0) {
                $child = UnitKerja::where('parent_unit_id', $v->id_unit_kerja)->get();
                foreach ($child as $v2) {
                    $unit[] = (int) $v->id_unit_kerja_siakad;
                    $subChild = UnitKerja::where('parent_unit_id', $v2->id_unit_kerja)->get();
                    foreach ($subChild as $v3) {
                        $unit[] = (int) $v3->id_unit_kerja_siakad;
                    }
                }
            }
        }

        return $unit;
    }
}
