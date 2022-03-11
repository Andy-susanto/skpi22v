@extends('adminlte::page')

@section('title', 'Seminar Pelatihan')

@section('content_header')
    <h1 class="m-0 text-dark"><span><a name="" id="" class="btn btn-default btn-sm shadow-sm"
                href="{{ route('seminar-pelatihan.index') }}" role="button">Kembali</a></span> Seminar Pelatihan Detail</h1>
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
                                <td>{{ $data->nama }}</td>
                            </tr>
                            <tr>
                                <td>Penyelenggara Kegiatan</td>
                                <td>:</td>
                                <td>{{ $data->penyelenggara->nama }}</td>
                            </tr>
                            <tr>
                                <td>Tingkat Kegiatan</td>
                                <td>:</td>
                                <td>{{ $data->tingkat->nama }}</td>
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
                                <td>Peran</td>
                                <td>:</td>
                                <td>{{ $data->peran_prestasi->nama }}</td>
                            </tr>
                            <tr>
                                <td>Bobot Nilai Kegiatan</td>
                                <td>:</td>
                                <td>{{ $data->bobot_nilai->bobot }}</td>
                            </tr>
                            <tr>
                                <td>Dosen Pembimbing</td>
                                <td>:</td>
                                <td>
                                    @if ($data->kepeg_pegawai()->exists())
                                        {{ $data->kepeg_pegawai->nip }} - {{ Helper::nama_gelar($data->kepeg_pegawai) }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Bukti Kegiatan</td>
                                <td>:</td>
                                <td>
                                    <div class="list-group">
                                        <a href={{ asset('storage/' . $data->files->path) }} class="list-group-item list-group-item-action"><i class="fa fa-archive" aria-hidden="true"></i> File Sertifikat</a>
                                        <a href="{{asset('storage/'.$data->file_sk->path)}}" class="list-group-item list-group-item-action"><i class="fa fa-book" aria-hidden="true"></i> File SK</a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
