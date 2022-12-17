<?php

namespace App\Http\Controllers;

use App\Traits\RelasiTrait;
use Illuminate\Http\Request;
use App\Repositories\FileRepository;
use Illuminate\Support\Facades\Auth;
use App\Repositories\KegiatanRepository;

class KegiatanController extends Controller
{

    use RelasiTrait;

    private $repository, $fileRepository, $jenis;
    public function __construct(KegiatanRepository $repository, FileRepository $fileRepository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->fileRepository = $fileRepository;
    }

    public function index($jenis)
    {
        $options = [
            'mhspt' => $this->mhspt(),
            'jenis' => $this->relasiView($jenis)['jenis']
        ];

        $this->data['data'] = $this->repository->findAll($options);
        return view($this->relasiView($jenis)['view'], $this->data);
    }

    protected function mhspt()
    {
        return Auth::user()->siakad_mhspt()->exists() ? Auth::user()->siakad_mhspt->id_mhs_pt : '';
    }

    public function store(Request $request)
    {
        $params = $request->validate($this->relasiRequest($request->ref_jenis_kegiatan_id)->rules());

        $adt = [
            'siakad_mhspt_id' => $this->mhspt(),
            'ref_jenis_kegiatan_id' => $request->ref_jenis_kegiatan_id
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

    public function edit($id)
    {
        $this->data['utama'] = $this->repository->findById(decrypt($id));
        return view('beasiswa.edit', $this->data);
    }

    public function update(Request $request, $id)
    {

        $params = $request->validate($this->relasiRequest($request->ref_jenis_kegiatan_id)->rules());
        $data = $this->repository->findById(decrypt($id));
        $BuktiKegiatanParams = [
            'tag' => 'bukti-beasiswa',
            'jenis_kegiatan' => $request->ref_jenis_kegiatan_id,
            'id_mhspt' => $this->mhspt()
        ];
        $adt = [
            'siakad_mhspt_id' => $this->mhspt(),
            'ref_jenis_kegiatan_id' => $request->ref_jenis_kegiatan_id
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
