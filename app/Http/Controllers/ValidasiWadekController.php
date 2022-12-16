<?php

namespace App\Http\Controllers;

use DB;
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
use App\Exports\KegiatanExport;
use App\Models\SeminarPelatihan;
use Yajra\DataTables\Facades\DataTables;
use App\Models\KemampuanBahasaAsing;
use App\Models\PengabdianMasyarakat;
use App\Models\PenghargaanKejuaraan;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ValidasiWadekController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('read-validasi-wadek');
        $this->data['unit_kerjas'] = UnitKerja::whereIn('id_unit_kerja_siakad', $this->UnitKerja(Auth::user()))->get();
        if ($request->ajax()) {

            $data = Kegiatan::query();
            $fill = $data->with('jenis_kegiatan', 'mhs_pt')
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
                })
                ->when($request->tahun, function ($q) use ($request) {
                    $q->whereIn('tahun', $request->tahun);
                })
                ->whereHas('mhs_pt', function ($qp) use ($request) {
                    $qp->when($request->prodi, function ($q) use ($request) {
                        $q->whereIn('id_prodi', $request->prodi);
                    })
                        ->when($request->prodi == '', function ($q) {
                            $q->whereIn('id_prodi', $this->data['unit_kerjas']->pluck('id_unit_kerja_siakad')->toArray());
                        });
                });

            return DataTables::eloquent($fill)
                ->addIndexColumn()
                ->addColumn("nama_mahasiswa", function ($row) {
                    return $row->mhs_pt->mahasiswa->nama_mahasiswa;
                })
                ->addColumn("nim", function ($row) {
                    return $row->mhs_pt->no_mhs;
                })
                ->addColumn("program_studi", function ($row) {
                    return $row->mhs_pt->prodi->nama_prodi;
                })
                ->addColumn("jenis_kegiatan", function ($row) {
                    return $row->jenis_kegiatan->nama;
                })
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
                    return view('validasi-wadek.aksi', compact('row'));
                })
                ->rawColumns(['action', 'validasi', 'bukti_kegiatan'])
                ->toJson();
        }


        return view('validasi-wadek.index', $this->data);
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
        $this->authorize('read-validasi-wadek');
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
    public function update($id)
    {
        $this->authorize('update-validasi-wadek');
        $data = Kegiatan::find($id);
        $data->update([
            'validasi' => '4'
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
    public function destroy($id)
    {
        $this->authorize('delete-validasi-wadek');
        $data = Kegiatan::find($id);
        $data->update([
            'validasi' => '2'
        ]);

        toastr()->success('Berhasil menvalidasi data');
        return back();
    }

    public function exportExcel(Request $request)
    {
        $this->authorize('export-excel');
        $data = collect();
        if ($request->id_jenis_kegiatan == 1 || $request->id_jenis_kegiatan == '') {
            $penghargaan = PenghargaanKejuaraan::with('mhspt')->whereHas('mhspt', function ($qp) {
                $qp->FilterUnit();
            })->when($request->status_validasi, function ($q) use ($request) {
                $q->where('status_validasi', $request->status_validasi);
            })->when($request->tahun, function ($q) use ($request) {
                $q->whereYear('tgl_mulai', $request->tahun);
            })->orderBy('status_validasi', 'asc')->get();

            $penghargaanMap = $penghargaan->map(function ($item) {
                return [
                    'nama_mahasiswa' => $item->mhspt->mahasiswa->nama_mahasiswa,
                    'nim'            => $item->mhspt->no_mhs,
                    'tahun'           => date('Y', strtotime($item->tgl_mulai)),
                    'prodi'          => $item->mhspt->prodi->nama_prodi,
                    'jenis_kegiatan' => 'penghargaan',
                    'nama_kegiatan'  => $item->nama,
                ];
            });

            $data = $data->merge($penghargaanMap);
        }

        if ($request->id_jenis_kegiatan == 2 || $request->id_jenis_kegiatan == '') {
            $seminar = SeminarPelatihan::with('mhspt')->whereHas('mhspt', function ($qp) {
                $qp->FilterUnit();
            })->when($request->status_validasi, function ($q) use ($request) {
                $q->where('status_validasi', $request->status_validasi);
            })->when($request->tahun, function ($q) use ($request) {
                $q->whereYear('tgl_mulai', $request->tahun);
            })->orderBy('status_validasi', 'asc')->get();

            $seminarMap = $seminar->map(function ($item) {
                return [
                    'nama_mahasiswa' => $item->mhspt->mahasiswa->nama_mahasiswa,
                    'nim'            => $item->mhspt->no_mhs,
                    'tahun'           => date('Y', strtotime($item->tgl_mulai)) ?? '-',
                    'prodi'          => $item->mhspt->prodi->nama_prodi,
                    'jenis_kegiatan' => 'seminar',
                    'nama_kegiatan'  => $item->nama,
                ];
            });

            $data = $data->merge($seminarMap);
        }

        if ($request->id_jenis_kegiatan == 3 || $request->id_jenis_kegiatan == '') {
            $penerimaHibah = PenerimaHibah::with('mhspt')->whereHas('mhspt', function ($qp) {
                $qp->FilterUnit();
            })->when($request->status_validasi, function ($q) use ($request) {
                $q->where('status_validasi', $request->status_validasi);
            })->when($request->tahun, function ($q) use ($request) {
                $q->whereYear('tgl_mulai', $request->tahun);
            })->orderBy('status_validasi', 'asc')->get();

            $penerimaHibahMap = $penerimaHibah->map(function ($item) {
                return [
                    'nama_mahasiswa' => $item->mhspt->mahasiswa->nama_mahasiswa,
                    'nim'            => $item->mhspt->no_mhs,
                    'tahun'           => date('Y', strtotime($item->tgl_mulai)) ?? '-',
                    'prodi'          => $item->mhspt->prodi->nama_prodi,
                    'jenis_kegiatan' => 'hibah',
                    'nama_kegiatan'  => $item->nama,
                ];
            });
            $data = $data->merge($penerimaHibahMap);
        }

        if ($request->id_jenis_kegiatan == 4 || $request->id_jenis_kegiatan == '') {
            $pengabdianMasyarakat = PengabdianMasyarakat::with('mhspt')->whereHas('mhspt', function ($qp) {
                $qp->FilterUnit();
            })->when($request->status_validasi, function ($q) use ($request) {
                $q->where('status_validasi', $request->status_validasi);
            })->when($request->tahun, function ($q) use ($request) {
                $q->whereYear('tgl_mulai', $request->tahun);
            })->orderBy('status_validasi', 'asc')->get();

            $pengabdianMasyarakatMap = $pengabdianMasyarakat->map(function ($item) {
                return [
                    'nama_mahasiswa' => $item->mhspt->mahasiswa->nama_mahasiswa,
                    'nim'            => $item->mhspt->no_mhs,
                    'tahun'           => date('Y', strtotime($item->tgl_mulai)) ?? '-',
                    'prodi'          => $item->mhspt->prodi->nama_prodi,
                    'jenis_kegiatan' => 'pengabdian',
                    'nama_kegiatan'  => $item->nama,
                ];
            });

            $data = $data->merge($pengabdianMasyarakatMap);
        }

        if ($request->id_jenis_kegiatan == 5 || $request->id_jenis_kegiatan == '') {
            $organisasi = Organisasi::with('mhspt')->whereHas('mhspt', function ($qp) {
                $qp->FilterUnit();
            })->when($request->status_validasi, function ($q) use ($request) {
                $q->where('status_validasi', $request->status_validasi);
            })->when($request->tahun, function ($q) use ($request) {
                $q->whereYear('tgl_mulai', $request->tahun);
            })->orderBy('status_validasi', 'asc')->get();

            $organisasiMap = $organisasi->map(function ($item) {
                return [
                    'nama_mahasiswa' => $item->mhspt->mahasiswa->nama_mahasiswa,
                    'nim'            => $item->mhspt->no_mhs,
                    'tahun'           => date('Y', strtotime($item->tgl_mulai)) ?? '-',
                    'prodi'          => $item->mhspt->prodi->nama_prodi,
                    'jenis_kegiatan' => 'organisasi',
                    'nama_kegiatan'  => $item->nama,
                ];
            });

            $data = $data->merge($organisasiMap);
        }
        if ($request->id_jenis_kegiatan == 6 || $request->id_jenis_kegiatan == '') {
            $magang = Magang::with('mhspt')->whereHas('mhspt', function ($qp) {
                $qp->FilterUnit();
            })->when($request->status_validasi, function ($q) use ($request) {
                $q->where('status_validasi', $request->status_validasi);
            })->when($request->tahun, function ($q) use ($request) {
                $q->whereYear('tgl_mulai', $request->tahun);
            })->orderBy('status_validasi', 'asc')->get();

            $magangMap = $magang->map(function ($item) {
                return [
                    'nama_mahasiswa' => $item->mhspt->mahasiswa->nama_mahasiswa,
                    'nim'            => $item->mhspt->no_mhs,
                    'tahun'           => date('Y', strtotime($item->tgl_mulai)) ?? '-',
                    'prodi'          => $item->mhspt->prodi->nama_prodi,
                    'jenis_kegiatan' => 'magang',
                    'nama_kegiatan'  => $item->nama,
                ];
            });

            $data = $data->merge($magangMap);
        }

        if ($request->id_jenis_kegiatan == 7 || $request->id_jenis_kegiatan == '') {
            $beasiswa = Beasiswa::with('mhspt')->whereHas('mhspt', function ($qp) {
                $qp->FilterUnit();
            })->when($request->status_validasi, function ($q) use ($request) {
                $q->where('status_validasi', $request->status_validasi);
            })->when($request->tahun, function ($q) use ($request) {
                $q->whereYear('tgl_mulai', $request->tahun);
            })->orderBy('status_validasi', 'asc')->get();

            $beasiswaMap = $beasiswa->map(function ($item) {
                return [
                    'nama_mahasiswa' => $item->mhspt->mahasiswa->nama_mahasiswa,
                    'nim'            => $item->mhspt->no_mhs,
                    'tahun'           => date('Y', strtotime($item->tgl_mulai)) ?? '-',
                    'prodi'          => $item->mhspt->prodi->nama_prodi,
                    'jenis_kegiatan' => 'beasiswa',
                    'nama_kegiatan'  => $item->nama,
                ];
            });

            $data = $data->merge($beasiswaMap);
        }

        if ($request->id_jenis_kegiatan == 8 || $request->id_jenis_kegiatan == '') {
            $bahasa = KemampuanBahasaAsing::with('mhspt')->whereHas('mhspt', function ($qp) {
                $qp->FilterUnit();
            })->when($request->status_validasi, function ($q) use ($request) {
                $q->where('status_validasi', $request->status_validasi);
            })->when($request->tahun, function ($q) use ($request) {
                $q->whereYear('tgl_mulai', $request->tahun);
            })->orderBy('status_validasi', 'asc')->get();
            $bahasaMap = $bahasa->map(function ($item) {
                return [
                    'nama_mahasiswa' => $item->mhspt->mahasiswa->nama_mahasiswa,
                    'nim'            => $item->mhspt->no_mhs,
                    'tahun'           => date('Y', strtotime($item->tgl_mulai)) ?? '-',
                    'prodi'          => $item->mhspt->prodi->nama_prodi,
                    'jenis_kegiatan' => 'bahasa',
                    'nama_kegiatan'  => $item->bahasa->nama,
                ];
            });

            $data = $data->merge($bahasaMap);
        }

        if ($request->id_jenis_kegiatan == 9 || $request->id_jenis_kegiatan == '') {
            $kewirausahaan = Kewirausahaan::with('mhspt')->whereHas('mhspt', function ($qp) {
                $qp->FilterUnit();
            })->when($request->status_validasi, function ($q) use ($request) {
                $q->where('status_validasi', $request->status_validasi);
            })->when($request->tahun, function ($q) use ($request) {
                $q->whereYear('tgl_mulai', $request->tahun);
            })->orderBy('status_validasi', 'asc')->get();

            $kewirausahaanMap = $kewirausahaan->map(function ($item) {
                return [
                    'nama_mahasiswa' => $item->mhspt->mahasiswa->nama_mahasiswa,
                    'nim'            => $item->mhspt->no_mhs,
                    'tahun'           => date('Y', strtotime($item->tgl_mulai)) ?? '-',
                    'prodi'          => $item->mhspt->prodi->nama_prodi,
                    'jenis_kegiatan' => 'kewirausahaan',
                    'nama_kegiatan'  => $item->nama_usaha,
                ];
            });

            $data = $data->merge($kewirausahaanMap);
        }

        if ($request->id_jenis_kegiatan == 10 || $request->id_jenis_kegiatan == '') {
            $hki = Hki::with('mhspt')->whereHas('mhspt', function ($qp) {
                $qp->FilterUnit();
            })->when($request->status_validasi, function ($q) use ($request) {
                $q->where('status_validasi', $request->status_validasi);
            })->when($request->tahun, function ($q) use ($request) {
                $q->whereYear('tgl_mulai_berlaku', $request->tahun);
            })->orderBy('status_validasi', 'asc')->get();

            $hkiMap = $hki->map(function ($item) {
                return [
                    'nama_mahasiswa' => $item->mhspt->mahasiswa->nama_mahasiswa,
                    'nim'            => $item->mhspt->no_mhs,
                    'tahun'           => date('Y', strtotime($item->tgl_mulai_berlaku)) ?? '-',
                    'prodi'          => $item->mhspt->prodi->nama_prodi,
                    'jenis_kegiatan' => 'HKI',
                    'nama_kegiatan'  => $item->nama_hki,
                ];
            });

            $data = $data->merge($hkiMap);

            $publikasi = Publikasi::with('mhspt')->whereHas('mhspt', function ($qp) {
                $qp->FilterUnit();
            })->when($request->status_validasi, function ($q) use ($request) {
                $q->where('status_validasi', $request->status_validasi);
            })->when($request->tahun, function ($q) use ($request) {
                $q->whereYear('tgl_terbit', $request->tahun);
            })->orderBy('status_validasi', 'asc')->get();

            $publikasiMap = $publikasi->map(function ($item) {
                return [
                    'nama_mahasiswa' => $item->mhspt->mahasiswa->nama_mahasiswa,
                    'nim'            => $item->mhspt->no_mhs,
                    'tahun'           => date('Y', strtotime($item->tgl_terbit)) ?? '-',
                    'prodi'          => $item->mhspt->prodi->nama_prodi,
                    'jenis_kegiatan' => 'publikasi',
                    'nama_kegiatan'  => $item->judul,
                ];
            });

            $data = $data->merge($publikasiMap);
        }

        return Excel::download(new KegiatanExport($data), 'Export Data Kegiatan SKPI Tahun ' . $request->tahun . '.xlsx');
    }
}
