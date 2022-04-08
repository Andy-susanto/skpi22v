@extends('adminlte::page')

@section('title', 'Karya Mahasiswa')

@section('content_header')
    <div class="row">
        <div class="mb-3 col-12">
            <h1 class="m-0 font-bold text-dark uppercase"><i class="fa fa-bookmark" aria-hidden="true"></i> Karya Mahasiswa
            </h1>
        </div>
    </div>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="font-bold nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab"
                        aria-controls="nav-home" aria-selected="true"><i class="fa fa-arrow-right" aria-hidden="true"></i>
                        Mendaftar</a>
                    <a class="font-bold nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab"
                        aria-controls="nav-profile" aria-selected="true"><i class="fa fa-book" aria-hidden="true"></i>
                        Daftar Karya Mahasiswa</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    {{-- <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <form action="{{ route('karya-mahasiswa.store') }}" method="post"
                                    enctype="multipart/form-data" id="form-penghargaan">
                                        @if ($errors->any())
                                        <div class="card-header">
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        @endif
                                    <div class="card-body">
                                        @csrf
                                        <div class="form-row">
                                            <div class="form-group col-4">
                                                <label for="">Judul / Nama Hasil Karya</label><span class="text-danger">*</span>
                                                <input type="text" class="form-control" name="judul_hasil_karya" id=""
                                                    aria-describedby="helpId" placeholder="ex : Aplikasi xxxx">
                                            </div>
                                            <div class="form-group col-4">
                                                <label for="">Kategori hasil karya </label><span
                                                    class="text-danger">*</span>
                                                <select class="form-control select" name="ref_kategori_id">
                                                    @foreach (Helper::kategori(10) as $loopKategori)
                                                        <option value="{{$loopKategori->id_ref_kategori}}">{{$loopKategori->nama_kategori}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-4">
                                                <div class="form-group">
                                                  <label for="">HaKI / Hak Cipta / Paten</label>
                                                  <textarea class="form-control" name="no_hki" id="" rows="1"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-4">
                                                <label for="">Jenis Kegiatan </label><span
                                                    class="text-danger">*</span>
                                                <select class="form-control select" name="ref_jenis_id">
                                                    @foreach (Helper::jenis() as $loopJenis)
                                                        <option value="{{$loopJenis->id_ref_jenis}}">{{$loopJenis->nama}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-4">
                                                <label for="">Bukti Kegiatan</label><span class="text-danger">*</span>
                                                <input type="file" class="form-control-file" name="bukti_kegiatan" id=""
                                                    placeholder="" aria-describedby="fileHelpId">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ml-3 mb-2">
                                        <p class="">Catatan :
                                        <ol class="ml-2 list-decimal text-red">
                                            <li>Tanda * harus di isi</li>
                                        </ol>
                                        </p>
                                    </div>
                                    <div class="text-center mb-2">
                                        <button type="button" onclick="confirmation('form-penghargaan')"
                                            class="btn bg-blue-400 text-white hover:bg-cyan-400 btn-md drop-shadow-md"><i
                                                class="fas fa-save" aria-hidden="true"></i> Kirim Data</button>
                                    </div>
                            </div>
                            </form>
                        </div>
                    </div> --}}
                    <div class="row">
                        <div class="col-12">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab2" role="tablist">
                                    <a class="font-bold nav-link active" id="nav-home-tab" data-toggle="tab"
                                        href="#nav-home2" role="tab">HKI</a>
                                    <a class="font-bold nav-link" id="nav-profile-tab" data-toggle="tab"
                                        href="#nav-profile2" role="tab">Publikasi</a>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-home2" role="tabpanel"
                                    aria-labelledby="nav-home-tab">
                                    @if ($errors->any())
                                        <div class="card-header">
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="card">
                                        <form action="{{ route('karya-mahasiswa.store') }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="card-body">
                                                <input type="hidden" name="jenis" value="hki">
                                                <div class="form-group">
                                                    <label for="">Nama HKI <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="nama_hki" id=""
                                                        aria-describedby="helpId" placeholder="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Nomor Sertifikat <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="nomor_sertifikat" id=""
                                                        aria-describedby="helpId" placeholder="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Tanggal Mulai Berlaku <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" name="tgl_mulai_berlaku" id=""
                                                        aria-describedby="helpId" placeholder="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Tanggal Berakhir <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" name="tgl_berakhir" id=""
                                                        aria-describedby="helpId" placeholder="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Jenis HKI <span class="text-danger">*</span></label>
                                                    <select class="form-control" name="jenis_hki_id" id="">
                                                        @foreach (Helper::jenis_hki() as $jenis_hki)
                                                            <option value="{{ $jenis_hki->id_jenis_hki }}">
                                                                {{ $jenis_hki->nama_jenis_hki }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Jenis Ciptaan <span class="text-danger">*</span></label>
                                                    <select class="form-control" name="jenis_ciptaan_id" id="">
                                                        @foreach (Helper::jenis_ciptaan() as $jenis_ciptaan)
                                                            <option value="{{ $jenis_ciptaan->id_jenis_ciptaan }}">
                                                                {{ $jenis_ciptaan->jenis_ciptaan }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">File Bukti <span class="text-danger">*</span></label>
                                                    <input type="file" class="form-control-file" name="file_bukti"
                                                        placeholder="" aria-describedby="fileHelpId">
                                                        <span class="text-muted italic">File docx,pdf,jpg,png ( Maks. 5MB)</span>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <button type="submit"
                                                    class="btn bg-gradient-to-r from-cyan-500 to-blue-500 hover:to-green-500 rounded-full text-white btn-sm">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-profile2" role="tabpanel"
                                    aria-labelledby="nav-profile-tab">
                                    <form action="{{ route('karya-mahasiswa.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="card">
                                            <div class="card-body">
                                                <input type="hidden" name="jenis" value="publikasi">
                                                <div class="form-group">
                                                    <label for="">Judul Publikasi <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="judul" id=""
                                                        aria-describedby="helpId" placeholder="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Tanggal Terbit <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" name="tgl_terbit" id=""
                                                        aria-describedby="helpId" placeholder="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Penerbit <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="penerbit" id=""
                                                        aria-describedby="helpId" placeholder="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Jenis Publikasi <span class="text-danger">*</span></label>
                                                    <select class="form-control" style="width: 100%" name="jenis_id"
                                                        id="jenis-publikasi">
                                                        @foreach (Helper::jenis_publikasi() as $jenis_publikasi)
                                                            <option value="{{ $jenis_publikasi->id_jenis }}">
                                                                {{ $jenis_publikasi->nama_jenis }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Kategori Capaian <span class="text-danger">*</span></label>
                                                    <select class="form-control" style="width: 100%"
                                                        name="kategori_capaian_id" id="kategori-capaian">
                                                        @foreach (Helper::kategori_capaian() as $kategori_capaian)
                                                            <option value="{{ $kategori_capaian->id_kategori_capaian }}">
                                                                {{ $kategori_capaian->nama_kategori_capaian }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Link Publikasi <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="tautan_eksternal" id=""
                                                        aria-describedby="helpId" placeholder="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">File Bukti <span class="text-danger">*</span></label>
                                                    <input type="file" class="form-control-file" name="bukti" id=""
                                                        placeholder="" aria-describedby="fileHelpId">
                                                        <span class="text-muted italic">File docx,pdf,jpg,png ( Maks. 5MB)</span>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <button type="submit"
                                                    class="btn bg-gradient-to-r from-cyan-500 to-blue-500 hover:to-green-500 rounded-full text-white btn-sm">Simpan</button>
                                            </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <div class="row">
                    <div class="col-md-12">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab3" role="tablist">
                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home3"
                                    role="tab" aria-controls="nav-home" aria-selected="true">HKI</a>
                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile3"
                                    role="tab" aria-controls="nav-profile" aria-selected="false">Publikasi</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home3" role="tabpanel"
                                aria-labelledby="nav-home-tab">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body table-responsive">
                                                <table class="table table-bordered table-stripped" id="table">
                                                    <thead class="bg-gradient-to-r from-cyan-500 to-blue-500 text-white">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Nama HKI</th>
                                                            <th>Nomor Sertifikat</th>
                                                            <th>Tanggal Mulai Berlaku</th>
                                                            <th>Tanggal Berakhir</th>
                                                            <th>Jenis HKI</th>
                                                            <th>Jenis Ciptaan</th>
                                                            <th>File Bukti</th>
                                                            <th>Status</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($data['utama']['hki'] as  $hki)
                                                            <tr>
                                                                <td>{{$loop->iteration}}</td>
                                                                <td>{{ucwords($hki->nama_hki)}}</td>
                                                                <td>{{$hki->nomor_sertifikat}}</td>
                                                                <td>{{\Carbon\Carbon::parse($hki->tgl_mulai_berlaku)->isoFormat('D MMMM Y')}}</td>
                                                                <td>{{\Carbon\Carbon::parse($hki->tgl_berakhir)->isoFormat('D MMMM Y')}}</td>
                                                                <td>{{$hki->jenis_hki->nama_jenis_hki}}</td>
                                                                <td>{{$hki->jenis_ciptaan->jenis_ciptaan}}</td>
                                                                <td><a href="{{asset('storage/'.$hki->files->path)}}">Download File Bukti</a></td>
                                                                <td>
                                                                    @if ($hki->status_validasi == '3')
                                                                    <span class="badge badge-warning"><i>Menunggu Verifikasi Operator</i></span>
                                                                    @elseif($hki->status_validasi == '1')
                                                                        <span class="badge badge-info"><i>Menunggu Verifikasi Wakil Dekan</i></span>
                                                                    @elseif($hki->status_validasi == '4')
                                                                        <span class="badge badge-success">diValidasi</span>
                                                                    @elseif($hki->status_validasi == '2')
                                                                        <span class="badge badge-danger"><i>di Tolak</i></span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-info btn-sm dropdown-toggle"
                                                                            type="button" id="triggerId" data-toggle="dropdown"
                                                                            aria-haspopup="true" aria-expanded="false">
                                                                            Proses
                                                                        </button>
                                                                        <div class="dropdown-menu" aria-labelledby="triggerId">
                                                                            <a class="dropdown-item"
                                                                                href="{{ route('karya-mahasiswa.show', encrypt($hki->id_hki_mahasiswa)) }}"><i
                                                                                    class="fa fa-info" aria-hidden="true"></i>
                                                                                Detail</a>
                                                                            @if (in_array($hki->status_validasi,['3','2']))
                                                                            <a class="dropdown-item"
                                                                                href="{{ route('karya-mahasiswa.edit', encrypt($hki->id_hki_mahasiswa)) }}"><i
                                                                                    class="fas fa-edit" aria-hidden="true"></i>
                                                                                Ubah</a>
                                                                            <a class="dropdown-item"
                                                                                href="#" onclick="destroy('hapusData{{$hki->id_hki_mahasiswa}}')"><i class="fas fa-trash" aria-hidden="true"></i>
                                                                                Hapus
                                                                            </a>
                                                                            <form method="post" action="{{route('karya-mahasiswa.destroy',encrypt($hki->id_hki_mahasiswa))}}" id="hapusData{{$hki->id_hki_mahasiswa}}">
                                                                                @csrf
                                                                                @method('delete')
                                                                                <input type="hidden" name="jenis" value="hki">
                                                                            </form>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @empty

                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-profile3" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body table-responsive">
                                                <table class="table table-bordered table-stripped" id="tabelPublikasi">
                                                    <thead class="bg-gradient-to-r from-cyan-500 to-blue-500 text-white">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Judul Publikasi</th>
                                                            <th>Tanggal Terbit</th>
                                                            <th>Penerbit</th>
                                                            <th>Jenis Publikasi</th>
                                                            <th>Kategori Capaian</th>
                                                            <th>Link Publikasi</th>
                                                            <th>File Bukti</th>
                                                            <th>Status</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($data['utama']['publikasi'] as $publikasi)
                                                            <tr>
                                                                <td>{{$loop->iteration}}</td>
                                                                <td>{{ucwords($publikasi->judul)}}</td>
                                                                <td>{{\Carbon\Carbon::parse($publikasi->tgl_terbit)}}</td>
                                                                <td>{{$publikasi->penerbit}}</td>
                                                                <td>{{$publikasi->jenis_publikasi->nama_jenis}}</td>
                                                                <td>{{$publikasi->kategori_capaian->nama_kategori_capaian}}</td>
                                                                <td>{{$publikasi->tautan_eksternal}}</td>
                                                                <td><a href="{{asset('storage/'.$publikasi->files->path)}}">Download File Bukti</a></td>
                                                                <td>
                                                                    @if ($publikasi->status_validasi == '3')
                                                                    <span class="badge badge-warning"><i>Menunggu Verifikasi Operator</i></span>
                                                                    @elseif($publikasi->status_validasi == '1')
                                                                        <span class="badge badge-info"><i>Menunggu Verifikasi Wakil Dekan</i></span>
                                                                    @elseif($publikasi->status_validasi == '4')
                                                                        <span class="badge badge-success">diValidasi</span>
                                                                    @elseif($publikasi->status_validasi == '2')
                                                                        <span class="badge badge-danger"><i>di Tolak</i></span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-info btn-sm dropdown-toggle"
                                                                            type="button" id="triggerId" data-toggle="dropdown"
                                                                            aria-haspopup="true" aria-expanded="false">
                                                                            Proses
                                                                        </button>
                                                                        <div class="dropdown-menu" aria-labelledby="triggerId">
                                                                            <a class="dropdown-item"
                                                                                href="{{ route('karya-mahasiswa.show', encrypt($publikasi->id_publikasi)) }}"><i
                                                                                    class="fa fa-info" aria-hidden="true"></i>
                                                                                Detail</a>
                                                                            @if (in_array($publikasi->status_validasi,['3','2']))
                                                                            <a class="dropdown-item"
                                                                                href="{{ route('karya-mahasiswa.edit', encrypt($publikasi->id_publikasi)) }}"><i
                                                                                    class="fas fa-edit" aria-hidden="true"></i>
                                                                                Ubah</a>
                                                                            <a class="dropdown-item"
                                                                                href="#" onclick="destroy('hapusData{{$publikasi->id_publikasi}}')"><i class="fas fa-trash" aria-hidden="true"></i>
                                                                                Hapus
                                                                            </a>
                                                                            <form method="post" action="{{route('karya-mahasiswa.destroy',encrypt($publikasi->id_publikasi))}}" id="hapusData{{$publikasi->id_publikasi}}">
                                                                                @csrf
                                                                                @method('delete')
                                                                                <input type="hidden" name="jenis" value="publikasi">
                                                                            </form>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @empty

                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@include('plugins.select2')
@include('plugins.alertify')
@section('plugins.Datatables', true)
@section('js')
    <script>
        $('#table,#tabelPublikasi').DataTable({
            responsive: true
        });
        $('#penyelenggara,#tingkat,#prestasi').select2();
        $("#dosen_pembimbing").select2({
            placeholder: "Cari Dosen Pembimbing..",
            ajax: {
                url: "{{ route('load.dosen') }}",
                dataTyper: "json",
                data: function(param) {
                    var value = {
                        search: param.term,
                    }
                    return value;
                },
                processResults: function(hasil) {

                    return {
                        results: hasil,
                    }
                }
            }
        });

        load_bobot()

        function load_bobot() {
            $.ajax({
                url: "{{ route('fungsi.load-bobot') }}",
                data: {
                    'jenis_kegiatan': 1,
                    'penyelenggara': $('#penyelenggara').val(),
                    'tingkat': $('#tingkat').val(),
                    'prestasi': $('#prestasi').val()
                },
                beforeSend: function() {
                    $('#bobot').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i>')
                },
                success: function(data) {
                    $('#bobot').text(data);
                }
            })
        }

        function confirmation(id) {
            alertify.confirm("Konfirmasi!", "Kirim Data ? Pastikan data yang anda isi sudah benar !", function() {
                $('#' + id).submit();
            }, function() {

            })
        }

        function destroy(id){
            alertify.confirm("Konfirmasi!", "Hapus data ini ?", function() {
                $('#' + id).submit();
            }, function() {

            })
        }
    </script>
@endsection
