@extends('adminlte::page')

@section('title', 'Penghargaan Kejuaraan')

@section('content_header')
    <h1 class="m-0 text-dark"><span><a class="btn btn-default btn-sm shadow-sm"
                href="{{ route('kegiatan.form', $data->ref_jenis_kegiatan_id) }}" role="button">Kembali</a></span> Beasiswa
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
                                <td>Nama Kegiatan</td>
                                <td>:</td>
                                <td>{{ $data->relasi->nama }}</td>
                            </tr>
                            @if ($data->relasi->nama_promotor)
                                <tr>
                                    <td>Nama Promotor</td>
                                    <td>:</td>
                                    <td>{{ $data->relasi->nama_promotor }}</td>
                                </tr>
                            @endif
                            @if (method_exists($data->relasi, 'kategori'))
                                <tr>
                                    <td>Kategori</td>
                                    <td>:</td>
                                    <td>{{ $data->relasi->kategori->nama_kategori }}</td>
                                </tr>
                            @endif
                            @if (method_exists($data->relasi, 'cakupan_beasiswa'))
                                <tr>
                                    <td>Cakupan Beasiswa</td>
                                    <td>:</td>
                                    <td>{{ $data->relasi->cakupan_beasiswa->nama }}</td>
                                </tr>
                            @endif
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
