@extends('adminlte::page')

@section('title', 'Penerima Hibah')

@section('content_header')
    <h1 class="m-0 text-dark"><span><a name="" id="" class="btn btn-default btn-sm"
                href="{{ route('penerima-hibah.index') }}" role="button"><i class="fa fa-arrow-left"
                    aria-hidden="true"></i> Kembali</a></span> Penerima Hibah Detail <a
            href="{{ route('penerima-hibah.edit', encrypt($data->id_penerima_hibah_pendanaan)) }}"
            class="btn btn-outline-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i> Ubah Data</a></h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td class="text-bold">Nama Kegiatan</td>
                                <td>:</td>
                                <td>{{ $data->nama }}</td>
                            </tr>
                            <tr>
                                <td class="text-bold">Penyelenggara Kegiatan</td>
                                <td>:</td>
                                <td>{{ $data->penyelenggara->nama }}</td>
                            </tr>
                            <tr>
                                <td class="text-bold">Tingkat Kegiatan</td>
                                <td>:</td>
                                <td>{{ $data->tingkat->nama }}</td>
                            </tr>
                            <tr>
                                <td class="text-bold">Tanggal Mulai Kegiatan</td>
                                <td>:</td>
                                <td>{{ \Carbon\Carbon::parse($data->tgl_mulai)->isoFormat('D MMMM Y') }}</td>
                            </tr>
                            <tr>
                                <td class="text-bold">Tanggal Selesai Kegiatan</td>
                                <td>:</td>
                                <td>{{ \Carbon\Carbon::parse($data->tgl_selesai)->isoFormat('D MMMM Y') }}</td>
                            </tr>
                            <tr>
                                <td class="text-bold">Prestasi</td>
                                <td>:</td>
                                <td>{{ $data->prestasi->nama }}</td>
                            </tr>
                            <tr>
                                <td class="text-bold">Bobot Nilai Kegiatan</td>
                                <td>:</td>
                                <td>{{ $data->bobot_nilai->bobot }}</td>
                            </tr>
                            <tr>
                                <td class="text-bold">Dosen Pembimbing</td>
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
                                <td class="text-bold">Bukti Kegiatan
                                </td>
                                <td>:</td>
                                <td>
                                    <a href="{{ asset('storage/' . $data->files->path) }}" class="btn btn-sm btn-info text-white"><i
                                            class="fa fa-paperclip" aria-hidden="true"></i> File Sertifikat</a>
                                    <a href="{{ asset('storage/' . $data->file_sk->path) }}" class="btn btn-sm btn-info text-white"><i
                                            class="fa fa-paperclip" aria-hidden="true"></i> File SK</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
