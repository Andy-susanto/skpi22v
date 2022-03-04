@extends('adminlte::page')
@section('title', 'Capaian Pembelajaran')
@section('content_header')
    <div class="row">
        <div class="mb-3 col-12">
            <h1 class="m-0 font-bold text-dark uppercase"><i class="fa fa-print" aria-hidden="true"></i> Capaian
                Pembelajaran</h1>
        </div>
    </div>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3>Sikap dan Tata Nilai</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Sikap dan Tata Nilai</label>
                                <textarea class="form-control" name="" id="text1" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Sikap dan Tata Nilai ( Dalam bahasa Inggris)</label>
                                <textarea class="form-control text-editor" name="" id="text1trans" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3>Kemampuan Kerja</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Kemampuan Kerja</label>
                                <textarea class="form-control text-editor" name="" id="text2" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Kemampuan Kerja ( Dalam bahasa Inggris)</label>
                                <textarea class="form-control text-editor" name="" id="text2trans" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3>Penguasaan Pengetahuan</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Penguasaan Pengetahuan</label>
                                <textarea class="form-control text-editor" name="" id="text3" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Penguasaan Pengetahuan ( Dalam bahasa Inggris)</label>
                                <textarea class="form-control text-editor" name="" id="text3trans" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3>Kemampuan Manajerial</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Kemampuan Manajerial</label>
                                <textarea class="form-control text-editor" name="" id="text4" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Kemampuan Manajerial ( Dalam bahasa Inggris)</label>
                                <textarea class="form-control text-editor" name="" id="text4trans" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-2">
            <button type="submit" class="btn btn-sm bg-gradient-to-r from-cyan-500 to-blue-500 hover:to-green-500 rounded-full text-white">Simpan</button>
        </div>
    </div>
@stop
@include('plugins.summernote')
@section('js')
    <script>
        $(document).ready(function() {
            $('#text1,#text2,#text3,#text4,#text1trans,#text2trans,#text3trans,#text4trans').summernote();
        });
    </script>
@endsection
