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
                            <th>No</th>
                            <th>Data</th>
                            <th>Translate</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td></td>
                            <td><div class="form-group">
                              <label for=""></label>
                              <textarea class="form-control" name="" id="" rows="3"></textarea>
                            </div></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn bg-gradient-to-r from-cyan-500 to-blue-500 hover:to-green-500 rounded-full text-white btn-sm">Simpan</button>
            </div>
        </div>
    </div>
</div>
@stop
