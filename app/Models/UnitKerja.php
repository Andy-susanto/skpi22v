<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitKerja extends Model
{
    use HasFactory;
    protected $table      = 'kepeg.unit_kerja';
    protected $primaryKey = 'id_unit_kerja';
    protected $guarded    = [];

    public function ref_unit()
    {
        return $this->belongsTo(ReferensiUnitKerja::class, 'referensi_unit_kerja_id', 'id_ref_unit_kerja');
    }
    public function parent_unit()
    {
        return $this->belongsTo(UnitKerja::class, 'parent_unit_id', 'id_unit_kerja');
    }
    public function parent_unit_utama()
    {
        return $this->belongsTo(UnitKerja::class, 'parent_unit_utama_id', 'id_unit_kerja');
    }

    public function scopeFilterUnit($query)
    {
        $unit = [];
        $unit_child = [];
        if (auth()->user()->level_akun == 1){
            $unit[] = auth()->user()->kepeg_pegawai->unit_kerja->id_unit_kerja_siakad;
            foreach (auth()->user()->instansi as $v) {
                $unit[] = (int) $v->id_unit_kerja_siakad;
                $cekParent = UnitKerja::where('id_unit_kerja',$v->id_unit_kerja_siakad)->first();
                if($cekParent->parent_unit_id === 0){
                    $child = UnitKerja::where('parent_unit_id',$v->id_unit_kerja_siakad)->get();
                    foreach($child as $v2){
                        $unit_child[] = (int) $v2->id_unit_kerja_siakad;
                    }
                }
            }
            $merge = array_merge($unit,$unit_child);
            return $query->whereIn('id_prodi',$merge);
        }
    }
}
