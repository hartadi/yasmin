@extends('layouts.app')
@section('title') Tambah Akun @endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST">
            @csrf

            <div class="form-group row">
                <label for="kode_coa" class="col-md-2 col-form-label">Kode Akun</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="kode_coa" id="kode_coa" placeholder="Kode Akun" />
                </div>
            </div>
            <div class="form-group row">
                <label for="nama_coa" class="col-md-2 col-form-label">Nama Akun</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="nama_coa" id="nama_coa" placeholder="Nama Akun" />
                </div>
            </div>
            <div class="form-group row">
                <label for="tipe_coa" class="col-md-2 col-form-label">Tipe Akun</label>
                <div class="col-md-4">
                    <select name="tipe_coa" id="tipe_coa" class="form-control">
                        <option value="">Pilih Tipe Akun</option>
                        <option value="D">Debet</option>
                        <option value="C">Credit</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="keterangan" class="col-md-2 col-form-label">Keterangan</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan" />
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-4 offset-sm-2">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{url("master/akun")}}" class="btn btn-secondary">Batal</a>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection