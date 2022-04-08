<?php

namespace App\Http\Controllers;

use App\Models\Files;
use App\Models\Hki;
use App\Models\KaryaMahasiswa;
use App\Models\KegiatanMahasiswa;
use App\Models\PenghargaanKejuaraan;
use App\Models\Publikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KaryaMahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['utama']['hki']       = Hki::where('siakad_mhspt_id', Auth::user()->id)->get();
        $data['utama']['publikasi'] = Publikasi::where('siakad_mhspt_id', Auth::user()->id)->get();
        return view('karya-mahasiswa.index', compact('data'));
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
        if ($request->jenis == 'hki') {
            $request->validate([
                'nama_hki'          => 'required',
                'nomor_sertifikat'  => 'required',
                'tgl_mulai_berlaku' => 'required|date',
                'tgl_berakhir'      => 'required|date',
                'jenis_hki_id'      => 'required',
                'jenis_ciptaan_id'  => 'required',
                'file_bukti'        => 'required'
            ]);
            if ($request->file('file_bukti')) {
                $filename      = time() . '_' . 'bukti_karya_mahasiswa' . '_' . Auth::user()->username . '.' . $request->file_bukti->getClientOriginalExtension();
                $filePath      = $request->file('file_bukti')->storeAs('uploads', $filename, 'public');

                $files = Files::create([
                    'nama'                  => $filename,
                    'path'                  => $filePath,
                    'siakad_mhspt_id'       => Auth::user()->id,
                    'ref_jenis_kegiatan_id' => 10
                ]);
            }

            $karyaMahasiswa = Hki::create([
                'siakad_mhspt_id'   => Auth::user()->id,
                'nama_hki'          => $request->nama_hki,
                'nomor_sertifikat'  => $request->nomor_sertifikat,
                'tgl_mulai_berlaku' => $request->tgl_mulai_berlaku,
                'tgl_berakhir'      => $request->tgl_berakhir,
                'jenis_hki_id'      => $request->jenis_hki_id,
                'jenis_ciptaan_id'  => $request->jenis_ciptaan_id,
                'file_bukti_id'     => $files->id_files
            ]);

            if ($karyaMahasiswa) {
                toastr()->success('Berhasil Tambah Data');
            } else {
                toastr()->error('Terjadi Kesalahan, Silahkan Coba Lagi');
            }
            return back();
        } elseif ($request->jenis == 'publikasi') {
            $request->validate([
                'judul'               => 'required',
                'tgl_terbit'          => 'required|date',
                'penerbit'            => 'required',
                'jenis_id'            => 'required',
                'kategori_capaian_id' => 'required',
                'tautan_eksternal'     => 'required',
                'bukti'               => 'required'
            ]);

            if ($request->file('bukti')) {
                $filename      = time() . '_' . 'bukti_karya_mahasiswa' . '_' . Auth::user()->username . '.' . $request->bukti->getClientOriginalExtension();
                $filePath      = $request->file('bukti')->storeAs('uploads', $filename, 'public');

                $files = Files::create([
                    'nama'                  => $filename,
                    'path'                  => $filePath,
                    'siakad_mhspt_id'       => Auth::user()->id,
                    'ref_jenis_kegiatan_id' => 10
                ]);

            }

            $karyaMahasiswa = Publikasi::create([
                'siakad_mhspt_id'     => Auth::user()->id,
                'judul'               => $request->judul,
                'tgl_terbit'          => $request->tgl_terbit,
                'penerbit'            => $request->penerbit,
                'jenis_id'            => $request->jenis_id,
                'kategori_capaian_id' => $request->kategori_capaian_id,
                'tautan_eksternal'     => $request->tautan_eksternal,
                'bukti'               => $files->id_files
            ]);
            if ($karyaMahasiswa) {
                toastr()->success('Berhasil Tambah Data');
            } else {
                toastr()->error('Terjadi Kesalahan, Silahkan Coba Lagi');
            }
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = KaryaMahasiswa::findOrFail(decrypt($id));
        return view('karya-mahasiswa.show', compact('data'));
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
    public function destroy(Request $request,$id)
    {
        if($request->jenis == 'hki'){
            $data = Hki::findOrFail(decrypt($id));
            $data->delete();
            toastr()->success('Berhasil Hapus Data');
        }elseif($request->jenis == 'publikasi'){
            $data = Publikasi::findOrFail(decrypt($id));
            $data->delete();
            toastr()->success('Berhasil Hapus Data');
        }

        return back();
    }
}
