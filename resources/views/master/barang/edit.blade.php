@extends('layouts.app')
@section('title') Edit Satuan @endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST">
            @csrf

            <div class="form-group row">
                <label for="nama_satuan" class="col-md-2 col-form-label">Nama Satuan</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="nama_satuan" id="nama_satuan" placeholder="Nama Satuan" value="{{$data->nama_satuan??old("nama_satuan")}}" />
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-4 offset-sm-2">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{url("master/satuan")}}" class="btn btn-secondary">Batal</a>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection