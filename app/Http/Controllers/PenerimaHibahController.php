<?php

namespace App\Http\Controllers;

use App\Models\Files;
use App\Models\Tingkat;
use App\Models\Prestasi;
use App\Models\BobotNilai;
use Illuminate\Http\Request;
use App\Models\PenerimaHibah;
use App\Models\Penyelenggara;
use App\Models\KegiatanMahasiswa;
use App\Models\PenghargaanKejuaraan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PenerimaHibahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['utama'] = PenerimaHibah::where('siakad_mhspt_id', Auth::user()->id)->get();
        return view('penerima-hibah.index',compact('data'));
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
            'nama_kegiatan'            => 'required|string',
            'penyelenggara_kegiatan'   => 'required|integer',
            'tingkat_kegiatan'         => 'required|integer',
            'tanggal_kegiatan'         => 'required',
            'prestasi'                 => 'required|integer',
            'dosen_pembimbing'         => 'nullable|integer',
            'bukti_kegiatan'           => 'required|mimes:jpg,png,pdf,docx'
        ]);

        if ($request->file('bukti_kegiatan') && $request->file('file_sk')) {
            $filename = time() . '_' . 'bukti_penerima_hibah' . '_' . Auth::user()->username . '.' . $request->bukti_kegiatan->getClientOriginalExtension();
            $fileSK   = time() . '_' . 'file_sk_penerima_hibah' . '_' . Auth::user()->username . '.' . $request->file_sk->getClientOriginalExtension();

            $filePath   = $request->file('bukti_kegiatan')->storeAs('uploads', $filename, 'public');
            $fileSKPath = $request->file('file_sk')->storeAs('uploads', $fileSK, 'public');

            $files = Files::create([
                'nama'                  => $filename,
                'path'                  => $filePath,
                'siakad_mhspt_id'       => Auth::user()->id,
                'ref_jenis_kegiatan_id' => 3
            ]);

            $fileSK = Files::create([
                'nama'                  => $fileSK,
                'path'                  => $fileSKPath,
                'siakad_mhspt_id'       => Auth::user()->id,
                'ref_jenis_kegiatan_id' => 3
            ]);
        }

        $bobot_nilai = BobotNilai::where('ref_jenis_kegiatan_id', 3)
            ->when($request->penyelenggara_kegiatan, function ($q) use ($request) {
                $q->where('ref_penyelenggara_id', $request->penyelenggara_kegiatan);
            })
            ->when($request->tingkat_kegiatan, function ($q) use ($request) {
                $q->where('ref_tingkat_id', $request->tingkat_kegiatan);
            })
            ->when($request->prestasi, function ($q) use ($request) {
                $q->where('ref_peran_prestasi_id', $request->prestasi);
            })
            ->first();

            PenerimaHibah::create([
                'nama'                                => $request->nama_kegiatan,
                'ref_penyelenggara_id'                => $request->penyelenggara_kegiatan,
                'ref_tingkat_id'                      => $request->tingkat_kegiatan,
                'ref_peran_prestasi_id'               => $request->prestasi,
                'kepeg_pegawai_id'                    => $request->dosen_pembimbing,
                'siakad_mhspt_id'                     => Auth::user()->id,
                'tgl_mulai'                           => $request->tanggal_mulai_kegiatan,
                'tgl_selesai'                         => $request->tanggal_selesai_kegiatan,
                'bobot_nilai_id'                      => $bobot_nilai->id_bobot_nilai,
                'file_kegiatan_id'                    => $files->id_files,
                'file_sk_id'                          => $fileSK->id_files,
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
        $data = PenerimaHibah::findOrFail(decrypt($id));
        return view('penerima-hibah.show',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['utama'] = PenerimaHibah::findOrFail(decrypt($id));
        return view('penerima-hibah.edit', compact('data'));
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
            'nama_kegiatan'    => 'required|string',
            'penyelenggara'    => 'required|integer',
            'tingkat'          => 'required|integer',
            'tanggal_kegiatan' => 'required',
            'prestasi'         => 'required|integer',
            'dosen_pembimbing' => 'nullable|integer',
        ]);

        $data_utama = PenerimaHibah::findOrFail(decrypt($id));
        $bobot_nilai = BobotNilai::where('ref_jenis_kegiatan_id', 3)
            ->when($request->penyelenggara_kegiatan, function ($q) use ($request) {
                $q->where('ref_penyelenggara_id', $request->penyelenggara_kegiatan);
            })
            ->when($request->tingkat_kegiatan, function ($q) use ($request) {
                $q->where('ref_tingkat_id', $request->tingkat_kegiatan);
            })
            ->when($request->prestasi, function ($q) use ($request) {
                $q->where('ref_peran_prestasi_id', $request->prestasi);
            })
            ->first();

        if ($request->file('bukti_kegiatan')  && $request->file('file_sk')) {
            $extension = ['jpg,pdf,docx'];
            $file      = $request->bukti_kegiatan->getClientOriginalExtension();
            $file_sk   = $request->file_sk->getClientOriginalExtension();
            if (in_array($file, $extension) && in_array($file_sk, $extension)) {
                $filename    = time() . '_' . 'bukti_penerima_hibah' . '_' . Auth::user()->username . '.' . $request->bukti_kegiatan->getClientOriginalExtension();
                $filenameSk = time() . '_' . 'sk_penerima_hibah' . '_' . Auth::user()->username . '.' . $request->file_sk->getClientOriginalExtension();

                $filePath   = $request->file('bukti_kegiatan')->storeAs('uploads', $filename, 'public');
                $fileSKPath = $request->file('file_sk')->storeAs('uploads', $filenameSk, 'public');

                $files = Files::where('id_file', $data_utama->files->id_files)->updateOrCreate(
                    [
                        'id_file' => $data_utama->files->id_files
                    ],
                    [
                    'nama'                  => $filename,
                    'path'                  => $filePath,
                    ]
                 );

                 $fileSK = Files::where('id_file', $data_utama->file_sk->id_files)->updateOrCreate(
                    [
                        'id_file' => $data_utama->file_sk->id_files
                    ],
                    [
                    'nama'                  => $filenameSk,
                    'path'                  => $fileSKPath,
                    ]
                 );

                PenerimaHibah::where('id_penerima_hibah_pendanaan',decrypt($id))->update([
                    'nama'                                => $request->nama_kegiatan ?? $data_utama->nama_kegiatan,
                    'ref_penyelenggara_id'                => $request->penyelenggara_kegiatan ?? $data_utama->ref_penyelenggara_id,
                    'ref_tingkat_id'                      => $request->tingkat_kegiatan ?? $data_utama->ref_tingkat_id,
                    'ref_peran_prestasi_id'               => $request->prestasi ?? $data_utama->ref_peran_prestasi_id,
                    'kepeg_pegawai_id'                    => $request->dosen_pembimbing ?? $data_utama->kepeg_pegawai_id,
                    'tgl_mulai'                           => $request->tanggal_mulai_kegiatan ?? $data_utama->tgl_mulai,
                    'tgl_selesai'                         => $request->tanggal_selesai_kegiatan ?? $data_utama->tgl_selesai,
                    'bobot_nilai_id'                      => $bobot_nilai->id_bobot_nilai ?? $data_utama->bobot_nilai_id,
                    'file_kegiatan_id'                    => $files->id_files,
                    'file_sk_id'                          => $fileSK->id_files,
                    'file_kegiatan_ref_jenis_kegiatan_id' => $files->ref_jenis_kegiatan_id,
                ]);

                toastr()->success('Berhasil Update Data');
                return back();

            } else {
                toastr()->error(' Terjadi Kesalahan :( ');
            }
        } else {
            PenerimaHibah::where('id_penerima_hibah_pendanaan',decrypt($id))->update([
                'nama'                                => $request->nama_kegiatan ?? $data_utama->nama,
                'ref_penyelenggara_id'                => $request->penyelenggara_kegiatan ?? $data_utama->ref_penyelenggara_id,
                'ref_tingkat_id'                      => $request->tingkat_kegiatan ?? $data_utama->ref_tingkat_id,
                'ref_peran_prestasi_id'               => $request->prestasi ?? $data_utama->ref_peran_prestasi_id,
                'kepeg_pegawai_id'                    => $request->dosen_pembimbing ?? $data_utama->kepeg_pegawai_id,
                'tgl_mulai'                           => $request->tanggal_mulai_kegiatan ?? $data_utama->tgl_mulai,
                'tgl_selesai'                         => $request->tanggal_selesai_kegiatan ?? $data_utama->tgl_selesai,
                'bobot_nilai_id'                      => $bobot_nilai->id_bobot_nilai ?? $data_utama->bobot_nilai_id,
            ]);

            toastr()->success('Berhasil Update Data');
            return redirect()->route('penerima_hibah.index');
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
        $data    = PenerimaHibah::findOrFail(decrypt($id));
        $file    = Files::where('id_files', $data->file_kegiatan_id)->first();
        $file_sk = Files::where('id_files', $data->file_sk_id)->first();

        if($file) {
            Storage::delete('public/'.$file->path);
            $data->files()->delete();
        }

        if($file_sk) {
            Storage::delete('public/'.$file_sk->path);
            $data->file_sk()->delete();
        }

        $data->delete();
        toastr()->success('Berhasil Hapus Data');
        return back();
    }
}
