@extends('adminlte::page')
@section('title', 'Master Bobot Nilai')
@section('content_header')
    <div class="row">
        <div class="mb-3 col-12">
            <h1 class="m-0 font-bold text-dark"><i class="fa fa-book" aria-hidden="true"></i> Master Bobot Nilai</h1>
        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                @if ($errors->any())
                    <div class="card-header">
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                <div class="card-body">
                    <button type="button" data-toggle="modal" data-target="#modalTambah"
                        class="mb-2 btn btn-outline-primary btn-sm"><i class="fa fa-plus-circle" aria-hidden="true"></i>
                        Tambah Data</button>
                    <div class="mt-2 mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Jenis Kegiatan</label>
                                    <select class="form-control" name="" id="jenis_kegiatan" onchange="load_data()">
                                        <option value="">Semua</option>
                                        @foreach (Helper::jenis_kegiatan() as $jenis_kegiatan)
                                            <option value="{{ $jenis_kegiatan->id_ref_jenis_kegiatan }}">{{ $jenis_kegiatan->nama }}</option>
                                        @endforeach
                                    </select>
                                  </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Penyelenggara</label>
                                    <select class="form-control" name="" id="penyelenggara" onchange="load_data()">
                                        <option value="">Semua</option>
                                        @foreach (Helper::penyelenggara() as $penyelenggara)
                                            <option value="{{ $penyelenggara->id_ref_penyelenggara }}">{{ $penyelenggara->nama }}</option>
                                        @endforeach
                                    </select>
                                  </div>
                            </div>
                        </div>
                    </div>
                    <table class="table" id="table-bobot">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Jenis Kegiatan</th>
                                <th>Kategori</th>
                                <th>Penyelenggara</th>
                                <th>Tingkat</th>
                                <th>Prestasi</th>
                                <th>Bobot</th>
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

    <!-- Modal  Tambah-->
    <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-to-r from-cyan-500 to-blue-500">
                    <h5 class="modal-title text-white"><i class="fa fa-plus-circle" aria-hidden="true"></i> Tambah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('bobot-nilai.store') }}" method="post" id="form-bobot-nilai">
                        @csrf
                        <div class="form-group">
                            <label for="">Jenis Kegiatan</label>
                            <select class="form-control " style="width: 100%" name="ref_jenis_kegiatan_id" required>
                                @forelse (Helper::jenis_kegiatan() as $jenis_kegiatan)
                                    <option value="{{ $jenis_kegiatan->id_ref_jenis_kegiatan }}">
                                        {{ $jenis_kegiatan->nama }}
                                    </option>
                                @empty
                                    <option>Tidak Ada Data</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Penyelenggara</label>
                            <select class="form-control" name="ref_penyelenggara_id" id=""  style="width: 100%" required>
                                @forelse (Helper::penyelenggara() as $penyelenggara)
                                    <option value="{{ $penyelenggara->id_ref_penyelenggara }}">
                                        {{ $penyelenggara->nama }}
                                    </option>
                                @empty
                                    <option>Tidak Ada Data</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Tingkat</label>
                            <select class="form-control" name="ref_tingkat_id" id="" style="width: 100%" required>
                                @forelse (Helper::tingkat() as $tingkat)
                                    <option value="{{ $tingkat->id_ref_tingkat }}">{{ $tingkat->nama }}</option>
                                @empty
                                    <option>Tidak Ada Data</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Prestasi</label>
                            <select class="form-control" name="ref_peran_prestasi_id" id="" style="width: 100%" required>
                                @forelse (Helper::prestasi() as $prestasi)
                                    <option value="{{ $prestasi->id_ref_peran_prestasi }}">{{ $prestasi->nama }}
                                    </option>
                                @empty
                                    <option>Tidak Ada Data</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Kategori</label>
                            <select class="form-control" name="ref_kategori_id" id="" style="width: 100%" required>
                                @forelse (Helper::kategori() as $kategori)
                                    <option value="{{ $kategori->id_ref_kategori }}">{{ $kategori->nama_kategori }}
                                    </option>
                                @empty
                                    <option>Tidak Ada Data</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Bobot</label>
                            <input type="number" class="form-control" name="bobot" id="" aria-describedby="helpId"
                                placeholder="Isi Bobot Nilai" required>
                        </div>
                        <button type="submit" class="btn bg-blue-400 btn-block btn-sm"><i class="fas fa-save"
                                aria-hidden="true"></i> Simpan Data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalUbah" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa fa-edit" aria-hidden="true"></i> Ubah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" class="form-ubah">
                        @csrf
                        @method('put')
                        <div class="konten_form">

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('plugins.Datatables', true)
@include('plugins.select2')
@include('plugins.alertify')
@section('js')
    <script>
         function load_data(){
            var table = $('#table-bobot').DataTable({
                bAutoWidth: false,
                bLengthChange: true,
                iDisplayLength: 20,
                searching: true,
                processing: true,
                serverSide: true,
                bDestroy: true,
                bStateSave: true,
                ajax: {
                    data: {
                        jenis_kegiatan: $('#jenis_kegiatan').val(),
                        penyelenggara: $('#penyelenggara').val()
                    },
                    url: "{{ route('bobot-nilai.index') }}",
                },
                columns:[{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable:false,searchable:false
                },
                    {
                        data:'jenis_kegiatan',
                        name:'jenis_kegiatan'
                    },
                    {
                        data:'kategori',
                        name:'kategori'
                    },
                    {
                        data:'penyelenggara',
                        name:'penyelenggara'
                    },
                    {
                        data:'tingkat',
                        name:'tingkat'
                    },
                    {
                        data:'prestasi',
                        name:'prestasi'
                    },
                    {
                        data:'bobot',
                        name:'bobot'
                    },
                    {
                        data:'aksi',
                        name:'aksi',
                        orderable:false,searchable:false
                    }
            ],
            aLengthMenu: [
                    [10, 15, 25, 35, 50, 100, -1],
                    [10, 15, 25, 35, 50, 100, "All"]
                ],
                responsive: !0,
                drawCallback: function() {
                    this.api().state.clear();
                }
            })
        }
        $(document).ready(function(){
            $('#jenis_kegiatan,#penyelenggara').select2('data', null, false);
            load_data();
        });


        $('#jenis_kegiatan').select2({
            dropdownParent : $('#modalTambah')
        });
        $('.ubah-data').on('click',function(){
            $route_update = $(this).data('update');
            $route_edit   = $(this).data('edit');
            $.ajax({
                url : $route_edit,
                beforeSend:function(){
                    $('#modalUbah').find('.konten_form').html('Mohon Tunggu <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>');
                },
                success:function(data){
                    $('.form-ubah').attr('action',$route_update);
                    $('#modalUbah').find('.konten_form').html(data);
                }
            });
        })
        function confirmation(id) {
            alertify.confirm("Konfirmasi !", "Anda yakin ini menghapus data ini ?", function() {
                $('#' + id).submit();
            }, function() {

            })
        }
    </script>
@endsection
