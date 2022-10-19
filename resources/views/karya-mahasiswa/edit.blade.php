@extends('adminlte::page')
@section('title', 'Karya Mahasiswa Edit')
@section('content_header')
    <h1 class="m-0 text-dark"><span><a name="" id="" class="btn btn-default btn-sm"
                href="{{ route('karya-mahasiswa.index') }}" role="button"><i class="fa fa-arrow-left" aria-hidden="true"></i>
                Kembali</a></span> Ubah Karya Mahasiswa <button type="button" class="btn btn-info btn-sm"><i
                class="fa fa-info" aria-hidden="true"></i> Detail</button></h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-6 offset-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="font-bold card-title">Ubah Data</h4>
                </div>
                <div class="card-body">
                    <form
                        action="{{ route('karya-mahasiswa.update', encrypt($data->id_seminar_pelatihan_workshop_diklat)) }}"
                        method="post" enctype="multipart/form-data" id="form-seminar">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="">Nama Kegiatan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama_kegiatan" id=""
                                aria-describedby="helpId" placeholder="" value="{{ $data->judul }}">
                        </div>
                        <div class="form-group">
                            <label for="">Bukti Kegiatan ( File Sertifikat ) <span
                                    class="text-danger">*</span></label>
                            <input type="file" class="form-control-file" name="file" id=""
                                placeholder="" aria-describedby="fileHelpId">
                            <input type="hidden" name="file_bukti_id" value="{{$data->file_bukti_id}}">
                            <small id="fileHelpId" class="form-text text-muted"><a
                                    href="{{ asset('storage/' . $data->files->path) }}"><i class="fa fa-paperclip"
                                        aria-hidden="true"></i> File Sertifikat</a></small>
                        </div>
                        <div class="row">
                            <div class="col-12 offset-5">
                                <button type="button" onclick="confirmation('form-seminar')" class="btn btn-success"><i
                                        class="fas fa-save" aria-hidden="true"></i> Simpan Data</button>
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
