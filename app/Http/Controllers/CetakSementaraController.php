<?php

namespace App\Http\Controllers;

use App\Models\PengaturanUmum;
use App\Models\RekapBobot;
use Illuminate\Http\Request;
use Elibyy\TCPDF\Facades\TCPDF;
use Yajra\DataTables\DataTables;

class CetakSementaraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $min_bobot = PengaturanUmum::where('id',1)->first();
        if($request->ajax()){
            $data = RekapBobot::with('mhspt')->whereHas('mhspt',function($q){
                $q->FilterUnit();
            })->where('bobot','>=',$min_bobot->value);

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn("nama_mahasiswa",function($row){
                        return $row->mhspt->mahasiswa->nama_mahasiswa;
                    })
                    ->addColumn("nim",function($row){
                        return $row->mhspt->no_mhs;
                    })
                    ->addColumn('nama_prodi',function($row){
                        return $row->mhspt->prodi->nama_prodi;
                    })
                    ->addColumn('total_bobot',function($row){
                        return $row->bobot;
                    })
                    ->addColumn('action',function($row){
                        return view('cetak.cetak-aksi',compact('row'));
                    })
                    ->rawColumns(['action'])
                    ->toJson();
        }
        return view('cetak.sementara');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $filename = 'Surat Keterangan';
        $html = view('cetak.draft-cetak')->render();

        $pdf = new TCPDF;
        $pdf::SetTitle('Surat Keterangan');
        $pdf::AddPage();
        $pdf::writeHtml($html,true,false,true,false,'');
        $pdf::Output(public_path($filename),'F');
        return response()->download(public_path($filename));

        // return view('cetak.draft-cetak');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
