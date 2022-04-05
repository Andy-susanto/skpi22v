<?php

namespace App\Http\Controllers;

use App\Models\Files;
use App\Models\Beasiswa;
use Illuminate\Http\Request;
use App\Models\KegiatanMahasiswa;
use App\Models\PenghargaanKejuaraan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BeasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['utama'] = Beasiswa::where('siakad_mhspt_id', Auth::user()->id)->get();
        return view('beasiswa.index', compact('data'));
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
            'nama'                    => 'required|string',
            'nama_promotor'           => 'required',
            'ref_kategori_id'         => 'required',
            'ref_cakupan_beasiswa_id' => 'required',
            'bukti_kegiatan'          => 'required|mimes:jpg,png,pdf,docx'
        ]);

        if ($request->file('bukti_kegiatan')) {
            $filename      = time() . '_' . 'bukti_beasiswa' . '_' . Auth::user()->username . '.' . $request->bukti_kegiatan->getClientOriginalExtension();
            $original_name = $request->bukti_kegiatan->getClientOriginalName();
            $filePath      = $request->file('bukti_kegiatan')->storeAs('uploads', $filename, 'public');

            $files = Files::create([
                'nama'                  => $filename,
                'path'                  => $filePath,
                'siakad_mhspt_id'       => Auth::user()->id,
                'ref_jenis_kegiatan_id' => 1
            ]);
        }

        $beasiswa = Beasiswa::create([
            'nama'                                => $request->nama,
            'siakad_mhspt_id'                     => Auth::user()->id,
            'nama_promotor'                       => $request->nama_promotor,
            'ref_kategori_id'                     => $request->ref_kategori_id,
            'ref_cakupan_beasiswa_id'             => $request->ref_cakupan_beasiswa_id,
            'file_kegiatan_id'                    => $files->id_files,
            'file_kegiatan_ref_jenis_kegiatan_id' => $files->ref_jenis_kegiatan_id,
        ]);

        if ($beasiswa) {
            toastr()->success('Berhasil Tambah Data');
        } else {
            toastr()->error('Terjadi Kesalahan, Silahkan Ulangi lagi');
        }

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
        $data = Beasiswa::findOrFail(decrypt($id));
        return view('beasiswa.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['utama'] = Beasiswa::findOrFail(decrypt($id));
        return view('beasiswa.edit', compact('data'));
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
            'nama'                    => 'required|string',
            'nama_promotor'           => 'required',
            'ref_kategori_id'         => 'required',
            'ref_cakupan_beasiswa_id' => 'required',
            'bukti_kegiatan'          => 'mimes:jpg,png,pdf,docx'
        ]);

        $data_utama = Beasiswa::findOrFail(decrypt($id));

        if ($request->file('bukti_kegiatan')) {
            $extension = ['jpg,pdf,docx'];
            $file = $request->bukti_kegiatan->getClientOriginalExtension();
            if (in_array($file, $extension)) {
                $filename      = time() . '_' . 'bukti_seminar_pelatihan' . '_' . Auth::user()->username . '.' . $request->bukti_kegiatan->getClientOriginalExtension();


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

                Beasiswa::where('id_beasiswa', decrypt($id))->update([
                    'nama'                                => $request->nama ?? $data_utama->nama_kegiatan,
                    'nama_promotor'                       => $request->nama_promotor ?? $data_utama->nama_promotor,
                    'ref_kategori_id'                      => $request->ref_kategori_id ?? $data_utama->ref_kategori_id,
                    'ref_cakupan_beasiswa_id'               => $request->ref_cakupan_beasiswa_id ?? $data_utama->ref_cakupan_beasiswa_id,
                    'file_kegiatan_id'                    => $files->id_files,
                    'file_kegiatan_ref_jenis_kegiatan_id' => $files->ref_jenis_kegiatan_id,
                ]);

                toastr()->success('Berhasil Update Data');
                return back();
            } else {
                toastr()->error(' Terjadi Kesalahan :( ');
            }
        } else {
            Beasiswa::where('id_beasiswa', decrypt($id))->update([
                'nama'                                => $request->nama ?? $data_utama->nama_kegiatan,
                'nama_promotor'                       => $request->nama_promotor ?? $data_utama->nama_promotor,
                'ref_kategori_id'                      => $request->ref_kategori_id ?? $data_utama->ref_kategori_id,
                'ref_cakupan_beasiswa_id'               => $request->ref_cakupan_beasiswa_id ?? $data_utama->ref_cakupan_beasiswa_id,
            ]);

            toastr()->success('Berhasil Update Data');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Beasiswa::findOrFail(decrypt($id));
        $file = Files::findOrFail($data->file_kegiatan_id);
        if (Storage::exists($file->path)) {
            Storage::delete($file->path);
        }
        $data->files()->delete();
        toastr()->success('Berhasil Hapus Data');
        return back();
    }
}
