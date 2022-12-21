@extends('adminlte::page')

@section('title', 'Kemampuan Bahasa Asing')

@section('content_header')
    <h1 class="m-0 text-dark"><span><a name="" id="" class="btn btn-default btn-sm"
                href="{{ route('kegiatan.form', $data->ref_jenis_kegiatan_id) }}" role="button">Kembali</a></span> Kemampuan
        Bahasa Asing
        Detail</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td>Bahasa</td>
                                <td>:</td>
                                <td>{{ $data->relasi->bahasa->nama }}</td>
                            </tr>
                            <tr>
                                <td>Level Bahasa</td>
                                <td>:</td>
                                <td>{{ $data->relasi->level_bahasa->nama }}</td>
                            </tr>
                            <tr>
                                <td>Jenis Tes</td>
                                <td>:</td>
                                <td>{{ $data->relasi->jenis_tes->nama }}</td>
                            </tr>
                            <tr>
                                <td>Bukti Kegiatan</td>
                                <td>:</td>
                                <td><a href="{{ asset('storage/' . $data->file->path) }}" class="btn btn-sm btn-info">Lihat
                                        Bukti</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
