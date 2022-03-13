@extends('adminlte::page')
@section('title', 'Pengaturan Bobot')
@section('content_header')
    <h1 class="m-0 text-dark">Pengaturan Bobot</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{route('pengaturan-bobot.store')}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                      <label for="">Minimum Bobot</label>
                      <input type="nunmber" class="form-control" name="min_bobot" id="" aria-describedby="helpId" placeholder="" value="{{$data->value}}">
                    </div>
                    <button type="submit" class="btn bg-blue-400 text-white shadow-sm hover:bg-green-400">Simpan Data</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
