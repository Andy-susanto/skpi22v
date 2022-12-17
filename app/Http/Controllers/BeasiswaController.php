<?php

namespace App\Http\Controllers;

use App\Http\Requests\BeasiswaRequest;
use App\Models\Files;
use App\Models\Beasiswa;
use Illuminate\Http\Request;
use App\Models\KegiatanMahasiswa;
use App\Models\PenghargaanKejuaraan;
use App\Repositories\repository;
use App\Repositories\FileRepository;
use App\Repositories\KegiatanRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BeasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $repository, $fileRepository, $jenis;
    public function __construct(KegiatanRepository $repository, FileRepository $fileRepository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->fileRepository = $fileRepository;
        $this->jenis = config('kegiatan.BEASISWA');
    }

    protected function mhspt()
    {
        return Auth::user()->siakad_mhspt()->exists() ? Auth::user()->siakad_mhspt->id_mhs_pt : '';
    }

    public function index()
    {
        $options = [
            'mhspt' => $this->mhspt(),
            'jenis' => $this->jenis
        ];
        $this->data['data'] = $this->repository->findAll($options);
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
        $adt = [
            'siakad_mhspt_id' => $this->mhspt(),
        ];
        $params = array_merge($params, $adt);
        $BuktiKegiatanParams = [
            'tag' => 'bukti-beasiswa',
            'jenis_kegiatan' => $request->ref_jenis_kegiatan_id,
            'id_mhspt' => $this->mhspt()
        ];
        $createBuktiKegiatanParams = array_merge($params, $BuktiKegiatanParams);
        $CreateFileBukti = $this->fileRepository->create($createBuktiKegiatanParams);
        if ($CreateFileBukti) {
            $FileBuktiParams = array(
                'file_id' => $CreateFileBukti->id_files,
            );
            $params = array_merge($params, $FileBuktiParams);
        }

        if ($this->repository->create($params)) {
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
        $this->data['data'] = $this->repository->findById(decrypt($id));
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
        $this->data['utama'] = $this->repository->findById(decrypt($id));
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
        $data = $this->repository->findById(decrypt($id));
        $BuktiKegiatanParams = [
            'tag' => 'bukti-beasiswa',
            'jenis_kegiatan' => $request->ref_jenis_kegiatan_id,
            'id_mhspt' => $this->mhspt()
        ];
        $adt = [
            'siakad_mhspt_id' => $this->mhspt(),
        ];
        $params = array_merge($params, $adt);
        $BuktiKegiatanParams = array_merge($params, $BuktiKegiatanParams);
        $FileBukti = $this->fileRepository->update($data->file_id, $BuktiKegiatanParams);
        if ($FileBukti) {
            $FileBuktiParams = array(
                'file_id'               => $FileBukti->id_files,
            );
            $params = array_merge($params, $FileBuktiParams);
        }
        if ($this->repository->update(decrypt($id), $params)) {
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
        $data = $this->repository->findById(decrypt($id));
        $this->fileRepository->delete($data->file_id);
        if ($this->repository->delete(decrypt($id))) {
            toastr()->success('Berhasil Hapus Data');
        } else {
            toastr()->error('Terjadi Kesalahan, Silahkan Ulangi lagi');
        }

        return back();
    }
}
