@extends('adminlte::page')
@section('title', 'Detail Validasi')
@section('content_header')
    <h1 class="font-bold">Detail Validasi</h1>
@stop
@section('content')
    @if ($jenis == 'penghargaan')
        @include('partials.detail-penghargaan', ['data' => $data,'type'=>$type])
    @elseif ($jenis == 'seminar')
        @include('partials.detail-seminar', ['data' => $data,'type'=>$type])
    @elseif ($jenis == 'hibah')
        @include('partials.detail-hibah', ['data' => $data,'type'=>$type])
    @elseif ($jenis == 'pengabdian')
        @include('partials.detail-pengabdian', ['data' => $data,'type'=>$type])
    @elseif ($jenis == 'organisasi')
       @include('partials.detail-organisasi',['data' => $data,'type'=>$type])
        {{-- Panel Magang --}}
    @elseif ($jenis == 'magang')
        @include('partials.detail-magang',['data' => $data,'type'=>$type])
        {{-- Panel Beasiswa --}}
    @elseif ($jenis == 'beasiswa')
       @include('partials.detail-beasiswa',['data' => $data,'type'=>$type])
        {{-- Panel Bahasa --}}
    @elseif ($jenis == 'bahasa')
       @include('partials.detail-bahasa',['data' => $data,'type'=>$type])
        {{-- Panel Kewirausahaan --}}
    @elseif ($jenis == 'kewirausahaan')
        @include('partials.detail-kewirausahaan',['data' => $data,'type'=>$type])
        {{-- Panel HKI --}}
    @elseif ($jenis == 'hki')
       @include('partials.detail-hki',['data' => $data,'type'=>$type])
        {{-- Panel Publikasi --}}
    @elseif ($jenis == 'publikasi')
        @include('partials.detail-publikasi',['data' => $data,'type'=>$type])
    @endif

     <!-- Modal -->
<div class="modal fade" id="modalTolak" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <form method="post" action="" id="form-tolak-modal">
                @csrf
                @method('delete')
            <div class="modal-body">
                <div class="form-group">
                  <label for="">Alasan Penolakan</label>
                  <textarea class="form-control" name="pesan" id="" rows="4"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">OK</button>
            </div>
            </form>
        </div>
    </div>
</div>
@stop
@include('plugins.alertify')
@section('js')
<script>
     function tolakModal(id){
            $url = $(id).data('url');
            $('#modalTolak').modal('show');
            $('#form-tolak-modal').attr('action',$url);
        }
        function konfirmasi(id,text) {
            alertify.confirm("Konfirmasi!",text, function() {
                $('#' + id).submit();
            }, function() {

            })
        }
        function tolak(id,text){
            alertify.prompt('Konfirmasi !!','Alasan Penolakan',text,function(evt, value) {
                console.log(value);
                // $('#' + id).submit();
            },function(){

            });

        }
</script>
@endsection
