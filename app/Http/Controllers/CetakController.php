<?php

namespace App\Http\Controllers;

use Exception;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
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
        $data = [

            'title' => 'Welcome to ItSolutionStuff.com',

            'date' => date('m/d/Y')

        ];
        $pdf = PDF::loadView('cetak.cetak', $data);
        return $pdf->download('itsolutionstuff.pdf');
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
