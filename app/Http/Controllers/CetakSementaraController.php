<?php

namespace App\Http\Controllers;

use App\Helper\Helpers;
use App\Models\PengaturanUmum;
use App\Models\RekapBobot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Support\Facades\DB;
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

        $mahasiswa = RekapBobot::with('mhspt')->where('siakad_mhspt_id',$id)->first();
        $wadek3 = DB::table('kepeg.unit_kerja_jabatan as a')
                ->join('kepeg.pegawai as b','b.id_pegawai','=','a.id_pegawai')
                ->join('kepeg.jabatan as c','c.id_jabatan','=','a.jabatan_id')
                ->join('kepeg.unit_kerja as d','d.id_unit_kerja','=','a.unit_kerja_id')
                ->join('kepeg.referensi_unit_kerja as e','e.id_ref_unit_kerja','=','d.referensi_unit_kerja_id')
                ->join('kepeg.pangkat_golongan as f','f.id_pangkat_golongan','=','b.pangkat_golongan_id')
                ->where('c.id_jabatan',1118)
                ->where('e.id_unit_kerja_siakad',11)
                ->first();

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
        $surat.='<p style="line-height: 0px; font-size: 12px; color:blue; ">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN,</p>';
        $surat.='<p style="line-height: 0px; font-size: 12px; color:blue; ">RISET DAN TEKNOLOGI</p>';
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
        $nomor = '<p style="line-height: 0px;font-weight:bold;text-align:center;font-size:14px;margin-top:100px">SURAT KETERANGAN</p>';
        $nomor .= '<p style="line-height: 0px;text-align:center;font-size:8px;margin-top:-10px">Nomor : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>/UN21.9/PK.05.05/2022</span></p>';
        $pdf::writeHTML($nomor  ,true,false,true,false,'');
        $pdf::ln(5);
        $main = 'Yang bertanda tangan dibawah ini :';
        $pdf::writeHTML($main  ,true,false,true,false,'');
        $main1 = '<table border="0" cellspadding="0" cellspacing="0">
                    <tr>
                        <td width="30"></td><td width="120">Nama</td><td width="300">: '.Helpers::nama_gelar($wadek3).'<b></b></td>
                    </tr>
                    <tr>
                    <td width="30"></td><td width="120">NIP</td><td width="300">: '.$wadek3->nip.'<b></b></td>
                    </tr>
                    <tr>
                    <td width="30"></td><td width="120">Pangkat / Golongan</td><td width="300">: '.$wadek3->nama_pangkat.'<b></b></td>
                    </tr>
                    <tr>
                    <td width="30"></td><td width="120">Jabatan</td><td width="300">: '.$wadek3->nama_jabatan.'<b></b></td>
                    </tr>
                    <tr>
                    <td width="30"></td><td width="120">Instansi</td><td width="300">: '.$wadek3->nama_ref_unit_kerja.'<b></b></td>
                    </tr></table>';
        $pdf::writeHTML($main1, true, false, true, false, '');
        // $pdf::ln(5);
        $main2 = 'Dengan ini menerangkan bahwa :';
        $pdf::writeHTML($main2,true,false,true,false,'');
        $main3 = '<table border="0" cellspadding="0" cellspacing="0">
                    <tr>
                    <td width="30"></td><td width="120">Nama</td><td width="300">: '.$mahasiswa->mhspt->mahasiswa->nama_mahasiswa.'<b></b></td>
                    </tr>
                    <tr>
                    <td width="30"></td><td width="120">NIM</td><td width="300">: '.$mahasiswa->mhspt->no_mhs.'<b></b></td>
                    </tr>
                    <tr>
                    <td width="30"></td><td width="120">Prodi</td><td width="300">: '.$mahasiswa->mhspt->prodi->nama_prodi.'<b></b></td>
                    </tr></table>';
        $pdf::writeHTML($main3, true, false, true, false, '');
        // $pdf::ln(5);
        $close = 'Telah melengkapi data SKPI untuk keperluan pendaftaran <span style="font-weight:bold;">Sidang Tugas Akhir / Yudisium</span> dengan jumlah <span style="font-weight:bold;">skor kumulatif '.Helpers::hitung_bobot($id).'.</span>';
        $close.="</body></html>";
        $pdf::writeHTML($close,true,false,true,false,'');

        // $pdf::ln(5);
        $pejabat='<table border="0" cellpadding="0" cellspacing="0">';
        $pejabat.='<tr><td width="260"></td><td width="220">Dikeluarkan di JAMBI,</td></tr>';
        $pejabat.='<tr><td width="260"></td><td width="220">pada tanggal '.Carbon::parse(now())->isoFormat('D MMMM Y').'</td></tr>';
        $pejabat.='<tr><td width="260"></td><td width="220">'.$wadek3->nama_jabatan.',</td></tr>';
        $pejabat.='</table>';
        $pdf::writeHTML($pejabat, true, false, true, false, '');
        $pdf::ln(15);
        $nmpejabat='<table border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="260"></td><td width="220"><b><b>'.Helpers::nama_gelar($wadek3).'</b></b></td>
                </tr>
                <tr>
                    <td width="260"></td><td width="220">NIP '.$wadek3->nip.'</td>
                </tr>
                </table>';
        $pdf::writeHTML($nmpejabat, true, false, true, false, '');
        $pdf::IncludeJS("print();");
        $pdf::Output('surat_tugas.pdf','I');
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
