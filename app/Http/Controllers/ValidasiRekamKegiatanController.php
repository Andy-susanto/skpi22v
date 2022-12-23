<?php

namespace App\Http\Controllers;

use App\Models\Hki;
use App\Models\Magang;
use App\Models\Beasiswa;
use App\Models\Kegiatan;
use App\Models\Publikasi;
use App\Models\UnitKerja;
use App\Models\Organisasi;
use Illuminate\Http\Request;
use App\Models\Kewirausahaan;
use App\Models\PenerimaHibah;
use App\Models\KaryaMahasiswa;
use App\Models\SeminarPelatihan;
use App\Models\KemampuanBahasaAsing;
use App\Models\PengabdianMasyarakat;
use App\Models\PenghargaanKejuaraan;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ValidasiRekamKegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $user;
    public function __construct()
    {
        parent::__construct();
    }


    public function index(Request $request)
    {
        $this->authorize('read-validasi-rekam-kegiatan');
        $this->data['unit_kerjas'] = UnitKerja::whereIn('id_unit_kerja_siakad', $this->UnitKerja(Auth::user()))->get();
        if ($request->ajax()) {

            $data = Kegiatan::query();
            $fill = $data->with(['jenis_kegiatan', 'mhs_pt', 'mhs_pt.prodi', 'mhs_pt.mahasiswa'])
                ->when($request->jenis_kegiatan, function ($q) use ($request) {
                    $q->whereIn('ref_jenis_kegiatan_id', $request->jenis_kegiatan);
                })
                ->whereHas('mhs_pt', function ($q) use ($request) {
                    $q->when($request->prodi, function ($qr) use ($request) {
                        $qr->whereIn('id_prodi', $request->prodi);
                    })->when($request->prodi == '', function ($qp) {
                        $qp->FilterUnit();
                    });
                })
                ->when($request->status_validasi, function ($q) use ($request) {
                    $q->whereIn('validasi', $request->status_validasi);
                });
            return DataTables::eloquent($fill)
                ->addIndexColumn()
                ->addColumn("nama_kegiatan", function ($row) {
                    return $row->relasi->nama ?? '';
                })
                ->addColumn("bukti_kegiatan", function ($row) {
                    return view('validasi-rekam-kegiatan.file', compact('row'));
                })
                ->addColumn("validasi", function ($row) {
                    return view('validasi-rekam-kegiatan.status', compact('row'));
                })
                ->addColumn("action", function ($row) {
                    return view('validasi-rekam-kegiatan.aksi', compact('row'));
                })
                ->rawColumns(['action', 'validasi', 'bukti_kegiatan'])
                ->toJson();
        }

        return view('validasi-rekam-kegiatan.index', $this->data);
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
    public function show($id, $jenis, $type)
    {
        $this->authorize('read-validasi-rekam-kegiatan');
        $data = Kegiatan::find($id);
        return view('validasi-rekam-kegiatan.detail', compact('data', 'jenis', 'type'));
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
        $this->authorize('update-validasi-rekam-kegiatan');
        $data = Kegiatan::find($id);
        $data->update([
            'validasi' => '1'
        ]);
        toastr()->success('Berhasil menvalidasi data');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $this->authorize('delete-validasi-rekam-kegiatan');
        $data = Kegiatan::find($id);
        $data->update([
            'validasi' => '2'
        ]);

        toastr()->success('Berhasil menvalidasi data');
        return back();
    }

    public function riwayat_kegiatan(Request $request)
    {
        $this->authorize('read-riwayat-rekam-kegiatan');

        if ($request->ajax()) {
            $data = collect();
            $penghargaan = PenghargaanKejuaraan::with('mhspt')->whereHas('mhspt', function ($qp) {
                $qp->FilterUnit();
            })->when($request->status_validasi, function ($q) use ($request) {
                $q->where('status_validasi', $request->status_validasi);
            })->orderBy('status_validasi', 'asc')->get();

            $penghargaanMap = $penghargaan->map(function ($item) {
                return [
                    'id'             => $item->id_penghargaan_kejuaraan_kompetensi,
                    'nama_mahasiswa' => $item->mhspt->mahasiswa->nama_mahasiswa,
                    'nim'            => $item->mhspt->no_mhs,
                    'prodi'          => $item->mhspt->prodi->nama_prodi,
                    'id_mhspt'       => $item->siakad_mhspt_id,
                    'jenis_kegiatan' => 'penghargaan',
                    'nama_kegiatan'  => $item->nama,
                    'path'           => $item->files->path,
                    'validasi'       => $item->status_validasi,
                    'pesan'          => $item->pesan
                ];
            });

            $data = $data->merge($penghargaanMap);
            $seminar = SeminarPelatihan::with('mhspt')->whereHas('mhspt', function ($qp) {
                $qp->FilterUnit();
            })->when($request->status_validasi, function ($q) use ($request) {
                $q->where('status_validasi', $request->status_validasi);
            })->orderBy('status_validasi', 'asc')->get();

            $seminarMap = $seminar->map(function ($item) {
                return [
                    'id'             => $item->id_seminar_pelatihan_workshop_diklat,
                    'nama_mahasiswa' => $item->mhspt->mahasiswa->nama_mahasiswa,
                    'nim'            => $item->mhspt->no_mhs,
                    'prodi'          => $item->mhspt->prodi->nama_prodi,
                    'jenis_kegiatan' => 'seminar',
                    'id_mhspt'       => $item->siakad_mhspt_id,
                    'nama_kegiatan'  => $item->nama,
                    'path'           => $item->files->path,
                    'validasi'       => $item->status_validasi,
                    'pesan'          => $item->pesan
                ];
            });

            $data = $data->merge($seminarMap);

            $penerimaHibah = PenerimaHibah::with('mhspt')->whereHas('mhspt', function ($qp) {
                $qp->FilterUnit();
            })->when($request->status_validasi, function ($q) use ($request) {
                $q->where('status_validasi', $request->status_validasi);
            })->orderBy('status_validasi', 'asc')->get();

            $penerimaHibahMap = $penerimaHibah->map(function ($item) {
                return [
                    'id'             => $item->id_penerima_hibah_pendanaan,
                    'nama_mahasiswa' => $item->mhspt->mahasiswa->nama_mahasiswa,
                    'nim'            => $item->mhspt->no_mhs,
                    'prodi'          => $item->mhspt->prodi->nama_prodi,
                    'jenis_kegiatan' => 'hibah',
                    'id_mhspt'       => $item->siakad_mhspt_id,
                    'nama_kegiatan'  => $item->nama,
                    'path'           => $item->files->path,
                    'validasi'       => $item->status_validasi,
                    'pesan'          => $item->pesan
                ];
            });
            $data = $data->merge($penerimaHibahMap);

            $pengabdianMasyarakat = PengabdianMasyarakat::with('mhspt')->whereHas('mhspt', function ($qp) {
                $qp->FilterUnit();
            })->when($request->status_validasi, function ($q) use ($request) {
                $q->where('status_validasi', $request->status_validasi);
            })->orderBy('status_validasi', 'asc')->get();

            $pengabdianMasyarakatMap = $pengabdianMasyarakat->map(function ($item) {
                return [
                    'id'             => $item->id_pengabdian_masyarakat,
                    'nama_mahasiswa' => $item->mhspt->mahasiswa->nama_mahasiswa,
                    'nim'            => $item->mhspt->no_mhs,
                    'prodi'          => $item->mhspt->prodi->nama_prodi,
                    'jenis_kegiatan' => 'pengabdian',
                    'id_mhspt'       => $item->siakad_mhspt_id,
                    'nama_kegiatan'  => $item->nama,
                    'path'           => $item->files->path,
                    'validasi'       => $item->status_validasi,
                    'pesan'          => $item->pesan
                ];
            });

            $data = $data->merge($pengabdianMasyarakatMap);
            $organisasi = Organisasi::with('mhspt')->whereHas('mhspt', function ($qp) {
                $qp->FilterUnit();
            })->when($request->status_validasi, function ($q) use ($request) {
                $q->where('status_validasi', $request->status_validasi);
            })->orderBy('status_validasi', 'asc')->get();

            $organisasiMap = $organisasi->map(function ($item) {
                return [
                    'id'             => $item->id_organisasi,
                    'nama_mahasiswa' => $item->mhspt->mahasiswa->nama_mahasiswa,
                    'nim'            => $item->mhspt->no_mhs,
                    'prodi'          => $item->mhspt->prodi->nama_prodi,
                    'jenis_kegiatan' => 'organisasi',
                    'id_mhspt'       => $item->siakad_mhspt_id,
                    'nama_kegiatan'  => $item->nama,
                    'path'           => $item->files->path,
                    'validasi'       => $item->status_validasi,
                    'pesan'          => $item->pesan
                ];
            });

            $data = $data->merge($organisasiMap);

            $magang = Magang::with('mhspt')->whereHas('mhspt', function ($qp) {
                $qp->FilterUnit();
            })->when($request->status_validasi, function ($q) use ($request) {
                $q->where('status_validasi', $request->status_validasi);
            })->orderBy('status_validasi', 'asc')->get();

            $magangMap = $magang->map(function ($item) {
                return [
                    'id'             => $item->id_magang,
                    'nama_mahasiswa' => $item->mhspt->mahasiswa->nama_mahasiswa,
                    'nim'            => $item->mhspt->no_mhs,
                    'prodi'          => $item->mhspt->prodi->nama_prodi,
                    'jenis_kegiatan' => 'magang',
                    'id_mhspt'       => $item->siakad_mhspt_id,
                    'nama_kegiatan'  => $item->nama,
                    'path'           => $item->files->path,
                    'validasi'       => $item->status_validasi,
                    'pesan'          => $item->pesan
                ];
            });

            $data = $data->merge($magangMap);

            $beasiswa = Beasiswa::with('mhspt')->whereHas('mhspt', function ($qp) {
                $qp->FilterUnit();
            })->when($request->status_validasi, function ($q) use ($request) {
                $q->where('status_validasi', $request->status_validasi);
            })->orderBy('status_validasi', 'asc')->get();

            $beasiswaMap = $beasiswa->map(function ($item) {
                return [
                    'id'             => $item->id_beasiswa,
                    'nama_mahasiswa' => $item->mhspt->mahasiswa->nama_mahasiswa,
                    'nim'            => $item->mhspt->no_mhs,
                    'prodi'          => $item->mhspt->prodi->nama_prodi,
                    'jenis_kegiatan' => 'beasiswa',
                    'id_mhspt'       => $item->siakad_mhspt_id,
                    'nama_kegiatan'  => $item->nama,
                    'path'           => $item->files->path,
                    'validasi'       => $item->status_validasi,
                    'pesan'          => $item->pesan
                ];
            });

            $data = $data->merge($beasiswaMap);

            $bahasa = KemampuanBahasaAsing::with('mhspt')->whereHas('mhspt', function ($qp) {
                $qp->FilterUnit();
            })->when($request->status_validasi, function ($q) use ($request) {
                $q->where('status_validasi', $request->status_validasi);
            })->orderBy('status_validasi', 'asc')->get();

            $bahasaMap = $bahasa->map(function ($item) {
                return [
                    'id'             => $item->id_kemampuan_bahasa_asing,
                    'nama_mahasiswa' => $item->mhspt->mahasiswa->nama_mahasiswa,
                    'nim'            => $item->mhspt->no_mhs,
                    'prodi'          => $item->mhspt->prodi->nama_prodi,
                    'jenis_kegiatan' => 'bahasa',
                    'id_mhspt'       => $item->siakad_mhspt_id,
                    'nama_kegiatan'  => $item->bahasa->nama,
                    'path'           => $item->files->path,
                    'validasi'       => $item->status_validasi,
                    'pesan'          => $item->pesan
                ];
            });

            $data = $data->merge($bahasaMap);

            $kewirausahaan = Kewirausahaan::with('mhspt')->whereHas('mhspt', function ($qp) {
                $qp->FilterUnit();
            })->when($request->status_validasi, function ($q) use ($request) {
                $q->where('status_validasi', $request->status_validasi);
            })->orderBy('status_validasi', 'asc')->get();

            $kewirausahaanMap = $kewirausahaan->map(function ($item) {
                return [
                    'id'             => $item->id_kewirausahaan,
                    'nama_mahasiswa' => $item->mhspt->mahasiswa->nama_mahasiswa,
                    'nim'            => $item->mhspt->no_mhs,
                    'prodi'          => $item->mhspt->prodi->nama_prodi,
                    'jenis_kegiatan' => 'kewirausahaan',
                    'id_mhspt'       => $item->siakad_mhspt_id,
                    'nama_kegiatan'  => $item->nama_usaha,
                    'path'           => $item->files->path,
                    'validasi'       => $item->status_validasi,
                    'pesan'          => $item->pesan
                ];
            });

            $data = $data->merge($kewirausahaanMap);

            $hki = Hki::with('mhspt')->whereHas('mhspt', function ($qp) {
                $qp->FilterUnit();
            })->when($request->status_validasi, function ($q) use ($request) {
                $q->where('status_validasi', $request->status_validasi);
            })->orderBy('status_validasi', 'asc')->get();

            $hkiMap = $hki->map(function ($item) {
                return [
                    'id'             => $item->id_hki_mahasiswa,
                    'nama_mahasiswa' => $item->mhspt->mahasiswa->nama_mahasiswa,
                    'nim'            => $item->mhspt->no_mhs,
                    'prodi'          => $item->mhspt->prodi->nama_prodi,
                    'jenis_kegiatan' => 'HKI',
                    'id_mhspt'       => $item->siakad_mhspt_id,
                    'nama_kegiatan'  => $item->nama_hki,
                    'path'           => $item->files->path,
                    'validasi'       => $item->status_validasi,
                    'pesan'          => $item->pesan
                ];
            });

            $data = $data->merge($hkiMap);

            $publikasi = Publikasi::with('mhspt')->whereHas('mhspt', function ($qp) {
                $qp->FilterUnit();
            })->when($request->status_validasi, function ($q) use ($request) {
                $q->where('status_validasi', $request->status_validasi);
            })->orderBy('status_validasi', 'asc')->get();

            $publikasiMap = $publikasi->map(function ($item) {
                return [
                    'id'             => $item->id_publikasi,
                    'nama_mahasiswa' => $item->mhspt->mahasiswa->nama_mahasiswa,
                    'nim'            => $item->mhspt->no_mhs,
                    'prodi'          => $item->mhspt->prodi->nama_prodi,
                    'jenis_kegiatan' => 'publikasi',
                    'id_mhspt'       => $item->siakad_mhspt_id,
                    'nama_kegiatan'  => $item->judul,
                    'path'           => $item->files->path,
                    'validasi'       => $item->status_validasi,
                    'pesan'          => $item->pesan
                ];
            });

            $data = $data->merge($publikasiMap);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn("nama_mahasiswa", function ($row) {
                    return $row['nama_mahasiswa'];
                })
                ->addColumn("nim", function ($row) {
                    return $row['nim'];
                })
                ->addColumn("program_studi", function ($row) {
                    return $row['prodi'];
                })
                ->addColumn("jenis_kegiatan", function ($row) {
                    if ($row['jenis_kegiatan'] == 'penghargaan') {
                        return 'Penghargaan Kejuaraan';
                    } elseif ($row['jenis_kegiatan'] == 'seminar') {
                        return 'Seminar Pelatihan';
                    } elseif ($row['jenis_kegiatan'] == 'hibah') {
                        return 'Penerima Hibah';
                    } elseif ($row['jenis_kegiatan'] == 'pengabdian') {
                        return 'Pengabdian Masyarakat';
                    } elseif ($row['jenis_kegiatan'] == 'organisasi') {
                        return 'Organisasi';
                    } elseif ($row['jenis_kegiatan'] == 'magang') {
                        return 'Magang';
                    } elseif ($row['jenis_kegiatan'] == 'beasiswa') {
                        return 'Beasiswa';
                    } elseif ($row['jenis_kegiatan'] == 'bahasa') {
                        return 'Kemampuan Bahasa Asing';
                    } elseif ($row['jenis_kegiatan'] == 'kewirausahaan') {
                        return 'Kewirausahaan';
                    } elseif ($row['jenis_kegiatan'] == 'karya') {
                        return 'Karya Mahasiswa';
                    }
                })
                ->addColumn("nama_kegiatan", function ($row) {
                    return $row['nama_kegiatan'];
                })
                ->addColumn("bukti_kegiatan", function ($row) {
                    return view('validasi-rekam-kegiatan.file', compact('row'));
                })
                ->addColumn("validasi", function ($row) {
                    return view('validasi-rekam-kegiatan.status', compact('row'));
                })
                ->addColumn("action", function ($row) {
                    return view('validasi-rekam-kegiatan.aksi', compact('row'));
                })
                ->rawColumns(['action', 'validasi', 'bukti_kegiatan'])
                ->toJson();
        }
    }
}
