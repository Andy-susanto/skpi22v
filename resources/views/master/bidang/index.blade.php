@extends('adminlte::page')
@section('title', 'Master Bidang')
@section('content_header')
    <div class="row">
        <div class="mb-3 col-12">
            <h1 class="m-0 font-bold text-dark"><i class="fa fa-book" aria-hidden="true"></i> Master Bidang</h1>
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
                    <table class="table" id="table-bobot">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Nama Bidang</th>
                                <th><i class="fa fa-cogs" aria-hidden="true"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['pokok'] as $dataBidang)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $dataBidang->nama }}</td>
                                    <td>
                                        <div class="dropdown open">
                                            <button class="btn btn-info btn-sm dropdown-toggle" type="button" id="triggerId"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-tasks" aria-hidden="true"></i> Proses
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="triggerId">
                                                <a class="dropdown-item ubah-data" href="#modalUbah" data-toggle="modal"
                                                    data-update="{{ route('bidang.update', encrypt($dataBidang->id_ref_bidang)) }}"
                                                    data-edit="{{ route('bidang.edit', encrypt($dataBidang->id_ref_bidang)) }}"><i
                                                        class="fa fa-edit" aria-hidden="true"></i> Ubah</a>

                                                <a class="dropdown-item"
                                                    onclick="confirmation('bidang_{{ $dataBidang->id_ref_bidang }}')"><i
                                                        class="fa fa-trash" aria-hidden="true"></i> Hapus
                                                    <form
                                                        action="{{ route('bidang.destroy', encrypt($dataBidang->id_ref_bidang)) }}"
                                                        method="post" id="bidang_{{ $dataBidang->id_ref_bidang }}">
                                                        @csrf
                                                        @method('delete')
                                                    </form>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
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
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa fa-plus-circle" aria-hidden="true"></i> Tambah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('bidang.store') }}" method="post" id="form-kategori">
                        @csrf
                        <div class="form-group">
                            <label for="">Nama Bidang</label>
                            <input type="text" class="form-control" name="nama" id="" aria-describedby="helpId"
                                placeholder="Nama Kategori">
                        </div>
                        <button type="submit" class="btn btn-primary btn-block btn-sm"><i class="fas fa-save"
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
@include('plugins.alertify')
@include('plugins.select2')
@section('js')
    <script>
        $('#table-bobot').DataTable();
        $('.ubah-data').on('click', function() {
            $route_update = $(this).data('update');
            $route_edit = $(this).data('edit');
            $.ajax({
                url: $route_edit,
                beforeSend: function() {
                    $('#modalUbah').find('.konten_form').html(
                        'Mohon Tunggu <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>');
                },
                success: function(data) {
                    $('.form-ubah').attr('action', $route_update);
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
