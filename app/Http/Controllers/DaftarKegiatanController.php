<?php

namespace App\Http\Controllers;

use App\Models\Magang;
use App\Models\Beasiswa;
use App\Models\Kegiatan;
use App\Models\Publikasi;
use App\Models\Organisasi;
use Illuminate\Http\Request;
use App\Models\Kewirausahaan;
use App\Models\PenerimaHibah;
use App\Models\SeminarPelatihan;
use App\Models\KemampuanBahasaAsing;
use App\Models\PengabdianMasyarakat;
use App\Models\PenghargaanKejuaraan;
use Yajra\DataTables\Facades\DataTables;

class DaftarKegiatanController extends Controller
{


    public function index(Request $request)
    {
        $this->authorize('akses-kegiatan-mahasiswa');
        if ($request->ajax()) {

            $data = Kegiatan::query();
            $fill = $data->with('jenis_kegiatan', 'mhs_pt')
                ->where('ref_jenis_kegiatan_id', $request->id_jenis_kegiatan)
                ->when($request->status_validasi, function ($q) use ($request) {
                    $q->where('validasi', $request->status_validasi);
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
                    return view('validasi-rekam-kegiatan.aksi', compact('row'));
                })
                ->rawColumns(['action', 'validasi', 'bukti_kegiatan'])
                ->toJson();
        }

        return view('daftar-kegiatan.index');
    }
}
