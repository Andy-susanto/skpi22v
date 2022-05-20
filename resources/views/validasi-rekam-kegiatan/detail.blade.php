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
                                    <canvas id="my_canvas"></canvas>
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
    @endif
@stop
@section('js')
<script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@2.14.305/build/pdf.min.js"></script>
<script>
    pdfjsLib.getDocument({ url: "https://skpi.unja.ac.id/storage/{{$data->files->path}}" }).then(function (pdf) {
        pdf.getPage(1).then(function (page) {
            var scale = 1.5;
            var viewport = page.getViewport({ scale: scale });
            var canvas = document.getElementById('the-canvas');
            var context = canvas.getContext('2d');
            canvas.height = viewport.height;
            canvas.width = viewport.width;
            page.render({
                canvasContext: context,
                viewport: viewport
            });
        });
    });
</script>
@endsection
