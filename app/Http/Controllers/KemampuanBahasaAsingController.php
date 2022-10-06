<?php

namespace App\Http\Controllers;

use App\Http\Requests\KBAsingRequest;
use App\Models\Files;
use Illuminate\Http\Request;
use App\Models\KemampuanBahasaAsing;
use App\Repositories\KBAsingRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KemampuanBahasaAsingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $kbAsingRepository;
    public function __construct(KBAsingRepository $kbAsingReposiory)
    {
        parent::__construct();
        $this->kbAsingRepository = $kbAsingReposiory;
    }
    public function index()
    {
        $options = [
            'mhspt' => $this->mhspt
        ];
        $this->data['data'] = $this->kbAsingRepository->findAll($options);
        return view('kemampuan-bahasa-asing.index', $this->data);
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
    public function store(KBAsingRequest $request)
    {
        $params = $request->validated();
        $buktiKegiatanParams = [
            'tag'            => 'bukti-kemampuan-bahasa-asing',
            'jenis_kegiatan' => 8,
            'id_mhspt'       => $this->mhspt
        ];
        $createBuktiKegiatanParams = array_merge($params, $buktiKegiatanParams);
        $CreateFileBukti = $this->fileRepository->create($createBuktiKegiatanParams);
        if ($CreateFileBukti) {
            $FileBuktiParams = array(
                'file_kegiatan_id'=> $CreateFileBukti->id_files,
                'file_kegiatan_ref_jenis_kegiatan_id' => $CreateFileBukti->ref_jenis_kegiatan_id,
                'siakad_mhspt_id'=>$this->mhspt
            );
            $params = array_merge($params, $FileBuktiParams);
        }
        if ($this->kbAsingRepository->create($params)) {
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
        $this->data['data'] = $this->kbAsingRepository->findById(decrypt($id));
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
        $data['utama'] = $this->kbAsingRepository->findById(decrypt($id));
        return view('kemampuan-bahasa-asing.edit', $this->data);
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
        $data = $this->kbAsingRepository->findById(decrypt($id));
        $BuktiKegiatanParams = [
            'tag'            => 'bukti-beasiswa',
            'jenis_kegiatan' => 8,
            'id_mhspt'       => $this->mhspt
        ];
        $BuktiKegiatanParams = array_merge($params, $BuktiKegiatanParams);
        $FileBukti = $this->fileRepository->update($data->file_kegiatan_id,$BuktiKegiatanParams);
        if ($FileBukti) {
            $FileBuktiParams = array(
                'file_kegiatan_id'                    => $FileBukti->id_files,
                'file_kegiatan_ref_jenis_kegiatan_id' => $FileBukti->ref_jenis_kegiatan_id,
                'siakad_mhspt_id'                     => $this->mhspt
            );
            $params = array_merge($params, $FileBuktiParams);
        }
        if ($this->kbAsingRepository->update(decrypt($id),$params)) {
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
        $data = $this->kbAsingRepository->findById(decrypt($id));
        $this->fileRepository->delete($data->file_kegiatan_id);
        if($this->beasiswaRepository->delete(decrypt($id))){
            toastr()->success('Berhasil Hapus Data');
        }else{
            toastr()->error('Terjadi Kesalahan, Silahkan Ulangi lagi');
        }

        return back();
    }
}
