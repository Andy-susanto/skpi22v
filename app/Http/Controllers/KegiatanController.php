<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\BobotNilai;
use App\Traits\RelasiTrait;
use Illuminate\Http\Request;
use App\Models\JenisKegiatan;
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

    public function daftar()
    {
        $this->authorize('daftar-kegiatan-mahasiswa');
        $this->data['datas'] = JenisKegiatan::all();
        return view('kegiatan.daftar', $this->data);
    }

    public function index($jenis)
    {
        $this->authorize('read-kegiatan-mahasiswa');
        $options = [
            'mhspt' => $this->mhspt(),
            'jenis' => $this->relasiData($jenis)['jenis']
        ];

        $this->data['data'] = $this->repository->findAll($options);
        return view($this->relasiData($jenis)['index'], $this->data);
    }

    protected function mhspt()
    {
        return Auth::user()->siakad_mhspt()->exists() ? Auth::user()->siakad_mhspt->id_mhs_pt : '';
    }

    public function store(Request $request)
    {

        $this->authorize('create-kegiatan-mahasiswa');
        $params = $request->validate($this->relasiData($request->ref_jenis_kegiatan_id)['request']->rules());

        $cekFiles = array_intersect($request->allFiles(), $params);
        if (count($cekFiles) > 0) {

            foreach ($request->allFiles() as $key => $value) {
                $BuktiKegiatanParams = [
                    'jenis_kegiatan' => $request->ref_jenis_kegiatan_id,
                    'id_mhspt' => $this->mhspt(),
                    'file' => $value
                ];
                $createBuktiKegiatanParams = array_merge($BuktiKegiatanParams);
                $CreateFileBukti = $this->fileRepository->create($createBuktiKegiatanParams);
                if ($CreateFileBukti) {
                    $FileBuktiParams = array(
                        $key => $CreateFileBukti->id_files,
                    );
                    $params = array_merge($params, $FileBuktiParams);
                }
            }
        }

        $bobot_nilai = BobotNilai::where('ref_jenis_kegiatan_id', 2)
            ->when($request->ref_penyelenggara_id, function ($q) use ($request) {
                $q->where('ref_penyelenggara_id', $request->ref_penyelenggara_id);
            })

            ->when($request->ref_tingkat_id, function ($q) use ($request) {
                $q->where('ref_tingkat_id', $request->ref_tingkat_id);
            })

            ->when($request->ref_peran_prestasi_id, function ($q) use ($request) {
                $q->where('ref_peran_prestasi_id', $request->peran_prestasi_id);
            })
            ->first();

        $adt = [
            'siakad_mhspt_id' => $this->mhspt(),
            'ref_jenis_kegiatan_id' => $request->ref_jenis_kegiatan_id,
            'bobot_nilai_id' => $bobot_nilai->id_bobot_nilai ?? 0
        ];
        $params = array_merge($params, $adt);

        if ($this->repository->create($params)) {
            toastr()->success('Berhasil Tambah Data');
        } else {
            toastr()->error('Terjadi Kesalahan, Silahkan Ulangi lagi');
        }

        return back();
    }

    public function edit($id)
    {
        $this->authorize('update-kegiatan-mahasiswa');
        $this->data['data'] = $this->repository->findById(decrypt($id));
        $jenis = $this->data['data']->ref_jenis_kegiatan_id;
        return view($this->relasiData($jenis)['edit'], $this->data);
    }

    public function show($id)
    {
        $this->authorize('read-kegiatan-mahasiswa');
        $this->data['data'] = $this->repository->findById(decrypt($id));
        $jenis = $this->data['data']->ref_jenis_kegiatan_id;
        return view($this->relasiData($jenis)['show'], $this->data);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('update-kegiatan-mahasiswa');
        $data = $this->repository->findById(decrypt($id));
        $params = $request->validate($this->relasiData($data->ref_jenis_kegiatan_id)['request']->rules());
        $cekFiles = array_intersect($request->allFiles(), $params);
        if (count($cekFiles) > 0) {

            foreach ($request->allFiles() as $key => $value) {
                $BuktiKegiatanParams = [
                    'jenis_kegiatan' => $request->ref_jenis_kegiatan_id,
                    'id_mhspt' => $this->mhspt(),
                    'file' => $value
                ];
                $createBuktiKegiatanParams = array_merge($BuktiKegiatanParams);
                $FileBukti = $this->fileRepository->update($data->file_id, $BuktiKegiatanParams);
                if ($FileBukti) {
                    $FileBuktiParams = array(
                        $key => $FileBukti->id_files,
                    );
                    $params = array_merge($params, $FileBuktiParams);
                }
            }
        }

        $BuktiKegiatanParams = [
            'tag' => 'bukti-beasiswa',
            'jenis_kegiatan' => $request->ref_jenis_kegiatan_id,
            'id_mhspt' => $this->mhspt()
        ];

        $bobot_nilai = BobotNilai::where('ref_jenis_kegiatan_id', 2)
            ->when($request->ref_penyelenggara_id, function ($q) use ($request) {
                $q->where('ref_penyelenggara_id', $request->ref_penyelenggara_id);
            })

            ->when($request->ref_tingkat_id, function ($q) use ($request) {
                $q->where('ref_tingkat_id', $request->ref_tingkat_id);
            })

            ->when($request->ref_peran_prestasi_id, function ($q) use ($request) {
                $q->where('ref_peran_prestasi_id', $request->peran_prestasi_id);
            })
            ->first();

        $adt = [
            'siakad_mhspt_id' => $this->mhspt(),
            'ref_jenis_kegiatan_id' => $request->ref_jenis_kegiatan_id,
            'bobot_nilai_id' => $bobot_nilai->id_bobot_nilai ?? 0
        ];
        $params = array_merge($params, $adt);

        $BuktiKegiatanParams = array_merge($params, $BuktiKegiatanParams);
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
        $this->authorize('delete-kegiatan-mahasiswa');
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
