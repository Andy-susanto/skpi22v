@extends('adminlte::page')

@section('title', 'Penghargaan Kejuaraan')

@section('content_header')
    <h1 class="m-0 text-dark"><span><a class="btn btn-default btn-sm shadow-sm" href="{{route('beasiswa.index')}}" role="button">Kembali</a></span> Beasiswa Detail</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <td>Nama Kegiatan</td>
                            <td>:</td>
                            <td>{{$data->nama}}</td>
                        </tr>
                        <tr>
                            <td>Nama Promotor</td>
                            <td>:</td>
                            <td>{{$data->nama_promotor}}</td>
                        </tr>
                        <tr>
                            <td>Bukti Kegiatan</td>
                            <td>:</td>
                            <td><a href="{{asset('storage/'.$data->files->path)}}" class="btn btn-sm btn-info">Lihat Bukti</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop
