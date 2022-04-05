@extends('adminlte::page')
@section('title', 'Ubah Seminar Pelatihan')
@section('content_header')
    <h1 class="m-0 text-dark"><span><a name="" id="" class="btn btn-default btn-sm"
                href="{{ route('seminar-pelatihan.index') }}" role="button"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</a></span> Ubah Seminar Pelatihan <button type="button" class="btn btn-outline-primary btn-sm"><i class="fa fa-info" aria-hidden="true"></i> Detail</button></h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-6 offset-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="font-bold card-title">Ubah Data</h4>
                </div>
                <div class="card-body">
                    <form action="{{route('beasiswa.update',encrypt($data['utama']->id_beasiswa))}}" method="post" enctype="multipart/form-data" id="form-seminar">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="">Nama Beasiswa</label>
                            <input type="text" class="form-control" name="nama" id="" aria-describedby="helpId"
                                placeholder="" value="{{ $data['utama']->nama }}">
                        </div>
                        <div class="form-group">
                           <div class="form-group">
                             <label for="">Nama Perusahaan / Industri / Instansi / Yayasan Pemberi
                                Beasiswa ( Promotor )</label>
                             <input type="text" class="form-control" name="nama_promotor" id="" aria-describedby="helpId" placeholder="" value="{{$data['utama']->nama_promotor}}">
                           </div>
                        </div>
                        <div class="form-group">
                            <label for="">Kategori Beasiswa</label>
                            <select class="form-control" name="ref_kategori_id" id="beasiswa" >
                                @foreach (Helper::kategori(7) as $loopKategori)
                                    <option value="{{ $loopKategori->id_ref_kategori }}"  {{ $data['utama']->ref_kategori_id == $loopKategori->id_ref_kategori ? 'selected' : '' }}>
                                        {{ $loopKategori->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Cakupan Beasiswa</label>
                            <select class="form-control" name="ref_cakupan_beasiswa_id" id="cakupan_beasiswa">
                                @foreach (Helper::cakupan_beasiswa() as $loopCakupan)
                                <option value="{{ $loopCakupan->id_ref_cakupan_beasiswa }}"  {{ $data['utama']->ref_cakupan_beasiswa_id == $loopCakupan->id_ref_cakupan_beasiswa ? 'selected' : '' }}>
                                    {{ $loopCakupan->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                          <label for="">Bukti Kegiatan ( File Sertifikat ) </label>
                          <input type="file" class="form-control-file" name="bukti_kegiatan" id="" placeholder="" aria-describedby="fileHelpId">
                          <small id="fileHelpId" class="form-text text-muted"><a href="{{asset('storage/'.$data['utama']->files->path)}}"><i class="fa fa-paperclip" aria-hidden="true"></i> File Sertifikat</a></small>
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
@endsection
@include('plugins.select2')
@include('plugins.alertify')
@section('js')
    <script>
        $('#kategori_beasiswa,#cakupan_beasiswa').select2();
        function confirmation(id) {
            alertify.confirm("Konfirmasi!", "Kirim Data ? Pastikan data yang anda isi sudah benar !", function() {
                $('#' + id).submit();
            }, function() {

            })
        }
    </script>
@endsection
