<?php

namespace App\Http\Controllers;

use App\Http\Requests\HkiRequest;
use App\Http\Requests\PublikasiRequest;
use App\Models\Hki;
use App\Models\Files;
use App\Models\Publikasi;
use App\Repositories\FileRepository;
use App\Repositories\HkiRepository;
use App\Repositories\PublikasiRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class KaryaMahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    const HKI       = 'hki';
    const PUBLIKASI = 'publikasi';
    private $hkiRepository,$publikasiRepository,$fileRepository;
    public function __construct(HkiRepository $hkiRepository,PublikasiRepository $publikasiRepository,FileRepository $fileRepository)
    {
        Parent::__construct();
        $this->hkiRepository       = $hkiRepository;
        $this->publikasiRepository = $publikasiRepository;
        $this->fileRepository      = $fileRepository;
    }

    public function index()
    {
        $options=[
            'siakad_mhspt_id' => $this->mhspt
        ];
        $this->data['hki'] = $this->hkiRepository->findAll($options);
        $this->data['publikasi'] = $this->publikasiRepository->findAll($options);
        return view('karya-mahasiswa.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
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
    protected function HkiStore(HkiRequest $request){
        $params = $request->validated();
        $BuktiKegiatanParams = [
            'tag'            => 'bukti-hki',
            'jenis_kegiatan' => 10,
            'id_mhspt'       => $this->mhspt
        ];
        $createBuktiKegiatan = array_merge($params,$BuktiKegiatanParams);
        $createFileBukti     = $this->fileRepository->create($createBuktiKegiatan);
        if($createFileBukti){
            $fileParams = $this->fileParams($createFileBukti);
            $params = array_merge($params,$fileParams);
            return $this->hkiRepository->create($params);
        }
        return $createFileBukti;
    }
    protected function PublikasiStore(PublikasiRequest $request){
        $params = $request->validated();
        $BuktiKegiatanParams = [
            'tag'            => 'bukti-publikasi',
            'jenis_kegiatan' => 11,
            'id_mhspt'       => $this->mhspt
        ];
        $createBuktiKegiatan = array_merge($params,$BuktiKegiatanParams);
        $createFileBukti     = $this->fileRepository->create($createBuktiKegiatan);
        if($createFileBukti){
            $fileParams = $this->fileParams($createFileBukti);
            $params     = array_merge($params,$fileParams);
            return $this->publikasiRepository->create($params);
        }
        return $createFileBukti;
    }


    protected function fileParams($files){
        return array(
            'file_kegiatan_id'                    => $files->id_files,
            'file_kegiatan_ref_jenis_kegiatan_id' => $files->ref_jenis_kegiatan_id,
            'siakad_mhspt_id'                     => $this->mhspt
        );
    }

    public function store(Request $request)
    {
        if($request->jenis == SELF::HKI){
            $this->HkiStore($request);
        }

        if($request->jenis == SELF::PUBLIKASI){
            $this->PublikasiStore($request);
        }
        toastr()->success('Berhasil Tambah Data');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($jenis,$id)
    {
        if ($jenis == SELF::HKI) {
            $data['utama']['hki'] = $this->hkiRepository->findById(decrypt($id));
            return view('karya-mahasiswa.show', compact('data'));
        } else if ($jenis == SELF::PUBLIKASI) {
            $data['utama']['publikasi'] = $this->publikasiRepository->findById(decrypt($id));
            return view('karya-mahasiswa.show', compact('data'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($jenis,$id)
    {
        if ($jenis == SELF::HKI) {
            $this->data['data'] = $this->hkiRepository->findById(decrypt($id));
        } else if ($jenis == SELF::PUBLIKASI) {
            $this->data['data'] = $this->publikasiRepository->findById(decrypt($id));
        }
        dd($this->data['data']);
        return view('karya-mahasiswa.edit', $this->data);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->jenis == 'hki') {
            $data = Hki::find(decrypt($id));
            $file = Files::find($data->file_kegiatan_id);
            if (!empty($file)) {
                if (Storage::exists($file->path)) {
                    Storage::delete($file->path);
                    $data->files->delete();
                }
            }
            $data->delete();
            toastr()->success('Berhasil Hapus Data');
        } elseif ($request->jenis == 'publikasi') {
            $data = Publikasi::find(decrypt($id));
            $file = Files::find($data->file_kegiatan_id);
            if (!empty($file)) {
                if (Storage::exists($file->path)) {
                    Storage::delete($file->path);
                    $data->files->delete();
                }
            }

            $data->delete();
            toastr()->success('Berhasil Hapus Data');
        }

        return back();
    }
}
