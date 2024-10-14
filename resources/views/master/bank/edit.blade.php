@extends('layouts.app')
@section('title') Edit Bank @endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST">
            @csrf

            <div class="form-group row">
                <label for="kode_bank" class="col-md-2 col-form-label">Kode Bank</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="kode_bank" id="kode_bank" placeholder="Kode Bank" value="{{$data->kode_bank??old("kode_bank")}}" />
                </div>
            </div>
            <div class="form-group row">
                <label for="nama_bank" class="col-md-2 col-form-label">Nama Bank</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="nama_bank" id="nama_bank" placeholder="Nama Bank" value="{{$data->nama_bank??old("nama_bank")}}" />
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-4 offset-sm-2">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{url("master/bank")}}" class="btn btn-secondary">Batal</a>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection