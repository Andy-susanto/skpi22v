@extends('adminlte::page')

@section('title', 'Beasiswa')

@section('content_header')
    <div class="row">
        <div class="mb-3 col-12">
            <h1 class="m-0 font-bold text-dark uppercase"><i class="fa fa-bookmark" aria-hidden="true"></i> Beasiswa</h1>
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
                        aria-controls="nav-profile" aria-selected="false"><i class="fa fa-book" aria-hidden="true"></i>
                        Daftar Beasiswa</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <form action="{{ route('kegiatan.store') }}" method="post" enctype="multipart/form-data"
                                    id="form-beasiswa">
                                    <input type="hidden" name="ref_jenis_kegiatan_id"
                                        value="{{ config('kegiatan.BEASISWA') }}">
                                    <div class="card-header">
                                        <div class="alert alert-warning" role="alert">
                                            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                            <strong>Data yang dimasukan adalah data beasiswa selama masa kuliah. Bukti
                                                kegiatan berupa sertifikat ataupun dokumen lain yang berkaitan dengan
                                                beasiswa tersebut</strong>
                                        </div>
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        @csrf
                                        <div class="form-row">
                                            <div class="form-group col-lg-4">
                                                <label for="">Nama Beasiswa</label><span
                                                    class="text-danger">*</span>
                                                <input type="text" class="form-control" name="nama" id=""
                                                    aria-describedby="helpId" placeholder="Nama Beasiswa">
                                            </div>
                                            <div class="form-group col-lg-8">
                                                <label for="">Nama Perusahaan / Industri / Instansi / Yayasan
                                                    Pemberi
                                                    Beasiswa ( Promotor ) </label><span class="text-danger">*</span>
                                                <input type="text" class="form-control" name="nama_promotor"
                                                    id="" aria-describedby="helpId" placeholder="Nama Promotor">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-lg-4">
                                                <label for="">Kategori Beasiswa </label><span
                                                    class="text-danger">*</span>
                                                <select class="form-control select" name="ref_kategori_id" id="beasiswa">
                                                    @foreach (Helper::kategori(7) as $loopKategori)
                                                        <option value="{{ $loopKategori->id_ref_kategori }}">
                                                            {{ $loopKategori->nama_kategori }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="">Cakupan Beasiswa </label><span
                                                    class="text-danger">*</span>
                                                <select class="form-control select" name="ref_cakupan_beasiswa_id"
                                                    id="cakupan_beasiswa">
                                                    @foreach (Helper::cakupan_beasiswa() as $loopCakupan)
                                                        <option value="{{ $loopCakupan->id_ref_cakupan_beasiswa }}">
                                                            {{ $loopCakupan->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="">Bukti Kegiatan</label><span
                                                    class="text-danger">*</span>
                                                <input type="file" class="form-control-file" name="file"
                                                    id="" placeholder="" aria-describedby="fileHelpId">

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
                                    @if (Auth::user()->siakad_mhspt()->exists())
                                        <div class="text-center mb-2">
                                            <button type="button" onclick="confirmation('form-beasiswa')"
                                                class="btn bg-green-500 btn-success"><i class="fas fa-save"
                                                    aria-hidden="true"></i> Kirim Data</button>
                                        </div>
                                    @endif
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body table-responsive" data-theme="bumblebee">
                                    <table class="table table-bordered table-stripped shadow-sm" id="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama Beasiswa</th>
                                                <th>Nama Promotor / Perusahaan / Instansi Pemberi Beasiswa</th>
                                                <th>Kategori Beasiswa</th>
                                                <th>Cakupan Beasiswa</th>
                                                <th>Status</th>
                                                <th>Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($data as $loopUtama)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $loopUtama->relasi->nama }}</td>
                                                    <td>{{ $loopUtama->relasi->nama_promotor }}</td>
                                                    <td>{{ $loopUtama->relasi->kategori->nama_kategori ?? '-' }}</td>
                                                    <td>{{ $loopUtama->relasi->cakupan_beasiswa->nama ?? '' }}</td>
                                                    <td>
                                                        @if ($loopUtama->validasi == '3')
                                                            <span class="badge badge-warning"><i>Menunggu Verifikasi
                                                                    Operator</i></span>
                                                        @elseif($loopUtama->validasi == '1')
                                                            <span class="badge badge-info"><i>Menunggu Verifikasi Wakil
                                                                    Dekan</i></span>
                                                        @elseif($loopUtama->validasi == '4')
                                                            <span class="badge badge-success">diValidasi</span>
                                                        @elseif($loopUtama->validasi == '2')
                                                            <span class="badge badge-danger"><i>di Tolak</i></span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-info btn-sm dropdown-toggle"
                                                                type="button" id="triggerId" data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="true">
                                                                <i class="fa fa-hourglass-start" aria-hidden="true"></i>
                                                                Proses
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="triggerId">
                                                                <a class="dropdown-item"
                                                                    href="{{ route('kegiatan.lihat', encrypt($loopUtama->id)) }}"><i
                                                                        class="fa fa-info" aria-hidden="true"></i>
                                                                    Detail</a>
                                                                @if (in_array($loopUtama->validasi, ['3', '2']))
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('kegiatan.edit', encrypt($loopUtama->id)) }}"><i
                                                                            class="fas fa-edit" aria-hidden="true"></i>
                                                                        Ubah</a>
                                                                    <a class="dropdown-item" href="#"
                                                                        onclick="destroy('hapusData{{ $loopUtama->id }}')"><i
                                                                            class="fas fa-trash" aria-hidden="true"></i>
                                                                        Hapus
                                                                    </a>
                                                                    <form method="post"
                                                                        action="{{ route('kegiatan.destroy', encrypt($loopUtama->id)) }}"
                                                                        id="hapusData{{ $loopUtama->id }}">
                                                                        <input type="hidden" name="jenis"
                                                                            value="{{ config('kegiatan.BEASISWA') }}">
                                                                        @csrf
                                                                        @method('delete')
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

@endsection
@include('plugins.alertify')
@section('plugins.Datatables', true)
@section('plugins.Select2', true)
@section('js')
    <script>
        $('#table').DataTable({
            responsive: true
        });
        $('#penyelenggara,#tingkat,#prestasi').select2();

        function confirmation(id) {
            alertify.confirm("Konfirmasi!", "Kirim Data ? Pastikan data yang anda isi sudah benar !", function() {
                $('#' + id).submit();
            }, function() {

            })
        }

        function destroy(id) {
            alertify.confirm("Konfirmasi!", "Hapus data ini ?", function() {
                $('#' + id).submit();
            }, function() {

            })
        }
    </script>
@endsection
