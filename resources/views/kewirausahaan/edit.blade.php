@extends('adminlte::page')
@section('title','Ubah Kewirausahaan')
@section('content_header')
    <h1 class="m-0 text-dark"><span><a name="" id="" class="btn btn-default btn-sm"
    href="{{ route('kewirausahaan.index') }}" role="button"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</a></span> Ubah Kewirausahaan <button type="button" class="btn btn-outline-primary btn-sm"><i class="fa fa-info" aria-hidden="true"></i> Detail</button></h1>
@stop
@section('content')
<div class="row">
    <div class="col-6 offset-3">
        <div class="card">
            <div class="card-header">
                <h4 class="font-bold card-title">Ubah Data</h4>
            </div>
            <div class="card-body">
                <form action="{{route('kewirausahaan.update',encrypt($data['utama']->id_kewirausahaan))}}" method="post" enctype="multipart/form-data" id="form-seminar">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="">Nama Usaha Mandiri <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama_usaha" id="" aria-describedby="helpId"
                            placeholder="" value="{{ $data['utama']->nama_usaha }}">
                    </div>
                    <div class="form-group">
                      <label for="">Alamat Usaha</label>
                      <textarea class="form-control" name="alamat_usaha" id="" rows="3">{{$data['utama']->alamat_usaha}}</textarea>
                    </div>
                    <div class="form-group">
                      <label for="">No Izin</label>
                      <input type="text" class="form-control" name="no_izin" value="{{$data['utama']->no_izin}}">
                    </div>
                    <div class="form-group">
                      <label for="">Bukti Kegiatan<span class="text-danger">*</span></label>
                      <input type="file" class="form-control-file" name="bukti_kegiatan" id="" placeholder="" aria-describedby="fileHelpId">
                      <small id="fileHelpId" class="form-text text-muted"><a href="{{asset('storage/'.$data['utama']->files->path)}}"><i class="fa fa-paperclip" aria-hidden="true"></i>Bukti Kegiatan</a></small>
                    </div>
                    <div class="row">
                        <div class="col-12 offset-5">
                            <button type="button" onclick="confirmation('form-seminar')" class="btn btn-outline-primary"><i class="fas fa-save" aria-hidden="true"></i> Simpan Data</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
@include('plugins.alertify')
@section('js')
<script>
    function confirmation(id){
        alertify.confirm("Konfirmasi!", "Kirim Data ? Pastikan data yang anda isi sudah benar !", function() {
                $('#' + id).submit();
            }, function() {

            })
    }
</script>
@stop
