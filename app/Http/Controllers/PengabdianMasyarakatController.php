<?php

namespace App\Http\Controllers;

use App\Models\Files;
use App\Models\BobotNilai;
use Illuminate\Http\Request;
use App\Models\PengabdianMasyarakat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengabdianMasyarakatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['utama'] = PengabdianMasyarakat::where('siakad_mhspt_id', Auth::user()->id)->get();
        return view('pengabdian-masyarakat.index',compact('data'));
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
            $filename      = time() . '_' . 'bukti_pengabdian_masyarakat' . '_' . Auth::user()->username . '.' . $request->bukti_kegiatan->getClientOriginalExtension();
            $filesk = time() . '_' . 'file_sk' . '_' . Auth::user()->username . '.' . $request->file_sk->getClientOriginalExtension();

            $filePath      = $request->file('bukti_kegiatan')->storeAs('uploads', $filename, 'public');
            $fileSKPath = $request->file('file_sk')->storeAs('uploads', $filesk, 'public');

            $files = Files::create([
                'nama'                  => $filename,
                'path'                  => $filePath,
                'siakad_mhspt_id'       => Auth::user()->id,
                'ref_jenis_kegiatan_id' => 4
            ]);

            $fileSK = Files::create([
                'nama'                  => $filesk,
                'path'                  => $fileSKPath,
                'siakad_mhspt_id'       => Auth::user()->id,
                'ref_jenis_kegiatan_id' => 4
            ]);
        }

        $bobot_nilai = BobotNilai::where('ref_jenis_kegiatan_id', 4)
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

            PengabdianMasyarakat::create([
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
        $data = PengabdianMasyarakat::findOrFail(decrypt($id));
        return view('pengabdian-masyarakat.show',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['utama'] = PengabdianMasyarakat::findOrFail(decrypt($id));
        return view('pengabdian-masyarakat.edit', compact('data'));
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

        $data_utama = PengabdianMasyarakat::findOrFail(decrypt($id));
        $bobot_nilai = BobotNilai::where('ref_jenis_kegiatan_id', 4)
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

        if ($request->file('bukti_kegiatan') && $request->file('file_sk')) {
            $extension = ['jpg,pdf,docx'];
            $file = $request->bukti_kegiatan->getClientOriginalExtension();
            $file_sk = $request->file_sk->getClientOriginalExtension();
            if (in_array($file, $extension) && in_array($file_sk, $extension)) {
                $filename      = time() . '_' . 'bukti_pengabdian_masyarakat' . '_' . Auth::user()->username . '.' . $request->bukti_kegiatan->getClientOriginalExtension();
                $filenameSk = time() . '_' . 'sk_pengabdian_masyarakat' . '_' . Auth::user()->username . '.' . $request->file_sk->getClientOriginalExtension();

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

                PengabdianMasyarakat::where('id_pengabdian_masyarakat',decrypt($id))->update([
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
                    'status_validasi' => '0'
                ]);

                toastr()->success('Berhasil Update Data');
                return back();

            } else {
                toastr()->error(' Terjadi Kesalahan :( ');
            }
        } else {
            PengabdianMasyarakat::where('id_pengabdian_masyarakat',decrypt($id))->update([
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
        $data    = PengabdianMasyarakat::findOrFail(decrypt($id));
        $file    = Files::find($data->file_kegiatan_id);
        $file_sk = Files::find($data->file_sk_id);
        if(!empty($file)){
            if(Storage::exists('public/'.$file->path)){
                Storage::delete('public/'.$file->path);
                $data->files()->delete();
            }
        }

        if(!empty($file_sk)){
            if(Storage::exists('public/'.$file_sk->path)){
                Storage::delete('public/'.$file_sk->path);
                $data->file_sk()->delete();
            }
        }

        $data->delete();
        toastr()->success('Berhasil Hapus Data');
        return back();
    }
}
