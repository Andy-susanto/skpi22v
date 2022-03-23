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
    <form action="{{route('pengaturan-cetak.store')}}" method="post">
        @csrf
        @method('post')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3>Sikap dan Tata Nilai</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                              <label for="">Program Studi</label>
                              <select class="form-control" name="prodi" id="prodi">
                                  @foreach(\App\Models\UnitKerja::with('parent_unit','parent_unit_utama','ref_unit')->FilterUnit()->get() as $unit)
                                    <option value="{{ $unit->id_unit_kerja }}">
                                        {{ ' (' . $unit->parent_unit_utama->ref_unit->singkatan_unit . ') ' . $unit->ref_unit->nama_ref_unit_kerja_lengkap }}
                                    </option>
                                  </option>
                                  @endforeach
                              </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Sikap dan Tata Nilai</label>
                                <textarea class="form-control" name="sikap_tata_nilai" id="text1" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Sikap dan Tata Nilai ( Dalam bahasa Inggris)</label>
                                <textarea class="form-control text-editor" name="sikap_tata_nilai_eng" id="text1trans" rows="3"></textarea>
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
                                <textarea class="form-control text-editor" name="kemampuan_kerja" id="text2" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Kemampuan Kerja ( Dalam bahasa Inggris)</label>
                                <textarea class="form-control text-editor" name="kemampuan_kerja_eng" id="text2trans" rows="3"></textarea>
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
                                <textarea class="form-control text-editor" name="penguasaan_pengetahuan" id="text3" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Penguasaan Pengetahuan ( Dalam bahasa Inggris)</label>
                                <textarea class="form-control text-editor" name="penguasaan_pengetahuan_eng" id="text3trans" rows="3"></textarea>
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
                                <textarea class="form-control text-editor" name="kemampuan_manajerial" id="text4" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Kemampuan Manajerial ( Dalam bahasa Inggris)</label>
                                <textarea class="form-control text-editor" name="kemampuan_manajerial_eng" id="text4trans" rows="3"></textarea>
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
    </form>
@stop
@include('plugins.summernote')
@section('js')
    <script>
        $(document).ready(function() {
            $('#text1,#text2,#text3,#text4,#text1trans,#text2trans,#text3trans,#text4trans').summernote();
        });
    </script>
@endsection
