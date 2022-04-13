<?php

namespace App\Http\Controllers;

use App\Models\Files;
use Illuminate\Http\Request;
use App\Models\KemampuanBahasaAsing;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KemampuanBahasaAsingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['utama'] = KemampuanBahasaAsing::where('siakad_mhspt_id', Auth::user()->id)->get();
        return view('kemampuan-bahasa-asing.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nilai_tes'                => 'required',
            'ref_bahasa_id'            => 'required|integer',
            'ref_level_bahasa_id'      => 'required|integer',
            'ref_jenis_tes_id'         => 'required|integer',
            'bukti_kegiatan'           => 'required|mimes:jpg,png,pdf,docx'
        ]);

        if ($request->file('bukti_kegiatan')) {
            $filename      = time() . '_' . 'bukti_kemampuan_bahasa_asing' . '_' . Auth::user()->username . '.' . $request->bukti_kegiatan->getClientOriginalExtension();
            $filePath      = $request->file('bukti_kegiatan')->storeAs('uploads', $filename, 'public');

            $files = Files::create([
                'nama'                  => $filename,
                'path'                  => $filePath,
                'siakad_mhspt_id'       => Auth::user()->id,
                'ref_jenis_kegiatan_id' => 8
            ]);
        }

        KemampuanBahasaAsing::create([
            'nilai_tes'                           => $request->nilai_tes,
            'ref_bahasa_id'                       => $request->ref_bahasa_id,
            'ref_level_bahasa_id'                 => $request->ref_level_bahasa_id,
            'ref_jenis_tes_id'                    => $request->ref_jenis_tes_id,
            'file_kegiatan_id'                    => $files->id_files,
            'siakad_mhspt_id'                     => Auth::user()->id,
            'file_kegiatan_ref_jenis_kegiatan_id' => $files->ref_jenis_kegiatan_id,
        ]);

        toastr()->success('Berhasil Tambah Data');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = KemampuanBahasaAsing::findOrFail(decrypt($id));
        return view('kemampuan-bahasa-asing.show',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['utama'] = KemampuanBahasaAsing::findOrFail(decrypt($id));
        return view('kemampuan-bahasa-asing.edit', compact('data'));
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
        $request->validate([
            'ref_bahasa_id'       => 'required|integer',
            'ref_level_bahasa_id' => 'required|integer',
            'ref_jenis_tes_id'    => 'required|integer',
            'nilai_tes'           => 'required|integer',
            'file_kegiatan_id'    => 'mime:jpg,png,pdf,docx',
        ]);

        $data_utama = KemampuanBahasaAsing::findOrFail(decrypt($id));
        if ($request->hasFile('file_kegiatan_id')) {
            $extension = ['jpg','pdf','docx'];
            $file = $request->file_kegiatan_id->getClientOriginalExtension();
            if (in_array($file, $extension)) {
                $filename      = time() . '_' . 'bukti_kemampuan_bahasa_asing' . '_' . Auth::user()->username . '.' . $request->file_kegiatan_id->getClientOriginalExtension();

                $filePath   = $request->file('file_kegiatan_id')->storeAs('uploads', $filename, 'public');

                $files = Files::where('id_files', $data_utama->files->id_files)->updateOrCreate(
                    [
                        'id_files' => $data_utama->files->id_files
                    ],
                    [
                    'nama'                  => $filename,
                    'path'                  => $filePath,
                    ]
                 );

                KemampuanBahasaAsing::where('id_kemampuan_bahasa_asing',decrypt($id))->update([
                    'file_kegiatan_id'                    => $files->id_files,
                ]);

            } else {
                toastr()->error(' Terjadi Kesalahan :( ');
            }
        }

        KemampuanBahasaAsing::where('id_kemampuan_bahasa_asing',decrypt($id))->update([
            'nilai_tes'           => $request->nilai_tes ?? $data_utama->nilai_tes,
            'ref_bahasa_id'       => $request->ref_bahasa_id ?? $data_utama->ref_bahasa_id,
            'ref_level_bahasa_id' => $request->ref_level_bahasa_id ?? $data_utama->ref_level_bahasa_id,
            'ref_jenis_tes_id'    => $request->ref_jenis_tes_id ?? $data_utama->ref_jenis_tes_id,
        ]);

        toastr()->success('Berhasil Update Data');
        return redirect()->route('kemampuan-bahasa-asing.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = KemampuanBahasaAsing::findOrFail(decrypt($id));
        $file = Files::findOrFail($data->file_kegiatan_id);
        if(!empty($file)){
            if(Storage::exists($file->path)){
                Storage::delete($file->path);
                $data->files->delete();
            }
        }

        $data->delete();
        toastr()->success('Berhasil Hapus Data');
        return back();
    }
}
