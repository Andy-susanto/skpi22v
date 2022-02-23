<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\BobotNilai;
use Illuminate\Http\Request;

class MasterBobotNilaiController extends Controller
{
    public function index(Request $request){
        if($request->ajax()){
            $data = BobotNilai::when($request->penyelenggara,function($q)use($request){
                                $q->where('ref_penyelenggara_id',$request->penyelenggara);
                            })
                            ->when($request->jenis_kegiatan,function($q)use($request){
                                $q->where('ref_jenis_kegiatan_id',$request->jenis_kegiatan);
                            })
                            ->latest()->get();

            return datatables()->of($data)
                    ->addIndexColumn()
                    ->addColumn('penyelenggara',function($row){
                        return $row->penyelenggara->nama;
                    })
                    ->addColumn('kategori',function($row){
                        return $row->kategori->nama_kategori ?? '-';
                    })
                    ->addColumn('tingkat',function($row){
                        return $row->tingkat->nama;
                    })
                    ->addColumn('prestasi',function($row){
                        return $row->prestasi->nama;
                    })
                    ->addColumn('bobot',function($row){
                        return $row->bobot;
                    })
                    ->addColumn('jenis_kegiatan',function($row){
                        return $row->jenis_kegiatan->nama;
                    })
                    ->addColumn('aksi',function($row){
                        return view('master.bobot-nilai.aksi',compact('row'));
                    })
                    ->toJson();
        }
        return view('master.bobot-nilai.index');
    }

    public function store(Request $request){
        $request->validate([
            'ref_jenis_kegiatan_id' => 'required',
            'ref_penyelenggara_id'  => 'required',
            'ref_tingkat_id'        => 'required',
            'ref_peran_prestasi_id' => 'required',
            'ref_kategori_id'       => 'required'
        ]);

        $store = BobotNilai::create($request->all());

        if ($store) {
            toastr()->success('Berhasil Tambah Data');
            return back();
        }else{
            toastr()->error('Tejadi Kesalahan, Silahkan Coba Lagi');
            return back();
        }
    }

    public function edit($id){
        $data['bobot'] = BobotNilai::find(decrypt($id));
        $view = view('master.bobot-nilai.edit',compact('data'))->render();
        return $view;
    }

    public function update(Request $request,$id){
        $request->validate([
            'ref_jenis_kegiatan_id' => 'required',
            'ref_penyelenggara_id'  => 'required',
            'ref_tingkat_id'        => 'required',
            'ref_peran_prestasi_id' => 'required',
            'ref_kategori_id'       => 'required'
        ]);

        $update = BobotNilai::where('id_bobot_nilai',decrypt($id))->update($request->except(['_token','_method']));
        if ($update) {
            toastr()->success('Berhasil Update Data');
            return back();
        }else{
            toastr()->error('Tejadi Kesalahan, Silahkan Coba Lagi');
        }
    }

    public function destroy($id){
        $destroy = BobotNilai::where('id_bobot_nilai',decrypt($id))->delete();
        if ($destroy) {
            toastr()->success('Berhasil Hapus Data');
            return back();
        }else{
            toastr()->error('Tejadi Kesalahan, Silahkan Coba Lagi');
            return back();
        }
    }
}
