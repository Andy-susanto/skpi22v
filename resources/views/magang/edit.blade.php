@extends('adminlte::page')
@section('title', 'Ubah Program Magang')
@section('content_header')
    <h1 class="m-0 text-dark"><span><a name="" id="" class="btn btn-default btn-sm"
                href="{{ route('kegiatan.form', $data->ref_jenis_kegiatan_id) }}" role="button"><i class="fa fa-arrow-left"
                    aria-hidden="true"></i>
                Kembali</a></span> Ubah Magang <button type="button" class="btn btn-outline-primary btn-sm"><i
                class="fa fa-info" aria-hidden="true"></i> Detail</button></h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-6 offset-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="font-bold card-title">Ubah Data</h4>
                    {{-- Error validate --}}
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
                    <form action="{{ route('kegiatan.update', encrypt($data->id)) }}" method="post"
                        enctype="multipart/form-data" id="form-seminar">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="">Nama Perusahaan / Industri / Instansi <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama" id=""
                                aria-describedby="helpId" placeholder="" value="{{ $data->relasi->nama }}">
                        </div>
                        <div class="form-group">
                            <label for="">Bergerak di bidang </label><span class="text-danger">*</span>
                            <select class="form-control select" name="ref_bidang_id" id="bidang">
                                @foreach (Helper::bidang() as $loopBidang)
                                    <option value="{{ $loopBidang->id_ref_bidang }}"
                                        {{ $data->relasi->ref_bidang_id == $loopBidang->id_ref_bidang ? 'selected' : '' }}>
                                        {{ $loopBidang->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Divisi</label><span class="text-danger">*</span>
                            <select class="form-control select2" name="ref_divisi_id" id="tingkat">
                                @foreach (Helper::divisi() as $loopDivisi)
                                    <option value="{{ $loopDivisi->id_ref_divisi }}"
                                        {{ $data->relasi->ref_divisi_id == $loopDivisi->id_ref_divisi ? 'selected' : '' }}>
                                        {{ $loopDivisi->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <label for="">Alamat Perusahaan <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="alamat" id="" rows="1" placeholder="Jalan xxxx">{{ $data->relasi->alamat }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Tanggal Mulai - Selesai Kegiatan</label><span class="text-danger">*</span>
                            <input type="text" class="form-control @error('tanggal_kegiatan') is-invalid @enderror"
                                name="tanggal_kegiatan" id="tanggal_kegiatan" aria-describedby="helpId" placeholder=""
                                value="01/01/2022 - 01/12/2022">
                            <input type="hidden" name="tgl_mulai" id="tanggal_mulai_kegiatan"
                                value="{{ $data->tgl_mulai }}">
                            <input type="hidden" name="tgl_selesai" id="tanggal_selesai_kegiatan"
                                value="{{ $data->tgl_selesai }}">
                            @error('tanggal_kegiatan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <label for="">Tugas Utama Magang <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="tugas_utama_magang" id="" rows="1"
                                    placeholder="Tugas Saya sebagai ....">{{ $data->tugas_utama_magang }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Tema / Judul Laporan Akhir Magang</label><span
                                class="text-danger">*</span>
                            <input type="text" class="form-control" name="judul_laporan_akhir" id=""
                                aria-describedby="helpId" placeholder="ex: Pengembangan xxxx"
                                value="{{ $data->relasi->judul_laporan_akhir }}">
                        </div>
                        <div class="form-group">
                            <label for="">Bukti Kegiatan <span class="text-danger">*</span></label>
                            <input type="hidden" name="file_kegiatan_id" value="{{ $data->file_id }}">
                            <input type="file" class="form-control-file" name="file_id" id=""
                                placeholder="" aria-describedby="fileHelpId">
                            <small id="fileHelpId" class="form-text text-muted"><a
                                    href="{{ asset('storage/' . $data->file->path) }}"><i class="fa fa-paperclip"
                                        aria-hidden="true"></i> Bukti Kegiatan</a></small>
                        </div>
                        <div class="form-group">
                            <label for="">Dosen Pembimbing</label>
                            <select class="form-control" name="kepeg_pegawai_id" id="dosen_pembimbing">
                                @if ($data->relasi->kepeg_pegawai()->exists())
                                    <option value="{{ $data->relasi->kepeg_pegawai->id_pegawai }}">
                                        {{ $data->relasi->kepeg_pegawai->nip }} -
                                        {{ Helper::nama_gelar($data->relasi->kepeg_pegawai) }}</option>
                                @endif
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-12 offset-5">
                                <button type="button" onclick="confirmation('form-seminar')"
                                    class="btn btn-outline-primary"><i class="fas fa-save" aria-hidden="true"></i> Simpan
                                    Data</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('plugins.select2')
@include('plugins.moment')
@include('plugins.daterangepicker')
@include('plugins.alertify')
@section('js')
    <script>
        $(function() {
            $('#tanggal_kegiatan').daterangepicker({
                opens: 'left',
                startDate: "{{ \Carbon\Carbon::parse($data->tgl_mulai)->format('d M Y') }}",
                endDate: "{{ \Carbon\Carbon::parse($data->tgl_selesai)->format('d M Y') }}",
                locale: {
                    format: 'DD MMMM YYYY'
                }
            }, function(start, end, label) {
                $('#tanggal_mulai_kegiatan').val(start.format('YYYY-MM-DD'));
                $('#tanggal_selesai_kegiatan').val(end.format('YYYY-MM-DD'));
            });
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
                    'jenis_kegiatan': 2,
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
