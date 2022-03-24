@extends('adminlte::page')

@section('title', 'Magang')

@section('content_header')
    <h1 class="m-0 text-dark"><span><a name="" id="" class="btn btn-default btn-sm"
                href="{{ route('magang.index') }}" role="button">Kembali</a></span> Magang
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
                                <td>Nama Tempat Magang</td>
                                <td>:</td>
                                <td>{{ $data->nama }}</td>
                            </tr>
                            <tr>
                                <td>Alamat Tempat Magang</td>
                                <td>:</td>
                                <td>{{ $data->alamat }}</td>
                            </tr>
                            <tr>
                                <td>Bidang</td>
                                <td>:</td>
                                <td>{{ $data->bidang->nama }}</td>
                            </tr>
                            <tr>
                                <td>Divisi</td>
                                <td>:</td>
                                <td>{{ $data->divisi->nama }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Mulai Kegiatan</td>
                                <td>:</td>
                                <td>{{ \Carbon\Carbon::parse($data->tgl_mulai)->isoFormat('D MMMM Y') }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Selesai Kegiatan</td>
                                <td>:</td>
                                <td>{{ \Carbon\Carbon::parse($data->tgl_selesai)->isoFormat('D MMMM Y') }}</td>
                            </tr>
                            <tr>
                                <td>Dosen Pembimbing</td>
                                <td>:</td>
                                <td>{{ $data->kepeg_pegawai->nip ?? '' }} - {{ Helper::nama_gelar($data->kepeg_pegawai) }}
                                </td>
                            </tr>
                            <tr>
                                <td>Bukti Kegiatan</td>
                                <td>:</td>
                                <td><a href="{{ asset('storage/' . $data->files->path) }}" class="btn btn-sm btn-info">Lihat
                                        Bukti</a></td>
                            </tr>
                            <tr>
                                <td>Status Validasi</td>
                                <td>:</td>
                                <td>
                                    @if ($data->status_validasi == '3')
                                        <span class="badge badge-warning"><i>Menunggu Verifikasi
                                                Operator</i></span>
                                    @elseif($data->status_validasi == '1')
                                        <span class="badge badge-info"><i>Menunggu Verifikasi Wakil
                                                Dekan</i></span>
                                    @elseif($data->status_validasi == '4')
                                        <span class="badge badge-success">diValidasi</span>
                                    @elseif($data->status_validasi == '2')
                                        <span class="badge badge-danger"><i>di Tolak</i></span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
