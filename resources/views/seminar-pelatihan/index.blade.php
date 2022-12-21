@extends('adminlte::page')

@section('title', 'Seminar Pelatihan')

@section('content_header')
    <div class="row">
        <div class="mb-3 col-12">
            <h1 class="m-0 font-bold text-dark uppercase"><i class="fa fa-bookmark" aria-hidden="true"></i> Seminar Pelatihan
            </h1>
        </div>
        <div class="col-12">
            @if (Auth::user()->siakad_mhspt()->exists())
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead class="bg-gradient-to-r from-lime-500 to-green-500 text-white">
                                <tr>
                                    <th>Bobot Minimum Wajib di Capai</th>
                                    <th>Total Bobot Saat Ini </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ Helper::min_bobot() }}</td>
                                    <td>{{ Helper::hitung_bobot() }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated"
                                                role="progressbar" aria-valuenow="{{ Helper::hitung_bobot('seminar') }}"
                                                aria-valuemin="0" aria-valuemax="100"
                                                style="width: {{ (Helper::hitung_bobot() / Helper::min_bobot()) * 100 }}%">
                                                Proses
                                                Bobot : {{ Helper::hitung_bobot() }}/{{ Helper::min_bobot() }}</div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
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
                        Daftar Seminar Pelatihan</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <form action="{{ route('kegiatan.store') }}" method="post" enctype="multipart/form-data"
                                    id="form-seminar">
                                    <input type="hidden" name="ref_jenis_kegiatan_id"
                                        value="{{ config('kegiatan.SEMINAR') }}">
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
                                                <label for="">Nama Kegiatan</label><span
                                                    class="text-danger">*</span>
                                                <input type="text"
                                                    class="form-control @error('nama') is-invalid @enderror" name="nama"
                                                    id="" aria-describedby="helpId" placeholder="Nama Kegiatan">
                                                @error('nama')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="">Penyelenggara Kegiatan</label><span
                                                    class="text-danger">*</span>
                                                <select
                                                    class="form-control @error('penyelenggara_kegiatan') is-invalid @enderror"
                                                    name="ref_penyelenggara_id" id="penyelenggara" onchange="load_bobot();">
                                                    @forelse(Helper::penyelenggara(2) as $penyelenggara)
                                                        <option value="{{ $penyelenggara->id_ref_penyelenggara }}">
                                                            {{ $penyelenggara->nama }}</option>
                                                    @empty
                                                    @endforelse
                                                </select>
                                                @error('penyelenggara_kegiatan')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="">Tingkat Kegiatan</label><span
                                                    class="text-danger">*</span>
                                                <select class="form-control @error('tingkat_kegiatan') is-invalid @enderror"
                                                    name="ref_tingkat_id" id="tingkat" onchange="load_bobot();">
                                                    @forelse(Helper::tingkat(2) as $tingkat)
                                                        <option value="{{ $tingkat->id_ref_tingkat }}">
                                                            {{ $tingkat->nama }}</option>
                                                    @empty
                                                    @endforelse
                                                </select>
                                                @error('tingkat_kegiatan')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-lg-4">
                                                <label for="">Tanggal Mulai - Selesai Kegiatan</label><span
                                                    class="text-danger">*</span>
                                                <input type="text"
                                                    class="form-control @error('tanggal_kegiatan') is-invalid @enderror"
                                                    name="tanggal_kegiatan" id="tanggal_kegiatan" aria-describedby="helpId"
                                                    placeholder="" value="01/01/2022 - 01/12/2022">
                                                <input type="hidden" name="tgl_mulai" id="tanggal_mulai_kegiatan"
                                                    value="2022-01-01">
                                                <input type="hidden" name="tgl_selesai" id="tanggal_selesai_kegiatan"
                                                    value="2022-12-01">
                                                @error('tanggal_kegiatan')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="">Peran</label><span class="text-danger">*</span>
                                                <select class="form-control @error('peran') is-invalid @enderror"
                                                    name="ref_peran_prestasi_id" id="peran" onchange="load_bobot();">
                                                    @forelse(Helper::prestasi(2) as $peran)
                                                        <option value="{{ $peran->id_ref_peran_prestasi }}">
                                                            {{ $peran->nama }}</option>
                                                    @empty
                                                    @endforelse
                                                </select>
                                                @error('peran')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-lg-4">
                                                <label for="">Dosen Pembimbing</label>
                                                <select
                                                    class="form-control @error('dosen_pembimbing') is-invalid @enderror"
                                                    name="kepeg_pegawai_id" id="dosen_pembimbing">
                                                </select>
                                                @error('dosen_pembimbing')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="">Bukti Kegiatan (Sertifikat)</label><span
                                                    class="text-danger">*</span>
                                                <input type="file"
                                                    class="form-control-file @error('bukti_kegiatan') is-invalid @enderror"
                                                    name="file_id" id="" placeholder=""
                                                    aria-describedby="fileHelpId">
                                                <span class="text-muted italic">File docx,pdf,jpg,png ( Maks. 5MB)</span>
                                                @error('bukti_kegiatan')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="">Bukti Kegiatan (SK/Surat
                                                    Tugas/Undangan/Flyer)</label><span class="text-danger">*</span>
                                                <input type="file"
                                                    class="form-control-file @error('file_sk') is-invalid @enderror"
                                                    name="file_sk_id" id="" placeholder=""
                                                    aria-describedby="fileHelpId">
                                                <span class="text-muted italic">File docx,pdf,jpg,png ( Maks. 5MB)</span>
                                                @error('file_sk')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="">Bobot Nilai Kegiatan</label>
                                                <div id="bobot">0</div>
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
                                            <button type="button" onclick="confirmation('form-seminar')"
                                                class="btn bg-blue-400 text-white hover:bg-cyan-400 btn-md drop-shadow-md"><i
                                                    class="fas fa-save" aria-hidden="true"></i> Kirim Data</button>
                                        </div>
                                    @endif
                                </form>
                            </div>
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
                                                <th>Nama Kegiatan</th>
                                                <th>Tanggal Mulai Kegiatan</th>
                                                <th>Tanggal Selesai Kegiatan</th>
                                                <th>Dosen Pembimbing</th>
                                                <th>Bukti Kegiatan</th>
                                                <th>Status</th>
                                                <th>Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($data as $datas)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ ucwords($datas->relasi->nama) }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($datas->relasi->tgl_mulai)->isoFormat('D MMMM Y') }}
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($datas->relasi->tgl_selesai)->isoFormat('D MMMM Y') }}
                                                    </td>
                                                    <td>
                                                        @if ($datas->relasi->kepeg_pegawai()->exists())
                                                            {{ Helper::nama_gelar($datas->relasi->kepeg_pegawai) }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="list-group">
                                                            <a href="{{ asset('storage/' . $datas->file->path) }}"
                                                                class="list-group-item list-group-item-action"><i
                                                                    class="fa fa-archive" aria-hidden="true"></i> File SK
                                                                / Surat Tugas</a>
                                                            <a href="{{ asset('storage/' . $datas->relasi->file_sk->path) }}"
                                                                class="list-group-item list-group-item-action"><i
                                                                    class="fa fa-book" aria-hidden="true"></i> File
                                                                Sertifikat</a>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if ($datas->validasi == '3')
                                                            <span class="badge badge-warning">
                                                                <i>Menunggu Verifikasi Operator</i></span>
                                                        @elseif($datas->validasi == '1')
                                                            <span class="badge badge-info">
                                                                <i>Menunggu Verifikasi Wakil
                                                                    Dekan</i></span>
                                                        @elseif($datas->validasi == '4')
                                                            <span class="badge badge-success">diValidasi</span>
                                                        @elseif($datas->validasi == '2')
                                                            <span class="badge badge-danger"><i>di Tolak</i></span>
                                                            <p class="italic"> Pesan : {{ $datas->pesan }}</p>
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
                                                                    href="{{ route('kegiatan.lihat', encrypt($datas->id)) }}"><i
                                                                        class="fa fa-info" aria-hidden="true"></i>
                                                                    Detail</a>
                                                                @if (in_array($datas->validasi, ['3', '2']))
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('kegiatan.edit', encrypt($datas->id)) }}"><i
                                                                            class="fas fa-edit" aria-hidden="true"></i>
                                                                        Ubah</a>
                                                                    <a class="dropdown-item" href="#"
                                                                        onclick="destroy('hapusData{{ $datas->id }}')"><i
                                                                            class="fas fa-trash" aria-hidden="true"></i>
                                                                        Hapus
                                                                    </a>
                                                                    <form method="post"
                                                                        action="{{ route('kegiatan.destroy', encrypt($datas->id)) }}"
                                                                        id="hapusData{{ $datas->id }}">
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

@endsection
@include('plugins.select2')
@section('plugins.Datatables', true)
@include('plugins.moment')
@include('plugins.daterangepicker')
@include('plugins.alertify')
@section('js')
    <script>
        $(function() {
            $('#tanggal_kegiatan').daterangepicker({
                opens: 'left',
                startDate: '01 january 2022',
                endDate: '31 december 2022',
                locale: {
                    format: 'DD MMMM YYYY'
                }
            }, function(start, end, label) {
                $('#tanggal_mulai_kegiatan').val(start.format('YYYY-MM-DD'));
                $('#tanggal_selesai_kegiatan').val(end.format('YYYY-MM-DD'));
            });
        });
        $('#table').DataTable({
            responsive: true
        });
        $('#penyelenggara,#tingkat,#peran').select2();
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
                    'jenis_kegiatan': 2,
                    'penyelenggara': $('#penyelenggara').val(),
                    'tingkat': $('#tingkat').val(),
                    'peran': $('#peran').val()
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

        function destroy(id) {
            alertify.confirm("Konfirmasi!", "Hapus data ini ?", function() {
                $('#' + id).submit();
            }, function() {

            })
        }
    </script>
@endsection
