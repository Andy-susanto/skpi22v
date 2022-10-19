<?php

namespace App\Http\Controllers;

use App\Http\Requests\BeasiswaRequest;
use App\Models\Files;
use App\Models\Beasiswa;
use Illuminate\Http\Request;
use App\Models\KegiatanMahasiswa;
use App\Models\PenghargaanKejuaraan;
use App\Repositories\BeasiswaRepository;
use App\Repositories\FileRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BeasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $beasiswaRepository, $fileRepository;
    public function __construct(BeasiswaRepository $beasiswaRepository, FileRepository $fileRepository)
    {
        parent::__construct();
        $this->beasiswaRepository = $beasiswaRepository;
        $this->fileRepository = $fileRepository;
    }
    public function index()
    {
        $options = [
            'mhspt' => Auth::user()->siakad_mhspt()->exists() ? Auth::user()->siakad_mhspt->id_mhs_pt : ''
        ];
        $this->data['data'] = $this->beasiswaRepository->findAll($options);
        return view('beasiswa.index', $this->data);
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
    public function store(BeasiswaRequest $request)
    {
        $params = $request->validated();
        $BuktiKegiatanParams = [
            'tag' => 'bukti-beasiswa',
            'jenis_kegiatan' => 7,
            'id_mhspt' => $this->mhspt
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
        if ($this->beasiswaRepository->create($params)) {
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
       $this->data['data'] = $this->beasiswaRepository->findById(decrypt($id));
        return view('beasiswa.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->data['utama'] = $this->beasiswaRepository->findById(decrypt($id));
        return view('beasiswa.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BeasiswaRequest $request, $id)
    {

        $params = $request->validated();
        $beasiswa = $this->beasiswaRepository->findById(decrypt($id));
        $BuktiKegiatanParams = [
            'tag' => 'bukti-beasiswa',
            'jenis_kegiatan' => 7,
            'id_mhspt' => $this->mhspt
        ];
        $BuktiKegiatanParams = array_merge($params, $BuktiKegiatanParams);
        $FileBukti = $this->fileRepository->update($beasiswa->file_kegiatan_id,$BuktiKegiatanParams);
        if ($FileBukti) {
            $FileBuktiParams = array(
                'file_kegiatan_id'                    => $FileBukti->id_files,
                'file_kegiatan_ref_jenis_kegiatan_id' => $FileBukti->ref_jenis_kegiatan_id,
                'siakad_mhspt_id'                     => $this->mhspt
            );
            $params = array_merge($params, $FileBuktiParams);
        }
        if ($this->beasiswaRepository->update(decrypt($id),$params)) {
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
        $beasiswa = $this->beasiswaRepository->findById(decrypt($id));
        $this->fileRepository->delete($beasiswa->file_kegiatan_id);
        if($this->beasiswaRepository->delete(decrypt($id))){
            toastr()->success('Berhasil Hapus Data');
        }else{
            toastr()->error('Terjadi Kesalahan, Silahkan Ulangi lagi');
        }

        return back();
    }
}
