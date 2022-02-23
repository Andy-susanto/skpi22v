@extends('adminlte::page')
@section('title', 'Detail Validasi')
@section('content_header')
    <h1>Detail Validasi</h1>
@stop
@section('content')
    @if ($jenis == 'penghargaan')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">Detail Validasi {{ $jenis }}</div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th>Nama</th>
                                    <td>:</td>
                                    <td>{{ $data->mhspt->mahasiswa->nama_mahasiswa }}</td>
                                </tr>
                                <tr>
                                    <th>NIM</th>
                                    <td>:</td>
                                    <td>{{ $data->mhspt->no_mhs }}</td>
                                </tr>
                                <tr>
                                    <th>Program Studi</th>
                                    <td>:</td>
                                    <td>{{$data->mhspt->prodi->nama_prodi}}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Mulai</th>
                                    <td>:</td>
                                    <td>{{\Carbon\Carbon::parse($data->tgl_mulai)->format('d-mmmm-Y')}}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Selesai</th>
                                    <td>:</td>
                                </tr>
                                <tr>
                                    <th>Dosen Pembimbing</th>
                                    <td>:</td>
                                </tr>
                                <tr>
                                    <th>Status Validasi</th>
                                    <td>:</td>
                                </tr>
                                <tr>
                                    <th>Penyelenggara</th>
                                    <td>:</td>
                                </tr>
                                <tr>
                                    <th>Tingkat</th>
                                    <td>:</td>
                                </tr>
                                <tr>
                                    <th>Prestasi</th>
                                    <td>:</td>
                                </tr>
                                <tr>
                                    <th>Download Dokumen</th>
                                    <td>:</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
@stop
