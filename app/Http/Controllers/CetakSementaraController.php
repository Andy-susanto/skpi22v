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
        $pdf = new TCPDF;
        $pdf::SetTItle('Surat Keterangan');
        $pdf::SetFont('times');
        $pdf::SetFontSize(12);
        $pdf::setMargins(20,5,20,5);
		$pdf::AddPage('P', 'A4');
		$pdf::SetAutoPageBreak(TRUE, 0);

        $logo = 'https://skpi.unja.ac.id/cetak/logo.png';
        $pdf::Image($logo, 15, 7, 23, 23, '', '', '', false, 300, '', false, false, 0);
        $tb=0;
        $surat = '';
        $surat.= "<html><head></head><body><style>body {font-family: Times New Roman, Helvetica;} </style>";
        $surat.='<div style="text-align:center; padding:0px; margin:0px;">';
        $surat.='<p style="line-height: 0px; font-size: 12px; color:blue; ">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET DAN TEKNOLOGI</p>';
        $surat.='<p style="line-height: 0px; font-size: 12px; color: orange; ">UNIVERSITAS JAMBI</p>';
        $surat.='<p style="line-height: 0px; color: orange; font-size: 14px">FAKULTAS SAINS DAN TEKNOLOGI</p>';
        $tb+=3.5;
        $surat.='<p style="line-height: 0px; font-size: 10px; color:  blue; ">Jalan Raya Jambi - Ma. Bulian KM. 15 Mendalo Indah, Kode Pos 36361</p>';
        $surat.='<p style="line-height: 0px; font-size: 10px; color: blue; ">Laman : http://fst.unja.ac.id.</p>';
        $tb+=5;
        $surat.="</div>";
        $pdf::writeHTML($surat, true, false, true, false, '');
        $ln1=31+$tb;
        $ln2=31.5+$tb;
        $ln3=31.6+$tb;
        $ln4=31.7+$tb;
        $ln5=31.8+$tb;
        $pdf::Line(20, $ln1, 190, $ln1);
		$pdf::Line(20, $ln2, 190, $ln2);
		$pdf::Line(20, $ln3, 190, $ln3);
		$pdf::Line(20, $ln4, 190, $ln4);
        $pdf::Line(20, $ln5, 190, $ln5);
        $pdf::ln(5);
        $nomor = '<p style="line-height: 0px;font-weight:bold;text-align:center;font-size:10px;margin-top:100px">SURAT KETERANGAN</p>';
        $nomor .= '<p style="line-height: 0px;text-align:center;font-size:8px;margin-top:-10px">Nomor : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>/UN21.9/PK.05.05/2022</span></p>';
        $pdf::writeHtml($nomor  ,true,false,true,false,'');
        $pdf::Output('surat_tugas.pdf');
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
