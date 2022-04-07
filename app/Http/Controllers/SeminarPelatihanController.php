<?php

namespace App\Http\Controllers;

use App\Models\Files;
use App\Models\BobotNilai;
use Illuminate\Http\Request;
use App\Models\SeminarPelatihan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SeminarPelatihanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $seminar = SeminarPelatihan::where('siakad_mhspt_id',Auth::user()->id)->get();
        return view('seminar-pelatihan.index',compact('seminar'));
    }

    /**
     * Show the form for creating a ew resource.
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
            'tanggal_mulai_kegiatan'   => 'required|date',
            'tanggal_selesai_kegiatan' => 'required|date',
            'prestasi'                 => 'required|integer',
            'dosen_pembimbing'         => 'nullable|integer',
            'bukti_kegiatan'           => 'required|mimes:jpg,png,pdf,docx|file|max:5000',
            'file_sk'                  => 'required|mimes:jpg,png,pdf,docx|file|max:5000'
        ],[
            'nama_kegiatan.required'          => 'Nama Kegiatan Harus di isi',
            'nama_kegiatan.string'            => 'Nama Kegiatan Harus berbentuk text',
            'tingkat_kegiatan.required'       => 'Tingkat Kegiatan Harus di isi',
            'tingkat_kegiatan.integer'        => 'Tingkat Kegiatan Salah',
            'tanggal_mulai_kegiatan.required' => 'Tanggal Kegiatan Harus di isi',
            'peran.required'                  => 'Peran Harus di isi',
            'peran.integer'                   => 'Format Peran Salah',
            'dosen_pembimbing.integer'        => 'Format Data Dosen Salah',
            'bukti_kegiatan.required'         => 'Bukti Kegiatan Harus di isi',
            'bukti_kegiatan.mimes'            => 'Format File tidak mendukung',
            'file_sk.required'                => 'Bukti Kegiatan Harus di isi',
            'file_sk.mimes'                   => 'Format File tidak mendukung'
        ]);

        if($request->file('bukti_kegiatan') && $request->file('file_sk')){
            $filename      = time().'_'.'bukti_kegiatan_seminar_pelatihan'.'_'.Auth::user()->username.'.'.$request->bukti_kegiatan->getClientOriginalExtension();

            $fileSK = time().'_'.'file_sk_seminar_pelatihan'.'_'.Auth::user()->username.'.'.$request->file_sk->getClientOriginalExtension();

            $filePath   = $request->file('bukti_kegiatan')->storeAs('uploads',$filename,'public');
            $fileSKPath = $request->file('file_sk')->storeAs('uploads',$fileSK,'public');

            $files = Files::create([
                'nama'                  => $filename,
                'path'                  => $filePath,
                'siakad_mhspt_id'       => Auth::user()->id,
                'ref_jenis_kegiatan_id' => 2
            ]);

            $fileSK = Files::create([
                'nama'                  => $fileSK,
                'path'                  => $fileSKPath,
                'siakad_mhspt_id'       => Auth::user()->id,
                'ref_jenis_kegiatan_id' => 2
            ]);

        }

        $bobot_nilai = BobotNilai::where('ref_jenis_kegiatan_id',2)
                    ->when($request->penyelenggara_kegiatan,function($q) use($request) {
                            $q->where('ref_penyelenggara_id',$request->penyelenggara_kegiatan);})

                    ->when($request->tingkat_kegiatan,function($q) use ($request){
                            $q->where('ref_tingkat_id',$request->tingkat_kegiatan);})

                    ->when($request->prestasi,function($q) use ($request){
                            $q->where('ref_peran_prestasi_id',$request->prestasi);})

                    ->first();

        SeminarPelatihan::create([
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
            'file_sk_id'                             => $fileSK->id_files,
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
        $data = SeminarPelatihan::findOrFail(decrypt($id));
        return view('seminar-pelatihan.show',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['utama'] = SeminarPelatihan::findOrFail(decrypt($id));
        return view('seminar-pelatihan.edit', compact('data'));
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

        $data_utama = SeminarPelatihan::findOrFail(decrypt($id));
        $bobot_nilai = BobotNilai::where('ref_jenis_kegiatan_id', 1)
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

                SeminarPelatihan::where('id_seminar_pelatihan_workshop_diklat',decrypt($id))->update([
                    'file_kegiatan_id'                    => $files->id_files,
                ]);

            } else {
                toastr()->error(' Terjadi Kesalahan :( ');
            }
        }


        if ($request->file('file_sk')) {
            $extension = ['jpg,pdf,docx'];
            $file_sk = $request->file_sk->getClientOriginalExtension();
            if (in_array($file_sk, $extension)) {
                $filenameSk = time() . '_' . 'file_sk_seminar_pelatihan' . '_' . Auth::user()->username . '.' . $request->file_sk->getClientOriginalExtension();

                $fileSKPath = $request->file('file_sk')->storeAs('uploads', $filenameSk, 'public');

                 $fileSK = Files::where('id_file', $data_utama->file_sk->id_files)->updateOrCreate(
                    [
                        'id_file' => $data_utama->file_sk->id_files
                    ],
                    [
                    'nama'                  => $filenameSk,
                    'path'                  => $fileSKPath,
                    ]
                 );

                SeminarPelatihan::where('id_seminar_pelatihan_workshop_diklat',decrypt($id))->update([
                    'file_sk_id'                          => $fileSK->id_files,
                ]);

            } else {
                toastr()->error(' Terjadi Kesalahan :( ');
            }
        }

        SeminarPelatihan::where('id_seminar_pelatihan_workshop_diklat',decrypt($id))->update([
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
        return redirect()->route('seminar-pelatihan.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = SeminarPelatihan::findOrFail(decrypt($id));
        $file = Files::find($data->file_kegiatan_id);
        $file_sk = Files::find($data->file_sk_id);

        if(!empty($file)){

            if(Storage::exists($file->path)){
                Storage::delete($file->path);
                $data->files()->delete();
            }
        }

        if(!empty($file_sk)){

            if(Storage::exists($file_sk->path)){
                Storage::delete($file_sk->path);
                $data->file_sk()->delete();
            }
        }
        $data->delete();
        toastr()->success('Berhasil Hapus Data');
        return back();
    }
}
