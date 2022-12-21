@extends('adminlte::page')
@section('title', 'Ubah Kemampuan Bahasa Asing')
@section('content_header')
    <h1 class="m-0 text-dark"><span><a name="" id="" class="btn btn-default btn-sm"
                href="{{ route('kegiatan.form', $data->ref_jenis_kegiatan_id) }}" role="button"><i class="fa fa-arrow-left"
                    aria-hidden="true"></i>
                Kembali</a></span> Ubah Kemampuan Bahasa Asing <button type="button"
            class="btn btn-outline-primary btn-sm"><i class="fa fa-info" aria-hidden="true"></i> Detail</button></h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-6 offset-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="font-bold card-title">Ubah Data</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('kegiatan.update', encrypt($data->id)) }}" method="post"
                        enctype="multipart/form-data" id="form-seminar">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="">Bahasa<span class="text-danger">*</span></label>
                            <select class="form-control" name="ref_bahasa_id" id="bahasa">
                                @forelse (Helper::Bahasa() as $bahasa)
                                    <option value="{{ $bahasa->id_ref_bahasa }}"
                                        {{ $data->relasi->ref_bahasa_id == $bahasa->id_ref_bahasa ? 'selected' : '' }}>
                                        {{ $bahasa->nama }}</option>
                                @empty
                                    <option>Data Tidak ada</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Level Bahasa <span class="text-danger">*</span></label>
                            <select class="form-control" name="ref_level_bahasa_id" id="level_bahasa">
                                @forelse (Helper::level_bahasa() as $level_bahasa)
                                    <option value="{{ $level_bahasa->id_ref_level_bahasa }}"
                                        {{ $data->relasi->ref_level_bahasa_id == $level_bahasa->id_ref_level_bahasa ? 'selected' : '' }}>
                                        {{ $level_bahasa->nama }}</option>
                                @empty
                                    <option>Data Tidak ada</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Jenis Tes <span class="text-danger">*</span></label>
                            <select class="form-control" name="ref_jenis_tes_id" id="jenis_tes">
                                @forelse (Helper::jenis_tes() as $jenis_tes)
                                    <option value="{{ $jenis_tes->id_ref_jenis_tes }}"
                                        {{ $data->relasi->ref_jenis_tes_id == $jenis_tes->id_ref_jenis_tes ? 'selected' : '' }}>
                                        {{ $jenis_tes->nama }}</option>
                                @empty
                                    <option>Data Tidak ada</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Nilai Tes <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nilai_tes" id=""
                                aria-describedby="helpId" placeholder="" value="{{ $data->relasi->nilai_tes }}">
                        </div>
                        <div class="form-group">
                            <label for="">Bukti Kegiatan <span class="text-danger">*</span></label>
                            <input type="hidden" name="file_kegiatan_id" value="{{ $data->file }}">
                            <input type="file" class="form-control-file" name="file_id" id="file_kegiatan" placeholder=""
                                aria-describedby="fileHelpId">
                            <small id="fileHelpId" class="form-text text-muted"><a
                                    href="{{ asset('storage/' . $data->file->path) }}"><i class="fa fa-paperclip"
                                        aria-hidden="true"></i> Bukti File Kegiatan</a></small>
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
        function confirmation(id) {
            alertify.confirm("Konfirmasi!", "Kirim Data ? Pastikan data yang anda isi sudah benar !", function() {
                $('#' + id).submit();
            }, function() {

            })
        }
    </script>
@endsection
