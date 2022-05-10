@extends('adminlte::page')

@section('title', 'Kemampuan Bahasa Asing')

@section('content_header')
    <div class="row">
        <div class="mb-3 col-12">
            <h1 class="m-0 font-bold text-dark"><i class="fa fa-bookmark" aria-hidden="true"></i> Kemampuan Bahasa Asing</h1>
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
                        Daftar Kemampuan Bahasa Asing</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <form action="{{ route('kemampuan-bahasa-asing.store') }}" method="post"
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
                                            <div class="form-group col-lg-4">
                                                <label for="">Bahasa yang di kuasai </label><span
                                                    class="text-danger">*</span>
                                                <select class="form-control select" name="ref_bahasa_id" id="bidang">
                                                    @foreach (Helper::bahasa() as $loopBahasa)
                                                        <option value="{{$loopBahasa->id_ref_bahasa}}">{{$loopBahasa->nama}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="">Level Penguasaan Bahasa</label><span
                                                    class="text-danger">*</span>
                                                <select class="form-control select" name="ref_level_bahasa_id" id="tingkat">
                                                    @foreach (Helper::level_bahasa() as $loopLevelBahasa)
                                                        <option value="{{$loopLevelBahasa->id_ref_level_bahasa}}">{{$loopLevelBahasa->nama}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="">Jenis Tes</label><span class="text-danger">*</span>
                                                <select class="form-control" name="ref_jenis_tes_id" id="tingkat">
                                                    @foreach (Helper::jenis_tes() as $loopJenisTes)
                                                        <option value="{{$loopJenisTes->id_ref_jenis_tes}}">{{$loopJenisTes->nama}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row">

                                            <div class="form-group col-lg-4">
                                                <label for="">Nilai Tes</label><span class="text-danger">*</span>
                                                <input type="number" class="form-control" name="nilai_tes" id=""
                                                    aria-describedby="helpId" placeholder="Nilai Tes">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="">Bukti Kegiatan</label><span class="text-danger">*</span>
                                                <input type="file" class="form-control-file" name="bukti_kegiatan" id=""
                                                    placeholder="" aria-describedby="fileHelpId">
                                                    <span class="text-muted italic">File docx,pdf,jpg,png ( Maks. 5MB)</span>
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
                                        <button type="button" onclick="confirmation('form-penghargaan')"
                                            class="btn bg-blue-400 text-white hover:bg-cyan-400 btn-md drop-shadow-md"><i
                                                class="fas fa-save" aria-hidden="true"></i> Kirim Data</button>
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
                                <div class="card-body table-responsive">
                                    <table class="table table-bordered table-stripped" id="table">
                                        <thead class="bg-gradient-to-r from-cyan-500 to-blue-500 text-white">
                                            <tr>
                                                <th>#</th>
                                                <th>Bahasa Yang di Kuasai</th>
                                                <th>Level Penguasaan Bahasa</th>
                                                <th>Jenis Tes</th>
                                                <th>Nilai Tes</th>
                                                <th>Status</th>
                                                <th>Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($data['utama'] as $loopUtama)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $loopUtama->bahasa->nama }}</td>
                                                    <td>{{ $loopUtama->level_bahasa->nama}}</td>
                                                    <td>{{ $loopUtama->jenis_tes->nama}}</td>
                                                    <td>{{$loopUtama->nilai_tes}}</td>
                                                    <td>
                                                        @if ($loopUtama->status_validasi == '3')
                                                        <span class="badge badge-warning"><i>Menunggu Verifikasi Operator</i></span>
                                                    @elseif($loopUtama->status_validasi == '1')
                                                        <span class="badge badge-info"><i>Menunggu Verifikasi Wakil Dekan</i></span>
                                                    @elseif($loopUtama->status_validasi == '4')
                                                        <span class="badge badge-success">diValidasi</span>
                                                    @elseif($loopUtama->status_validasi == '2')
                                                        <span class="badge badge-danger"><i>di Tolak</i></span>
                                                        <p class="italic"> Pesan : {{$loopUtama->pesan}}</p>
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
                                                                    href="{{ route('kemampuan-bahasa-asing.show', encrypt($loopUtama->id_kemampuan_bahasa_asing)) }}"><i
                                                                        class="fa fa-info" aria-hidden="true"></i>
                                                                    Detail</a>
                                                                @if (in_array($loopUtama->status_validasi,['3','2']))
                                                                <a class="dropdown-item"
                                                                    href="{{ route('kemampuan-bahasa-asing.edit', encrypt($loopUtama->id_kemampuan_bahasa_asing)) }}"><i
                                                                        class="fas fa-edit" aria-hidden="true"></i>
                                                                    Ubah</a>
                                                                <a class="dropdown-item"
                                                                    href="#" onclick="destroy('hapusData{{$loopUtama->id_kemampuan_bahasa_asing}}')"><i class="fas fa-trash" aria-hidden="true"></i>
                                                                    Hapus
                                                                </a>
                                                                <form method="post" action="{{route('kemampuan-bahasa-asing.destroy',encrypt($loopUtama->id_kemampuan_bahasa_asing))}}" id="hapusData{{$loopUtama->id_kemampuan_bahasa_asing}}">
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
@include('plugins.select2')
@include('plugins.alertify')
@section('plugins.Datatables', true)
@section('js')
    <script>
        $('#table').DataTable({
            responsive: true
        });

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
