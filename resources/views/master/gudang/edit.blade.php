@extends('layouts.app')
@section('title') Edit Gudang @endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST">
            @csrf

            <div class="form-group row">
                <label for="kode_gudang" class="col-md-2 col-form-label">Kode Gudang</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="kode_gudang" id="kode_gudang" placeholder="auto" readonly value="{{old("kode_gudang", $data->kode_gudang)}}" />
                </div>
            </div>
            <div class="form-group row">
                <label for="nama_gudang" class="col-md-2 col-form-label">Nama Gudang</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="nama_gudang" id="nama_gudang" placeholder="Nama Gudang" value="{{old("nama_gudang", $data->nama_gudang)}}" />
                </div>
            </div>
            <div class="form-group row">
                <label for="keterangan" class="col-md-2 col-form-label">Keterangan</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan" value="{{old("keterangan", $data->keterangan)}}" />
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-4 offset-sm-2">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{url("master/gudang")}}" class="btn btn-secondary">Batal</a>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection