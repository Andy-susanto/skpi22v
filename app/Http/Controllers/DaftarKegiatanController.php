<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DaftarKegiatanController extends Controller
{


    public function index(Request $request)
    {
        $this->authorize('akses-kegiatan-mahasiswa');

        $this->data['unit_kerjas'] = UnitKerja::whereHas('ref_unit', function ($q) {
            $q->where('jenis_unit_kerja_id', 12);
        })->get();

        if ($request->ajax()) {

            $data = Kegiatan::query();
            $fill = $data->with('jenis_kegiatan', 'mhs_pt')
                ->when($request->jenis_kegiatan, function ($q) use ($request) {
                    $q->whereIn('ref_jenis_kegiatan_id', $request->jenis_kegiatan);
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
            // ->whereHas('relasi', function ($qp) use ($request) {
            //     $qp->when($request->tahun, function ($q) use ($request) {
            //         $q->whereIn('tahun', $request->tahun);
            //     });
            // });

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
                ->addColumn("tahun_kegiatan", function ($row) {
                    return $row->relasi->tahun ? date('Y', strtotime($row->relasi->tahun)) : '-';
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


        return view('daftar-kegiatan.index', $this->data);
    }
}
