<?php

namespace App\Http\Controllers;

use App\Http\Requests\KewirausahaanRequest;
use App\Models\Files;
use Illuminate\Http\Request;
use App\Models\Kewirausahaan;
use App\Models\KegiatanMahasiswa;
use App\Models\PenghargaanKejuaraan;
use App\Repositories\KewirausahaanRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KewirausahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $kewirausahaanRepository;

    public function __construct(KewirausahaanRepository $kewirausahaanRepository)
    {
        $this->kewirausahaanRepository = $kewirausahaanRepository;
    }

    public function index()
    {
        $options = [
            'mhspt' => $this->mhspt
        ];
        $this->data['data'] = $this->kewirausahaanRepository->findAll($options);
        return view('kewirausahaan.index', $this->data);
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
    public function store(KewirausahaanRequest $request)
    {
        $params = $request->validated();
        $BuktiKegiatanParams = [
            'tag'            => 'bukti-kewirausahaan',
            'jenis_kegiatan' => 7,
            'id_mhspt'       => $this->mhspt
        ];
        $createBuktiKegiatanParams = array_merge($params, $BuktiKegiatanParams);
        $CreateFileBukti = $this->fileRepository->create($createBuktiKegiatanParams);
        if ($CreateFileBukti) {
            $FileBuktiParams = array(
                'file_kegiatan_id'=> $CreateFileBukti->id_files,
                'file_kegiatan_ref_jenis_kegiatan_id' => $CreateFileBukti->ref_jenis_kegiatan_id,
                'siakad_mhspt_id'=>$this->mhspt
            );
            $params = array_merge($params, $FileBuktiParams);
        }
        if ($this->kewirausahaanRepository->create($params)) {
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
        $this->data['data'] = $this->kewirausahaanRepository->findById(decrypt($id));
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
        $data['utama'] = $this->kewirausahaanRepository->findById(decrypt($id));
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
        $params = $request->validated();
        $kewirausahaan = $this->kewirausahaanRepository->findById(decrypt($id));
        $BuktiKegiatanParams = [
            'tag' => 'bukti-kewirausahaan',
            'jenis_kegiatan' => 7,
            'id_mhspt' => $this->mhspt
        ];
        $BuktiKegiatanParams = array_merge($params, $BuktiKegiatanParams);
        $FileBukti = $this->fileRepository->update($kewirausahaan->file_kegiatan_id,$BuktiKegiatanParams);
        if ($FileBukti) {
            $FileBuktiParams = array(
                'file_kegiatan_id'                    => $FileBukti->id_files,
                'file_kegiatan_ref_jenis_kegiatan_id' => $FileBukti->ref_jenis_kegiatan_id,
                'siakad_mhspt_id'                     => $this->mhspt
            );
            $params = array_merge($params, $FileBuktiParams);
        }
        if ($this->kewirausahaanRepository->update(decrypt($id),$params)) {
            toastr()->success('Berhasil Tambah Data');
        } else {
            toastr()->error('Terjadi Kesalahan, Silahkan Ulangi lagi');
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = $this->kewirausahaanRepository->findById(decrypt($id));
        $this->fileRepository->delete($data->file_kegiatan_id);
        if($this->kewirausahaanRepository->delete(decrypt($id))){
            toastr()->success('Berhasil Hapus Data');
        }else{
            toastr()->error('Terjadi Kesalahan, Silahkan Ulangi lagi');
        }

        return back();
    }
}
