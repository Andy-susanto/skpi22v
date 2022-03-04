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
                                    <div class="card">
                                        <div class="card-body">
                                            <form action="#">
                                                <div class="form-group">
                                                    <label for="">Nama HKI</label>
                                                    <input type="date" class="form-control" name="" id=""
                                                        aria-describedby="helpId" placeholder="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Nomor Sertifikat</label>
                                                    <input type="text" class="form-control" name="" id=""
                                                        aria-describedby="helpId" placeholder="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Tanggal Mulai Berlaku</label>
                                                    <input type="date" class="form-control" name="" id=""
                                                        aria-describedby="helpId" placeholder="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Tanggal Berakhir</label>
                                                    <input type="date" class="form-control" name="" id=""
                                                        aria-describedby="helpId" placeholder="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Jenis HKI</label>
                                                    <select class="form-control" name="" id="">
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Jenis Ciptaan</label>
                                                    <select class="form-control" name="" id="">
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Tingkat</label>
                                                    <select class="form-control" name="" id="">
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">File Bukti</label>
                                                    <input type="file" class="form-control-file" name="" id=""
                                                        placeholder="" aria-describedby="fileHelpId">
                                                </div>
                                            </form>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit"
                                                class="btn bg-gradient-to-r from-cyan-500 to-blue-500 hover:to-green-500 rounded-full text-white btn-sm">Simpan</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-profile2" role="tabpanel"
                                    aria-labelledby="nav-profile-tab">
                                    <div class="card">
                                        <div class="card-body">
                                            <form action="#">
                                                <div class="form-group">
                                                    <label for="">Nama Publikasi</label>
                                                    <input type="date" class="form-control" name="" id=""
                                                        aria-describedby="helpId" placeholder="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Tanggal Terbit</label>
                                                    <input type="date" class="form-control" name="" id=""
                                                        aria-describedby="helpId" placeholder="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Penerbit</label>
                                                    <input type="text" class="form-control" name="" id=""
                                                        aria-describedby="helpId" placeholder="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Jenis Publikasi</label>
                                                    <select class="form-control" style="width: 100%" name=""
                                                        id="jenis-publikasi">
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Kategori Capaian</label>
                                                    <select class="form-control" style="width: 100%" name=""
                                                        id="kategori-capaian">
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Link Publikasi</label>
                                                    <input type="text" class="form-control" name="" id=""
                                                        aria-describedby="helpId" placeholder="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">File Bukti</label>
                                                    <input type="file" class="form-control-file" name="" id=""
                                                        placeholder="" aria-describedby="fileHelpId">
                                                </div>
                                            </form>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit"
                                                class="btn bg-gradient-to-r from-cyan-500 to-blue-500 hover:to-green-500 rounded-full text-white btn-sm">Simpan</button>
                                        </div>
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
                                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab"
                                        href="#nav-home3" role="tab" aria-controls="nav-home" aria-selected="true">HKI</a>
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
                                                <div class="card-body">
                                                    <table class="table table-bordered table-stripped" id="table">
                                                        <thead
                                                            class="bg-gradient-to-r from-cyan-500 to-blue-500 text-white">
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Nama HKI</th>
                                                                <th>Nomor Sertifikat</th>
                                                                <th>Tanggal Mulai Berlaku</th>
                                                                <th>Tanggal Berakhir</th>
                                                                <th>Jenis HKI</th>
                                                                <th>Jenis Ciptaan</th>
                                                                <th>Tingkat</th>
                                                                <th>File Bukti</th>
                                                                <th>Status</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-profile3" role="tabpanel"
                                    aria-labelledby="nav-profile-tab">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <table class="table table-bordered table-stripped" id="tabelPublikasi">
                                                        <thead
                                                            class="bg-gradient-to-r from-cyan-500 to-blue-500 text-white">
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Nama Publikasi</th>
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
            $('#table,#tabelPublikasi').DataTable();
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
        </script>
    @endsection
