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
@stop
@section('plugins.Datatables', true)
@push('js')
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
