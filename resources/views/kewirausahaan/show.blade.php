@extends('adminlte::page')

@section('title', 'Penghargaan Kejuaraan')

@section('content_header')
    <h1 class="m-0 text-dark"><span><a name="" id="" class="btn btn-default btn-sm"
                href="{{ route('kegiatan.form', $data->ref_jenis_kegiatan_id) }}" role="button">Kembali</a></span>
        Penghargaan
        Kejuaraan
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
                                <td>Nama Usaha</td>
                                <td>:</td>
                                <td>{{ $data->relasi->nama_usaha }}</td>
                            </tr>
                            <tr>
                                <td>Kategori</td>
                                <td>:</td>
                                <td>{{ $data->relasi->kategori->nama_kategori }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Mulai Kegiatan</td>
                                <td>:</td>
                                <td>{{ \Carbon\Carbon::parse($data->relasi->tgl_mulai)->isoFormat('D MMMM Y') }}
                                </td>
                            </tr>
                            <tr>
                                <td>Tanggal Selesai Kegiatan</td>
                                <td>:</td>
                                <td>{{ \Carbon\Carbon::parse($data->relasi->tgl_selesai)->isoFormat('D MMMM Y') }}
                                </td>
                            </tr>
                            <tr>
                                <td>Alamat Usaha</td>
                                <td>:</td>
                                <td>{{ $data->relasi->alamat_usaha }}</td>
                            </tr>
                            <tr>
                                <td>No Izin</td>
                                <td>:</td>
                                <td>{{ $data->relasi->no_izin }}</td>
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
