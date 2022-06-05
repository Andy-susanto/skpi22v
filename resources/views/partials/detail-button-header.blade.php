<div class="row">
    <div class="col-md-6">
        <a name="" id="" class="btn btn-secondary btn-xs" href="{{route('validasi-rekam-kegiatan.index')}}" role="button"><i class="fa fa-reply" aria-hidden="true"></i> Kembali</a>
    </div>
    <div class="col-md-6">
        <div class="alert alert-primary text-lg" role="alert">
            <strong>Total Bobot : {{Helper::hitung_bobot($data->siakad_mhspt_id)}}</strong>
        </div>
    </div>
</div>
