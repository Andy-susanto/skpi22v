@extends('adminlte::page')
@section('title', 'Cetak SKPI Operator')
@section('content_header')
<div class="row">
    <div class="mb-3 col-12">
        <h1 class="m-0 font-bold text-dark uppercase"><i class="fa fa-print" aria-hidden="true"></i> Cetak SKPI Operator</h1>
    </div>
</div>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-hover table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Mahasiswa</th>
                            <th>NIM</th>
                            <th>Prodi</th>
                            <th><i class="fa fa-cogs" aria-hidden="true"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $value)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$value['nama_mahasiswa']}}</td>
                                <td>{{$value['nim']}}</td>
                                <td>{{$value['prodi']}}</td>
                                <td><a name="" id="" class="btn btn bg-gradient-to-r from-cyan-500 to-blue-500 hover:to-green-500 rounded-full text-white btn-sm" href="{{route('cetak-skpi.show',$value['id'])}}" role="button">Cetak</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop
