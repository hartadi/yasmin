@extends('layouts.app')
@section('title') Edit Konsumen @endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST">
            @csrf

            <div class="form-group row">
                <label for="nama_konsumen" class="col-md-2 col-form-label">Nama Konsumen</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="nama_konsumen" id="nama_konsumen" placeholder="Nama Konsumen" value="{{$data->nama_konsumen??old("nama_konsumen")}}" />
                </div>
            </div>
            <div class="form-group row">
                <label for="alamat" class="col-md-2 col-form-label">Alamat</label>
                <div class="col-md-4">
                    <textarea name="alamat" id="alamat" class="form-control" placeholder="Alamat">{{$data->alamat??old("alamat")}}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="no_telp" class="col-md-2 col-form-label">No Telp</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="no_telp" id="no_telp" placeholder="No Telp" value="{{$data->no_telp??old("no_telp")}}" />
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-md-2 col-form-label">Email</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="{{$data->email??old("email")}}" />
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-4 offset-sm-2">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{url("master/konsumen")}}" class="btn btn-secondary">Batal</a>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection