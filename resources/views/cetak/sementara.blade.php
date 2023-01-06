@extends('adminlte::page')
@section('title', 'Cetak Keterangan')
@section('content_header')
    <div class="row">
        <div class="mb-3 col-12">
            <h1 class="m-0 font-bold text-dark uppercase"><i class="fa fa-print" aria-hidden="true"></i> Cetak Surat Keterangan
            </h1>
        </div>
    </div>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover table-bordered" id="table">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama Mahasiswa</th>
                                <th>NIM</th>
                                <th>Prodi</th>
                                <th>Total Bobot</th>
                                <th><i class="fa fa-cogs" aria-hidden="true"></i></th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Hitung Bobot Mahasiswa</div>
                <div class="card-body">
                    <div class="container-fluid">
                        <table class="table table-hover table-stripped" id="listMahasiswa">
                            <thead>
                                <tr>
                                    <th>Nama Mahasiswa</th>
                                    <th>NIM</th>
                                    <th>Prodi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($listMahasiswa->unique('siakad_mhspt_id') as $data)
                                    <tr>
                                        <td>{{ $data->mhs_pt->mahasiswa->nama_mahasiswa }}</td>
                                        <td>{{ $data->mhs_pt->no_mhs }}</td>
                                        <td>{{ $data->mhs_pt->prodi->nama_prodi }}</td>
                                        <td><a name="" id="" class="btn btn-primary btn-sm bg-white"
                                                href="{{ route('hitung.bobot', $data->siakad_mhspt_id) }}"
                                                role="button">Hitung Ulang Bobot</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('plugins.Datatables', true)
@push('js')
    <script>
        $('#listMahasiswa').DataTable()
    </script>
    <script>
        var table = $('#table').DataTable({
            bAutoWidth: false,
            bLengthChange: true,
            iDisplayLength: 10,
            searching: true,
            processing: true,
            serverSide: true,
            bDestroy: true,
            bStateSave: true,
            scrollY: '50vh',
            scrollCollapse: true,
            paging: false,
            ajax: {
                url: "{{ route('cetak-surat-keterangan.index') }}"
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'mhspt.mahasiswa.nama_mahasiswa',
                    name: 'mhspt.mahasiswa.nama_mahasiswa'
                },
                {
                    data: 'mhspt.no_mhs',
                    name: 'mhspt.no_mhs'
                },
                {
                    data: 'mhspt.prodi.nama_prodi',
                    name: 'mhspt.prodi.nama_prodi'
                },
                {
                    data: 'total_bobot',
                    name: 'total_bobot'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        })
    </script>
@endpush
