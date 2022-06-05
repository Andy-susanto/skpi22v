@extends('adminlte::page')
@section('title', 'Detail Validasi')
@section('content_header')
    <h1 class="font-bold">Detail Validasi</h1>
@stop
@section('content')
    @if ($jenis == 'penghargaan')
        @include('partials.detail-penghargaan', ['data' => $data])
    @elseif ($jenis == 'seminar')
        @include('partials.detail-seminar', ['data' => $data])
    @elseif ($jenis == 'hibah')
        @include('partials.hibah.validasi-hibah', ['data' => $data])
    @elseif ($jenis == 'pengabdian')
        @include('partials.detial-pengabdian', ['data' => $data])
    @elseif ($jenis == 'organisasi')
       @include('partials.detail-organisasi',['data' => $data])
        {{-- Panel Magang --}}
    @elseif ($jenis == 'magang')
        @include('partials.detail-magang',['data' => $data])
        {{-- Panel Beasiswa --}}
    @elseif ($jenis == 'beasiswa')
       @include('partials.detail-beasiswa',['data' => $data])
        {{-- Panel Bahasa --}}
    @elseif ($jenis == 'bahasa')
       @include('partials.detail-bahasa',['data' => $data])
        {{-- Panel Kewirausahaan --}}
    @elseif ($jenis == 'kewirausahaan')
        @include('partials.detail-kewirausahaan',['data' => $data])
        {{-- Panel HKI --}}
    @elseif ($jenis == 'hki')
       @include('partials.detail-hki',['data' => $data])
        {{-- Panel Publikasi --}}
    @elseif ($jenis == 'publikasi')
        @include('partials.detail-publikasi',['data' => $data])
    @endif
    <div class="row pt-5 mb-5 pb-10 justify-content-center bg-slate-800 shadow-sm">
        <div class="col-2">
            <a name="" id="" class="btn btn-success btn-lg" href="#" role="button">Validasi</a>
        </div>
        <div class="col-2">
            <a name="" id="" class="btn btn-danger btn-lg" href="#" role="button">Tolak</a>
        </div>
    </div>
@stop
@include('plugins.pspdfkit')
@include('plugins.alertify')
@section('js')
@if ($data->files()->exists())
<script>
    PSPDFKit.load({
        container: "#sertifikat",
        document: "{{ asset('storage/' . $data->files->path) }}", // Add the path to your document here.
    })
    .then(function(instance) {
        console.log("PSPDFKit loaded", instance);
    })
    .catch(function(error) {
        console.error(error.message);
    });
</script>
@endif
@if (method_exists($data,'file_sk'))
@if($data->file_sk()->exists())
<script>
    PSPDFKit.load({
        container: "#file-sk",
        document: "{{ asset('storage/' . $data->file_sk->path) }}", // Add the path to your document here.
    })
    .then(function(instance) {
        console.log("PSPDFKit loaded", instance);
    })
    .catch(function(error) {
        console.error(error.message);
    });
</script>
@endif
@endif
@endsection
