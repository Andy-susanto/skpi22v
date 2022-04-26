<?php

namespace App\Http\Controllers;

use App\Models\Files;
use Illuminate\Http\Request;
use App\Models\Kewirausahaan;
use App\Models\KegiatanMahasiswa;
use App\Models\PenghargaanKejuaraan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KewirausahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['utama'] = Kewirausahaan::where('siakad_mhspt_id', Auth::user()->siakad_mhspt->id_mhs_pt)->get();
        return view('kewirausahaan.index', compact('data'));
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
            'nama_usaha'      => 'required',
            'alamat_usaha'    => 'required',
            'no_izin'         => 'required',
            'ref_kategori_id' => 'required',
            'bukti_kegiatan'  => 'required|mimes:jpg,png,pdf,docx'
        ]);

        if ($request->file('bukti_kegiatan')) {
            $filename      = time() . '_' . 'bukti_kewirausahaan' . '_' . Auth::user()->username . '.' . $request->bukti_kegiatan->getClientOriginalExtension();
            $original_name = $request->bukti_kegiatan->getClientOriginalName();
            $filePath      = $request->file('bukti_kegiatan')->storeAs('uploads', $filename, 'public');

            $files = Files::create([
                'nama'                  => $filename,
                'path'                  => $filePath,
                'siakad_mhspt_id'       => Auth::user()->siakad_mhspt->id_mhs_pt,
                'ref_jenis_kegiatan_id' => 9
            ]);
        }

        $kewirausahaan = Kewirausahaan::create([
            'siakad_mhspt_id'                     => Auth::user()->siakad_mhspt->id_mhs_pt,
            'nama_usaha'                          => $request->nama_usaha,
            'alamat_usaha'                        => $request->alamat_usaha,
            'no_izin'                             => $request->no_izin,
            'ref_kategori_id'                     => $request->ref_kategori_id,
            'file_kegiatan_id'                    => $files->id_files,
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
        $data = PenghargaanKejuaraan::findOrFail(decrypt($id));
        return view('penghargaan-kejuaraan.show',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['utama'] = Kewirausahaan::findOrFail(decrypt($id));
        return view('kewirausahaan.edit', compact('data'));
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
            'nama_usaha'              => 'required|string',
            'alamat_usaha'            => 'required',
            'no_izin'                 => 'required',
            'bukti_kegiatan'          => 'mimes:jpg,png,pdf,docx'
        ]);

        $data_utama = Kewirausahaan::findOrFail(decrypt($id));

        if ($request->file('bukti_kegiatan')) {
            $extension = ['jpg','pdf','docx'];
            $file = $request->bukti_kegiatan->getClientOriginalExtension();
            if (in_array($file, $extension)) {
                $filename      = time() . '_' . 'bukti_kewirausahaan' . '_' . Auth::user()->username . '.' . $request->bukti_kegiatan->getClientOriginalExtension();

                $filePath   = $request->file('bukti_kegiatan')->storeAs('uploads', $filename, 'public');

                $files = Files::where('id_file', $data_utama->files->id_files)->updateOrCreate(
                    [
                        'id_file' => $data_utama->files->id_files
                    ],
                    [
                        'nama'                  => $filename,
                        'path'                  => $filePath,
                    ]
                );

                Kewirausahaan::where('id_beasiswa', decrypt($id))->update([
                    'file_kegiatan_id'                    => $files->id_files,
                    'file_kegiatan_ref_jenis_kegiatan_id' => $files->ref_jenis_kegiatan_id,
                ]);

                toastr()->success('Berhasil Update Data');
                return back();
            } else {
                toastr()->error(' Terjadi Kesalahan :( ');
            }
        }

        Kewirausahaan::where('id_beasiswa', decrypt($id))->update([
            'nama_usaha'                          => $request->nama_usaha ?? $data_utama->nama_usaha,
                'alamat_usaha'                        => $request->alamat_usaha ?? $data_utama->alamat_usaha,
                'no_izin'                             => $request->no_izin ?? $data_utama->no_izin,
        ]);

        toastr()->success('Berhasil Update Data');
        return redirect()->route('beasiswa.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Kewirausahaan::findOrFail(decrypt($id));
        $file = Files::findOrFail($data->file_kegiatan_id);
        if(!empty($file)){
            if(Storage::exits($file->path)){
                Storage::delete($file->path);
                $data->files->delete();
            }
        }

        $data->delete();
        toastr()->success('Berhasil Hapus Data');
        return back();
    }
}
