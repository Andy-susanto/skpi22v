@extends('adminlte::page')
@section('title', 'Daftar Kegiatan')
@section('content_header')
    <div class="row">
        <div class="mb-3 col-12">
            <h1 class="m-0 font-bold text-dark uppercase"><i class="fa fa-bookmark" aria-hidden="true"></i> Daftar Kegiatan
            </h1>
        </div>
    </div>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Kegiatan</th>
                                <th>Masukan Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $data)
                                <tr>
                                    <td>{{ $data->nama }}</td>
                                    <td><a target="__blank" name="" id="" class="btn btn-primary"
                                            href="{{ route('kegiatan.form', $data->id_ref_jenis_kegiatan) }}"
                                            role="button">Isi
                                            Form</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
