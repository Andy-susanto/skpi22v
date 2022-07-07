@extends('adminlte::page')

@section('title',__("app.title.validasi.admin"))

@section('content_header')
    <h1 class="m-0 text-dark font-bold"><i class="fa fa-bookmark" aria-hidden="true"></i> {{ucwords(__("app.title.validasi.admin"))}}</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Jenis Kegiatan</label>
                                <select class="form-control" name="" id="jenis_kegiatan" onchange="load_data()">
                                    <option value="" selected>Semua</option>
                                    @forelse (Helper::jenis_kegiatan() as $loopJenisKegiatan)
                                        <option value="{{ $loopJenisKegiatan->id_ref_jenis_kegiatan }}">{{ ucwords($loopJenisKegiatan->nama) }}
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
                                <select class="form-control" name="status_validasi" id="status_validasi" onchange="load_data()">
                                    <option value="3" selected>Menunggu Validasi Operator</option>
                                    <option value="1">Menunggu Validasi Wakil Dekan</option>
                                    <option value="4">di Validasi</option>
                                    <option value="2">Tidak di Terima</option>
                                    <option value="">Semua</option>
                                </select>
                            </div>
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
                                <th>Jenis Kegiatan</th>
                                <th>Nama Kegiatan / Nama Promotor / Nama Beasiswa / Bahasa / Nama Usaha / Judul Hasil Karya</th>
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

    <!-- Modal -->
<div class="modal fade" id="modalTolak" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <form method="post" action="" id="form-tolak-modal">
                @csrf
                @method('delete')
            <div class="modal-body">
                <div class="form-group">
                  <label for="">Alasan Penolakan</label>
                  <textarea class="form-control" name="pesan" id="" rows="4"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">OK</button>
            </div>
            </form>
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

        function tolakModal(id){
            $url = $(id).data('url');
            $('#modalTolak').modal('show');
            $('#form-tolak-modal').attr('action',$url);
        }

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
                scrollY: '50vh',
                scrollCollapse: true,
                paging: false,
                ajax: {
                    data: {
                        id_jenis_kegiatan: $('#jenis_kegiatan').val(),
                        status_validasi: $('#status_validasi').val()
                    },
                    url: "{{ route('validasi-rekam-kegiatan.index') }}",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable:false,searchable:false
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
                        name: 'program_studi'
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
                        orderable:false,searchable:false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable:false,searchable:false
                    }
                ],
                responsive: !0,
            });
        }

        function konfirmasi(id,text) {
            alertify.confirm("Konfirmasi!",text, function() {
                $('#' + id).submit();
            }, function() {

            })
        }
        function tolak(id,text){
            alertify.prompt('Konfirmasi !!','Alasan Penolakan',text,function(evt, value) {
                console.log(value);
                // $('#' + id).submit();
            },function(){

            });

        }
    </script>
@endpush
