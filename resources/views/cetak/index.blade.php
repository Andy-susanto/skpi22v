@extends('adminlte::page')
@section('title', 'Cetak SKPI')
@section('content_header')
<div class="row">
    <div class="mb-3 col-12">
        <h1 class="m-0 font-bold text-dark uppercase"><i class="fa fa-print" aria-hidden="true"></i> Cetak SKPi</h1>
    </div>
</div>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <p class="italic text-red-600">Anda harus mengisikan data translate sebelum bisa di cetak</p>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Jenis Kegiatan</th>
                            <th>Data</th>
                            <th>Translate</th>
                            <th><i class="fa fa-cogs" aria-hidden="true"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($seminar as $data_seminar)
                            <tr>
                                <td><input type="hidden" name="jenis" value="seminar" class="jenis">Seminar</td>
                                <td><input type="hidden" name="id" class="id" value="{{$data_seminar->id_seminar_pelatihan_workshop_diklat}}">{{$data_seminar->nama}}</td>
                                <td>
                                    <div class="form-group">
                                      <textarea class="form-control translate" name="translate" rows="3">{{$data_seminar->nama_eng}}</textarea>
                                    </div>
                                </td>
                                <td><button type="button" class="btn-simpan btn bg-gradient-to-r from-cyan-500 to-blue-500 hover:to-green-500 rounded-full text-white btn-sm">Simpan</button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop
@section('js')
<script>
    $(document).ready(function(){
        $('.btn-simpan').on('click',function(){
            var btn = $(this);
            var jenis = btn.parents('tr').find('.jenis').val();
            var id = btn.parents('tr').find('.id').val();
            var translate = btn.parents('tr').find('.translate').val();
            $.ajax({
            url: '{{route('print.store')}}',
            type: 'POST',
            data: {
                '_token': '{{csrf_token()}}',
                'translate': translate,
                'jenis': jenis,
                'id': id
            },
            beforeSend:function(){
               btn.html('Sedang Menyimpan Data <i class="fa fa-spinner fa-spin"></i>');
            },
            success: function(data){
                btn.html('Data Berhasil di Simpan <i class="fa fa-check" aria-hidden="true"></i>');
                btn.html('Simpan');
            }
        });
        })
    })
</script>
@endsection
