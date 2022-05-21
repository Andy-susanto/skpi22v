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
                    <div class="card-header"><a name="" id="" class="btn btn-secondary btn-xs" href="{{route('validasi-rekam-kegiatan.index')}}" role="button"><i class="fa fa-reply" aria-hidden="true"></i> Kembali</a></div>
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
                                    <td>{{\Carbon\Carbon::parse($data->tgl_mulai)->isoFormat('dddd, D MMMM Y')}}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Selesai</th>
                                    <td>:</td>
                                    <td>{{\Carbon\Carbon::parse($data->selesai)->isoFormat('dddd, D MMMM Y')}}</td>
                                </tr>
                                <tr>
                                    <th>Dosen Pembimbing</th>
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
                                    <th>Status Validasi</th>
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
                                        <p class="italic"> Pesan : {{$data->pesan}}</p>
                                    @endif
                                </td>
                                </tr>
                                <tr>
                                    <th>Penyelenggara</th>
                                    <td>:</td>
                                    <td>{{ $data->penyelenggara->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Tingkat</th>
                                    <td>:</td>
                                    <td>{{ $data->tingkat->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Prestasi</th>
                                    <td>:</td>
                                    <td>{{ $data->prestasi->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Download Dokumen</th>
                                    <td>:</td>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div id="sertifikat" style="height: 50vh"></div>
                                                <a href="{{ asset('storage/' . $data->files->path) }}" class="btn btn-sm btn-info text-white"><i
                                                    class="fa fa-paperclip" aria-hidden="true"></i> File Sertifikat</a>
                                            </div>
                                            <div class="col-md-6">
                                                <div id="file-sk" style="height: 50vh"></div>
                                                <a href="{{ asset('storage/' . $data->file_sk->path) }}" class="btn btn-sm btn-info text-white"><i
                                                    class="fa fa-paperclip" aria-hidden="true"></i> File SK</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
@stop
@include('plugins.pspdfkit')
@section('js')
<script>
    PSPDFKit.load({
        container: "#sertifikat",
        document: "{{ asset('storage/' . $data->files->path) }}", // Add the path to your document here.
    })
    .then(function(instance) {
        console.log("PSPDFKit loaded", instance);
    })
    .catch(function(error) {
        console.error(error.message);
    });
</script>
<script>
    PSPDFKit.load({
        container: "#file-sk",
        document: "{{ asset('storage/' . $data->file_sk->path) }}", // Add the path to your document here.
    })
    .then(function(instance) {
        console.log("PSPDFKit loaded", instance);
    })
    .catch(function(error) {
        console.error(error.message);
    });
</script>
@endsection
