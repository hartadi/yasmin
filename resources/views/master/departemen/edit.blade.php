@extends('layouts.app')
@section('title') Edit Departemen @endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST">
            @csrf

            <div class="form-group row">
                <label for="kode_departemen" class="col-md-2 col-form-label">Kode Departemen</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="kode_departemen" id="kode_departemen" placeholder="auto" readonly value="{{old("kode_departemen", $data->kode_departemen)}}" />
                </div>
            </div>
            <div class="form-group row">
                <label for="nama_departemen" class="col-md-2 col-form-label">Nama Departemen</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="nama_departemen" id="nama_departemen" placeholder="Nama Gudang" value="{{old("nama_departemen", $data->nama_departemen)}}" />
                </div>
            </div>
            <div class="form-group row">
                <label for="pic" class="col-md-2 col-form-label">PIC</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="pic" id="pic" placeholder="PIC" value="{{old("pic", $data->pic)}}" />
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-4 offset-sm-2">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{url("master/departemen")}}" class="btn btn-secondary">Batal</a>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection