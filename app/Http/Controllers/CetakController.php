<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Elibyy\TCPDF\Facades\TCPDF;
use App\Models\SeminarPelatihan;
use Illuminate\Support\Facades\View;

class CetakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $seminar = SeminarPelatihan::where('siakad_mhspt_id',auth()->user()->siakad_mhspt->id_mhs_pt)->where('status_validasi',1)->get();
        return view('cetak.index',compact('seminar'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $view = View::make('cetak.cetak');
        $html = $view->render();
        $pdf = new TCPDF;
        $filename = 'skpi.pdf';

        $pdf::setHeaderCallback(function($pdf) {

            $image_file = public_path('cetak/header1.jpg');
            $pdf->Image($image_file, 50, 50, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            // Set font
            $pdf->SetFont('helvetica', 'B', 20);
            // Title
            // $pdf->Cell(0, 15, 'Universitas Jambi', 0, false, 'C', 0, '', 0, false, 'M', 'M');

    });

        $pdf::SetTitle('Cetak PDF');
        $pdf::AddPage();
        $pdf::writeHTML($html, true, false, true, false, '');

        $pdf::Output(public_path($filename), 'F');

        return response()->download(public_path($filename));
        // return view('cetak.cetak');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->jenis == 'seminar') {
            SeminarPelatihan::where('id_seminar_pelatihan_workshop_diklat',$request->id)->update(['nama_eng'=>$request->translate]);
        }

        return response()->json(['success'=>'Data Berhasil di update']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
