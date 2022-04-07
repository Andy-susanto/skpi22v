@extends('adminlte::page')
@section('title', 'Ubah Pengabdian Masyarakat')
@section('content_header')
    <h1 class="m-0 text-dark"><span><a name="" id="" class="btn btn-default btn-sm"
                href="{{ route('pengabdian-masyarakat.index') }}" role="button"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</a></span> Ubah Pengabdian Masyarakat <button type="button" class="btn btn-outline-primary btn-sm"><i class="fa fa-info" aria-hidden="true"></i> Detail</button></h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-6 offset-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="font-bold card-title">Ubah Data</h4>
                </div>
                <div class="card-body">
                    <form action="{{route('pengabdian-masyarakat.update',encrypt($data['utama']->id_pengabdian_masyarakat))}}" method="post" enctype="multipart/form-data" id="form-pengabdian-masyarakat">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="">Nama Kegiatan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama_kegiatan" id="" aria-describedby="helpId"
                                placeholder="" value="{{ $data['utama']->nama }}">
                        </div>
                        <div class="form-group">
                            <label for="">Penyelenggara Kegiatan <span class="text-danger">*</span></label>
                            <select class="form-control" name="penyelenggara" id="penyelenggara" onchange="load_bobot()">
                                @forelse (Helper::penyelenggara(4) as $penyelenggara)
                                    <option value="{{ $penyelenggara->id_ref_penyelenggara }}"
                                        {{ $data['utama']->penyelenggara->id_ref_penyelenggara == $penyelenggara->id_ref_penyelenggara ? 'selected' : '' }}>
                                        {{ $penyelenggara->nama }}</option>
                                @empty
                                    <option>Data Tidak ada</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Tingkat Kegiatan <span class="text-danger">*</span></label>
                            <select class="form-control" name="tingkat" id="tingkat" onchange="load_bobot()">
                                @forelse (Helper::tingkat(4) as $tingkat)
                                    <option value="{{ $tingkat->id_ref_tingkat }}"
                                        {{ $data['utama']->tingkat->id_ref_tingkat == $tingkat->id_ref_tingkat ? 'selected' : '' }}>
                                        {{ $tingkat->nama }}</option>
                                @empty
                                    <option>Data Tidak ada</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Peran <span class="text-danger">*</span></label>
                            <select class="form-control" name="prestasi" id="prestasi" onchange="load_bobot()">
                                @forelse (Helper::prestasi(4) as $prestasi)
                                    <option value="{{ $prestasi->id_ref_peran_prestasi }}"
                                        {{ $data['utama']->prestasi->id_ref_peran_prestasi == $prestasi->id_ref_peran_prestasi ? 'selected' : '' }}>
                                        {{ $prestasi->nama }}</option>
                                @empty
                                    <option>Data Tidak ada</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Tanggal Mulai - Selesai Kegiatan</label><span
                                class="text-danger">*</span>
                            <input type="text"
                                class="form-control @error('tanggal_kegiatan') is-invalid @enderror"
                                name="tanggal_kegiatan" id="tanggal_kegiatan" aria-describedby="helpId"
                                placeholder="" value="01/01/2022 - 01/12/2022">
                            <input type="hidden" name="tanggal_mulai_kegiatan" id="tanggal_mulai_kegiatan"  value="{{$data['utama']->tgl_mulai}}">
                            <input type="hidden" name="tanggal_selesai_kegiatan" id="tanggal_selesai_kegiatan" value="{{$data['utama']->tgl_selesai}}">
                            @error('tanggal_kegiatan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                          <label for="">Bukti Kegiatan ( File Sertifikat ) <span class="text-danger">*</span></label>
                          <input type="file" class="form-control-file" name="bukti_kegiatan" id="" placeholder="" aria-describedby="fileHelpId">
                          <small id="fileHelpId" class="form-text text-muted"><a href="{{asset('storage/'.$data['utama']->files->path)}}"><i class="fa fa-paperclip" aria-hidden="true"></i> File Sertifikat</a></small>
                        </div>
                        <div class="form-group">
                          <label for="">Bukti Kegiatan ( File SK ) <span class="text-danger">*</span></label>
                          <input type="file" class="form-control-file" name="file_sk" id="" placeholder="" aria-describedby="fileHelpId">
                          <small id="fileHelpId" class="form-text text-muted"><a href="{{asset('storage/'.$data['utama']->file_sk->path)}}"><i class="fa fa-paperclip" aria-hidden="true"></i> File SK</a></small>
                        </div>
                        <div class="form-group">
                            <label for="">Dosen Pembimbing</label>
                            <select class="form-control" name="dosen_pembimbing"
                                id="dosen_pembimbing">
                                @if ($data['utama']->kepeg_pegawai()->exists())
                                <option value="{{$data['utama']->kepeg_pegawai->id_pegawai}}">{{$data['utama']->kepeg_pegawai->nip}} - {{Helper::nama_gelar($data['utama']->kepeg_pegawai)}}</option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Bobot Nilai Kegiatan</label>
                            <div id="bobot"></div>
                        </div>
                        <div class="row">
                            <div class="col-12 offset-5">
                                <button type="button" onclick="confirmation('form-pengabdian-masyarakat')" class="btn btn-outline-primary"><i class="fas fa-save" aria-hidden="true"></i> Simpan Data</button>
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
                startDate: "{{\Carbon\Carbon::parse($data['utama']->tgl_mulai)->format('d M Y')}}",
                endDate: "{{\Carbon\Carbon::parse($data['utama']->tgl_selesai)->format('d M Y')}}",
                locale:{
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
                    'jenis_kegiatan': 4,
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
