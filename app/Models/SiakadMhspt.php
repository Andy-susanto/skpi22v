<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiakadMhspt extends Model
{
    use HasFactory;
    protected $table      = 'siakad.mhs_pt';
    protected $guarded    = [];
    protected $primaryKey = 'id_mhs_pt';

    public function mahasiswa(){
        return $this->belongsTo(SiakadMahasiswa::class,'id_mahasiswa','id_mahasiswa');
    }

    public function prodi(){
        return $this->belongsTo(SiakadProdi::class,'id_prodi','id_prodi');
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
