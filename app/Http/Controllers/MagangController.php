<?php

namespace App\Http\Controllers;

use App\Models\Files;
use App\Models\KegiatanMahasiswa;
use App\Models\Magang;
use App\Models\PenghargaanKejuaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MagangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['utama'] = Magang::where('siakad_mhspt_id', Auth::user()->id)->get();
        return view('magang.index', compact('data'));
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
            'nama'                => 'required|string',
            'ref_bidang_id'       => 'required|integer',
            'ref_divisi_id'       => 'required|integer',
            'tanggal_kegiatan'    => 'required',
            'alamat'              => 'required',
            'kepeg_pegawai_id'    => 'sometimes|integer',
            'bukti_kegiatan'      => 'required|mimes:jpg,png,pdf,docx',
            'judul_laporan_akhir' => 'required'
        ]);

        if ($request->file('bukti_kegiatan')) {
            $filename      = time() . '_' . 'bukti_magang' . '_' . Auth::user()->username . '.' . $request->bukti_kegiatan->getClientOriginalExtension();
            $original_name = $request->bukti_kegiatan->getClientOriginalName();
            $filePath      = $request->file('bukti_kegiatan')->storeAs('uploads', $filename, 'public');

            $files = Files::create([
                'nama'                  => $filename,
                'path'                  => $filePath,
                'siakad_mhspt_id'       => Auth::user()->id,
                'ref_jenis_kegiatan_id' => 6
            ]);
        }

        $magang = Magang::create([
            'nama'                                => $request->nama,
            'ref_bidang_id'                       => $request->ref_bidang_id,
            'ref_divisi_id'                       => $request->ref_divisi_id,
            'kepeg_pegawai_id'                    => $request->dosen_pembimbing,
            'judul_laporan_akhir'                 => $request->judul_laporan_akhir,
            'tugas_utama_magang'                  => $request->tugas_utama_magang,
            'siakad_mhspt_id'                     => Auth::user()->id,
            'tgl_mulai'                           => $request->tanggal_mulai_kegiatan,
            'tgl_selesai'                         => $request->tanggal_selesai_kegiatan,
            'alamat'                              => $request->alamat,
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
        $data = Magang::findOrFail(decrypt($id));
        return view('magang.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['utama'] = Magang::findOrFail(decrypt($id));
        return view('magang.edit', compact('data'));
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
            'nama'                => 'required|string',
            'ref_bidang_id'       => 'required|integer',
            'ref_divisi_id'       => 'required|integer',
            'tanggal_kegiatan'    => 'required',
            'alamat'              => 'required',
            'kepeg_pegawai_id'    => 'sometimes|integer',
            'judul_laporan_akhir' => 'required'
        ]);


        $data_utama = Magang::findOrFail(decrypt($id));

        if ($request->file('bukti_kegiatan')) {
            $extension = ['jpg', 'png', 'pdf', 'docx'];
            $file = $request->bukti_kegiatan->getClientOriginalExtension();
            if (in_array($file, $extension)) {
                $filename = time() . '_' . 'bukti_magang' . '_' . Auth::user()->username . '.' . $request->bukti_kegiatan->getClientOriginalExtension();
                $filePath = $request->file('bukti_kegiatan')->storeAs('uploads', $filename, 'public');
                $files = Files::where('id_file', $data_utama->files->id_files)->updateOrCreate(
                    [
                        'id_file' => $data_utama->files->id_files
                    ],
                    [
                        'nama'                  => $filename,
                        'path'                  => $filePath,
                    ]
                );

                Magang::where('id_magang', decrypt($id))->update([
                    'nama'                                => $request->nama ?? $data_utama->nama,
                    'ref_bidang_id'                       => $request->ref_bidang_id ?? $data_utama->ref_bidang_id,
                    'ref_divisi_id'                       => $request->ref_divisi_id ?? $data_utama->ref_divisi_id,
                    'kepeg_pegawai_id'                    => $request->dosen_pembimbing ?? $data_utama->kepeg_pegawai_id,
                    'judul_laporan_akhir'                 => $request->judul_laporan_akhir ?? $data_utama->judul_laporan_akhir,
                    'tugas_utama_magang'                  => $request->tugas_utama_magang ?? $data_utama->tugas_utama_magang,
                    'siakad_mhspt_id'                     => Auth::user()->id,
                    'tgl_mulai'                           => $request->tanggal_mulai_kegiatan ?? $data_utama->tgl_mulai,
                    'tgl_selesai'                         => $request->tanggal_selesai_kegiatan ?? $data_utama->tgl_selesai,
                    'alamat'                              => $request->alamat ?? $data_utama->alamat,
                    'file_kegiatan_id'                    => $files->id_files ?? $data_utama->file_kegiatan_id,
                    'file_kegiatan_ref_jenis_kegiatan_id' => $files->ref_jenis_kegiatan_id,
                ]);
            }
        }else{
            Magang::where('id_magang', decrypt($id))->update([
                'nama'                                => $request->nama ?? $data_utama->nama,
                'ref_bidang_id'                       => $request->ref_bidang_id ?? $data_utama->ref_bidang_id,
                'ref_divisi_id'                       => $request->ref_divisi_id ?? $data_utama->ref_divisi_id,
                'kepeg_pegawai_id'                    => $request->dosen_pembimbing ?? $data_utama->kepeg_pegawai_id,
                'judul_laporan_akhir'                 => $request->judul_laporan_akhir ?? $data_utama->judul_laporan_akhir,
                'tugas_utama_magang'                  => $request->tugas_utama_magang ?? $data_utama->tugas_utama_magang,
                'siakad_mhspt_id'                     => Auth::user()->id,
                'tgl_mulai'                           => $request->tanggal_mulai_kegiatan ?? $data_utama->tgl_mulai,
                'tgl_selesai'                         => $request->tanggal_selesai_kegiatan ?? $data_utama->tgl_selesai,
                'alamat'                              => $request->alamat ?? $data_utama->alamat,
            ]);
        }



        toastr()->success('Berhasil Update Data');
        return redirect()->route('magang.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Magang::findOrFail(decrypt($id));
        $file = Files::find($data->file_kegaitan_id);
        if (!empty($file)) {
            if (Storage::exists($file->path)) {
                Storage::delete($file->path);
                $data->files()->delete();
            }
        }

        $data->delete();
        toastr()->success('Berhasil Hapus Data');
        return back();
    }
}
