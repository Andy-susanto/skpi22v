@extends('adminlte::page')
@section('title', 'Validasi Rekam Kegiatan ( Wadek)')
@section('content_header')
    <h1 class="m-0 text-dark font-bold uppercase"><i class="fa fa-bookmark" aria-hidden="true"></i> Validasi Rekam Kegiatan
        (Wadek)</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Tahun Kegiatan</label>
                                <select class="form-control" multiple name="tahun[]" id="tahun" onchange="load_data();">
                                    @php
                                        $tahun_sekarang = date('Y');
                                        $tahun_minimal = $tahun_sekarang - 15;
                                    @endphp
                                    @for ($i = $tahun_minimal; $i <= $tahun_sekarang; $i++)
                                        <option value="{{ $i }}" {{ $i == $tahun_sekarang ? 'selected' : '' }}>
                                            {{ $i }}</option>
                                    @endfor
                                    <option value="">Semua</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Jenis Kegiatan</label>
                                <select class="form-control" multiple name="jenis_kegiatan[]" id="jenis_kegiatan"
                                    onchange="load_data()">
                                    @forelse (Helper::jenis_kegiatan() as $loopJenisKegiatan)
                                        <option value="{{ $loopJenisKegiatan->id_ref_jenis_kegiatan }}">
                                            {{ ucwords($loopJenisKegiatan->nama) }}
                                        </option>
                                    @empty
                                        <option value="">Kosong</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Status Kegiatan</label>
                                <select class="form-control" multiple name="status_validasi[]" id="status_validasi"
                                    onchange="load_data()">
                                    <option value="3">Menunggu Validasi Operator</option>
                                    <option value="1" selected>di Validasi Operator</option>
                                    <option value="4">di Validasi</option>
                                    <option value="2">Tidak di Terima</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Prodi</label>
                                <select class="form-control" multiple name="prodi[]" id="prodi" onchange="load_data()">
                                    @foreach ($unit_kerjas as $unit_kerja)
                                        <option value="{{ $unit_kerja->id_unit_kerja_siakad }}">
                                            {{ $unit_kerja->ref_unit->nama_ref_unit_kerja }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <a name="" onclick="exportExcel();" id="" class="btn btn-success" href="#"
                                role="button"> Export Data To Excel</a>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped table-hover drop-shadow-md shadow-md" id="table">
                        <thead class="bg-gradient-to-r from-cyan-500 to-blue-500 text-white">
                            <tr>
                                <th>#</th>
                                <th>Nama Mahasiswa</th>
                                <th>NIM</th>
                                <th>Program Studi</th>
                                <th>Tahun</th>
                                <th>Jenis Kegiatan</th>
                                <th>Nama Kegiatan / Nama Promotor / Nama Beasiswa / Bahasa / Nama Usaha / Judul Hasil Karya
                                </th>
                                <th>Status</th>
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
@include('plugins.select2')
@section('plugins.Datatables', true)
@include('plugins.alertify')
@push('js')
    <script>
        $(document).ready(function() {
            $('#jenis_kegiatan,#status_kegiatan').select2();
            load_data();
        });

        function load_data() {
            var table = $('#table').DataTable({
                bAutoWidth: false,
                bLengthChange: true,
                iDisplayLength: 10,
                searching: true,
                processing: true,
                serverSide: true,
                bDestroy: true,
                bStateSave: true,
                ajax: {
                    data: {
                        jenis_kegiatan: $('#jenis_kegiatan').val(),
                        status_validasi: $('#status_validasi').val(),
                        prodi: $('#prodi').val(),
                        tahun: $('#tahun').val(),
                    },
                    url: "{{ route('validasi-wadek.index') }}",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama_mahasiswa',
                        name: 'nama_mahasiswa'
                    },
                    {
                        data: 'nim',
                        name: 'nim'
                    },
                    {
                        data: 'program_studi',
                        name: 'program_studi',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'tahun',
                        name: 'tahun',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'jenis_kegiatan',
                        name: 'jenis_kegiatan',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama_kegiatan',
                        name: 'nama_kegiatan'
                    },
                    {
                        data: 'validasi',
                        name: 'validasi',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                responsive: !0,
            });
        }

        function konfirmasi(id, text) {
            alertify.confirm("Konfirmasi!", text, function() {
                $('#' + id).submit();
            }, function() {

            })
        }

        function exportExcel() {
            var tahun = $('#tahun').val();
            var jenis_kegiatan = $('#jenis_kegiatan').val();
            var status_validasi = $('#status_validasi').val();
            var url = "{{ route('exportExcel') }}";
            window.location.href = url + '?tahun=' + tahun + '&id_jenis_kegiatan=' + jenis_kegiatan + '&status_validasi=' +
                status_validasi;
        }

        function tolak(id, text) {
            alertify.prompt('Konfirmasi !!', 'Alasan Penolakan', text, function(evt, value) {
                console.log(value);
                // $('#' + id).submit();
            }, function() {

            });

        }
    </script>
@endpush
