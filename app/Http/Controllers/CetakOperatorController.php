<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Magang;
use App\Models\Beasiswa;
use App\Models\Organisasi;
use Illuminate\Http\Request;
use App\Models\Kewirausahaan;
use App\Models\PenerimaHibah;
use App\Models\KaryaMahasiswa;
use App\Models\SeminarPelatihan;
use App\Models\KemampuanBahasaAsing;
use App\Models\PengabdianMasyarakat;
use App\Models\PenghargaanKejuaraan;

class CetakOperatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = collect();
            $penghargaan = PenghargaanKejuaraan::whereHas('mhspt',function($qp){
                $qp->FilterUnit();
            })->where('status_validasi','1')->groupBy('siakad_mhspt_id')->get();

            $penghargaanMap = $penghargaan->map(function($item){
                return [
                    'id'             => $item->id_penghargaan_kejuaraan_kompetensi,
                    'nama_mahasiswa' => $item->mhspt->mahasiswa->nama_mahasiswa,
                    'nim'            => $item->mhspt->no_mhs,
                    'prodi'          => $item->mhspt->prodi->nama_prodi,
                    'jenis_kegiatan' => 'penghargaan',
                    'nama_kegiatan'  => $item->nama,
                    'path'           => $item->files->path,
                    'validasi'       => $item->status_validasi,
                ];
            });

            $data = $data->merge($penghargaanMap);


            $seminar = SeminarPelatihan::whereHas('mhspt',function($qp){
                $qp->FilterUnit();
            })->where('status_validasi','1')->groupBy('siakad_mhspt_id')->get();

            $seminarMap = $seminar->map(function($item){
                return [
                    'id'             => $item->id_seminar_pelatihan_workshop_diklat,
                    'nama_mahasiswa' => $item->mhspt->mahasiswa->nama_mahasiswa,
                    'nim'            => $item->mhspt->no_mhs,
                    'prodi'          => $item->mhspt->prodi->nama_prodi,
                    'jenis_kegiatan' => 'seminar',
                    'nama_kegiatan'  => $item->nama,
                    'path'           => $item->files->path,
                    'validasi'       => $item->status_validasi,
                ];
            });

            $data = $data->merge($seminarMap);

            $penerimaHibah = PenerimaHibah::whereHas('mhspt',function($qp){
                $qp->FilterUnit();
            })->where('status_validasi','1')->groupBy('siakad_mhspt_id')->get();

            $penerimaHibahMap = $penerimaHibah->map(function($item){
                return [
                    'id'             => $item->id_penerima_hibah_pendanaan,
                    'nama_mahasiswa' => $item->mhspt->mahasiswa->nama_mahasiswa,
                    'nim'            => $item->mhspt->no_mhs,
                    'prodi'          => $item->mhspt->prodi->nama_prodi,
                    'jenis_kegiatan' => 'hibah',
                    'nama_kegiatan'  => $item->nama,
                    'path'           => $item->files->path,
                    'validasi'       => $item->status_validasi,
                ];
            });
            $data = $data->merge($penerimaHibahMap);

            $pengabdianMasyarakat = PengabdianMasyarakat::whereHas('mhspt',function($qp){
                $qp->FilterUnit();
            })->where('status_validasi','1')->groupBy('siakad_mhspt_id')->get();

            $pengabdianMasyarakatMap = $pengabdianMasyarakat->map(function($item){
                return [
                    'id'             => $item->id_pengabdian_masyarakat,
                    'nama_mahasiswa' => $item->mhspt->mahasiswa->nama_mahasiswa,
                    'nim'            => $item->mhspt->no_mhs,
                    'prodi'          => $item->mhspt->prodi->nama_prodi,
                    'jenis_kegiatan' => 'pengabdian',
                    'nama_kegiatan'  => $item->nama,
                    'path'           => $item->files->path,
                    'validasi'       => $item->status_validasi,
                ];
            });

            $data = $data->merge($pengabdianMasyarakatMap);

            $organisasi = Organisasi::whereHas('mhspt',function($qp){
                $qp->FilterUnit();
            })->where('status_validasi','1')->groupBy('siakad_mhspt_id')->get();

            $organisasiMap = $organisasi->map(function($item){
                return [
                    'id'             => $item->id_organisasi,
                    'nama_mahasiswa' => $item->mhspt->mahasiswa->nama_mahasiswa,
                    'nim'            => $item->mhspt->no_mhs,
                    'prodi'          => $item->mhspt->prodi->nama_prodi,
                    'jenis_kegiatan' => 'organisasi',
                    'nama_kegiatan'  => $item->nama,
                    'path'           => $item->files->path,
                    'validasi'       => $item->status_validasi,
                ];
            });

            $data = $data->merge($organisasiMap);

            $magang = Magang::whereHas('mhspt',function($qp){
                $qp->FilterUnit();
            })->where('status_validasi','1')->groupBy('siakad_mhspt_id')->get();

            $magangMap = $magang->map(function($item){
                return [
                    'id'             => $item->id_magang,
                    'nama_mahasiswa' => $item->mhspt->mahasiswa->nama_mahasiswa,
                    'nim'            => $item->mhspt->no_mhs,
                    'prodi'          => $item->mhspt->prodi->nama_prodi,
                    'jenis_kegiatan' => 'magang',
                    'nama_kegiatan'  => $item->nama,
                    'path'           => $item->files->path,
                    'validasi'       => $item->status_validasi,
                ];
            });

            $data = $data->merge($magangMap);

            $beasiswa = Beasiswa::whereHas('mhspt',function($qp){
                $qp->FilterUnit();
            })->where('status_validasi','1')->groupBy('siakad_mhspt_id')->get();

            $beasiswaMap = $beasiswa->map(function($item){
                return [
                    'id'             => $item->id_beasiswa,
                    'nama_mahasiswa' => $item->mhspt->mahasiswa->nama_mahasiswa,
                    'nim'            => $item->mhspt->no_mhs,
                    'prodi'          => $item->mhspt->prodi->nama_prodi,
                    'jenis_kegiatan' => 'beasiswa',
                    'nama_kegiatan'  => $item->nama,
                    'path'           => $item->files->path,
                    'validasi'       => $item->status_validasi,
                ];
            });

            $data = $data->merge($beasiswaMap);

            $bahasa = KemampuanBahasaAsing::whereHas('mhspt',function($qp){
                $qp->FilterUnit();
            })->where('status_validasi','asc')->groupBy('siakad_mhspt_id')->get();

            $bahasaMap = $bahasa->map(function($item){
                return [
                    'id'             => $item->id_kemampuan_bahasa_asing,
                    'nama_mahasiswa' => $item->mhspt->mahasiswa->nama_mahasiswa,
                    'nim'            => $item->mhspt->no_mhs,
                    'prodi'          => $item->mhspt->prodi->nama_prodi,
                    'jenis_kegiatan' => 'bahasa',
                    'nama_kegiatan'  => $item->bahasa->nama,
                    'path'           => $item->files->path,
                    'validasi'       => $item->status_validasi,
                ];
            });

            $data = $data->merge($bahasaMap);
            $kewirausahaan = Kewirausahaan::whereHas('mhspt',function($qp){
                $qp->FilterUnit();
            })->where('status_validasi','asc')->groupBy('siakad_mhspt_id')->get();

            $kewirausahaanMap = $kewirausahaan->map(function($item){
                return [
                    'id'             => $item->id_kewirausahaan,
                    'nama_mahasiswa' => $item->mhspt->mahasiswa->nama_mahasiswa,
                    'nim'            => $item->mhspt->no_mhs,
                    'prodi'          => $item->mhspt->prodi->nama_prodi,
                    'jenis_kegiatan' => 'kewirausahaan',
                    'nama_kegiatan'  => $item->nama_usaha,
                    'path'           => $item->files->path,
                    'validasi'       => $item->status_validasi,
                ];
            });

            $data = $data->merge($kewirausahaanMap);

            $karyaMahasiswa = KaryaMahasiswa::whereHas('mhspt',function($qp){
                $qp->FilterUnit();
            })->where('status_validasi','1')->groupBy('siakad_mhspt_id')->get();

            $karyaMahasiswaMap = $karyaMahasiswa->map(function($item){
                return [
                    'id'             => $item->id_karya_mahasiswa,
                    'nama_mahasiswa' => $item->mhspt->mahasiswa->nama_mahasiswa,
                    'nim'            => $item->mhspt->no_mhs,
                    'prodi'          => $item->mhspt->prodi->nama_prodi,
                    'jenis_kegiatan' => 'karya',
                    'nama_kegiatan'  => $item->judul_hasil_karya,
                    'path'           => $item->files->path,
                    'validasi'       => $item->status_validasi,
                ];
            });

            $data = $data->merge($karyaMahasiswaMap);
        return view('cetak-operator.index',compact('data'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $domPdfPath = base_path('vendor/dompdf/dompdf');
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');
        $my_template = new \PhpOffice\PhpWord\TemplateProcessor(public_path('cetak/template.docx'));

        // $my_template->setValue('name', $desc1->name);
        // $my_template->setValue('email', $desc1->email);
        // $my_template->setValue('phone', $desc1->phone);
        // $my_template->setValue('address', $desc1->address);

        try{
            $my_template->saveAs(storage_path('user_1.docx'));
            //Load word file
        $Content = \PhpOffice\PhpWord\IOFactory::load(storage_path('user_1.docx'));

        //Save it into PDF
        $PDFWriter = \PhpOffice\PhpWord\IOFactory::createWriter($Content,'PDF');
        $PDFWriter->save(storage_path('new-result.pdf'));
        }catch (Exception $e){
            //handle exception
        }

        return response()->download(storage_path('new-result.pdf'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
