@extends('adminlte::page')

@section('title', 'Penerima Hibah')

@section('content_header')
    <h1 class="m-0 text-dark"><span><a name="" id="" class="btn btn-default btn-sm"
                href="{{ route('kegiatan.form', $data->ref_jenis_kegiatan_id) }}" role="button"><i class="fa fa-arrow-left"
                    aria-hidden="true"></i>
                Kembali</a></span> Penerima Hibah Detail <a href="{{ route('kegiatan.edit', encrypt($data->id)) }}"
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
                                <td>{{ $data->relasi->nama }}</td>
                            </tr>
                            <tr>
                                <td class="text-bold">Penyelenggara Kegiatan</td>
                                <td>:</td>
                                <td>{{ $data->relasi->penyelenggara->nama }}</td>
                            </tr>
                            <tr>
                                <td class="text-bold">Tingkat Kegiatan</td>
                                <td>:</td>
                                <td>{{ $data->relasi->tingkat->nama }}</td>
                            </tr>
                            <tr>
                                <td class="text-bold">Tanggal Mulai Kegiatan</td>
                                <td>:</td>
                                <td>{{ \Carbon\Carbon::parse($data->relasi->tgl_mulai)->isoFormat('D MMMM Y') }}</td>
                            </tr>
                            <tr>
                                <td class="text-bold">Tanggal Selesai Kegiatan</td>
                                <td>:</td>
                                <td>{{ \Carbon\Carbon::parse($data->relasi->tgl_selesai)->isoFormat('D MMMM Y') }}</td>
                            </tr>
                            <tr>
                                <td class="text-bold">Prestasi</td>
                                <td>:</td>
                                <td>{{ $data->relasi->prestasi->nama }}</td>
                            </tr>
                            <tr>
                                <td class="text-bold">Bobot Nilai Kegiatan</td>
                                <td>:</td>
                                <td>{{ $data->relasi->bobot_nilai->bobot ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-bold">Dosen Pembimbing</td>
                                <td>:</td>
                                <td>
                                    @if ($data->relasi->kepeg_pegawai()->exists())
                                        {{ $data->relasi->kepeg_pegawai->nip }} -
                                        {{ Helper::nama_gelar($data->relasi->kepeg_pegawai) }}
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
                                    <a href="{{ asset('storage/' . $data->file->path) }}"
                                        class="btn btn-sm btn-info text-white"><i class="fa fa-paperclip"
                                            aria-hidden="true"></i> File Sertifikat</a>
                                    <a href="{{ asset('storage/' . $data->relasi->file_sk->path) }}"
                                        class="btn btn-sm btn-info text-white"><i class="fa fa-paperclip"
                                            aria-hidden="true"></i> File SK</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
