@extends('adminlte::page')
@section('title', 'Detail Validasi')
@section('content_header')
    <h1 class="font-bold">Detail Validasi</h1>
@stop
@section('content')

@include('partials.detail-validasi',['data','type'])
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
