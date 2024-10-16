@extends('layouts.app')
@section('title') Edit Piutang @endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST">
            @csrf

            <div class="form-group row">
                <label for="no_transaksi" class="col-md-2 col-form-label">No Transaksi</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="no_transaksi" id="no_transaksi" placeholder="auto" readonly value="{{old("no_transaksi", $data->no_transaksi)}}" />
                </div>
            </div>

            <div class="form-group row">
                <label for="tanggal_transaksi" class="col-md-2 col-form-label">Tanggal Transaksi</label>
                <div class="col-md-4">
                    <input type="text" class="form-control datepicker" name="tanggal_transaksi" id="tanggal_transaksi" data-toggle="datetimepicker" data-target="#tanggal_transaksi" value="{{old("tanggal_transaksi", $data->tanggal_transaksi)}}" />
                </div>
            </div>

            <div class="form-group row">
                <label for="pic_piutang" class="col-md-2 col-form-label">PIC Piutang</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="pic_piutang" id="pic_piutang" placeholder="PIC Piutang" value="{{old("pic_piutang", $data->pic_piutang)}}" />
                </div>
            </div>

            <div class="form-group row">
                <label for="nominal_piutang" class="col-md-2 col-form-label">Nominal Piutang</label>
                <div class="col-md-4">
                    <input type="text" class="form-control numeric" name="nominal_piutang" id="nominal_piutang" placeholder="Nominal Piutang" value="{{old("nominal_piutang", $data->nominal_piutang)}}" />
                </div>
            </div>

            <div class="form-group row">
                <label for="keterangan" class="col-md-2 col-form-label">Keterangan</label>
                <div class="col-md-4">
                    <textarea class="form-control" name="keterangan" id="keterangan" rows="3" placeholder="Keterangan">{{old("keterangan", $data->keterangan)}}</textarea>
                </div>
            </div>

            <div class="form-group row">
                <label for="status_lunas" class="col-md-2 col-form-label">Status Lunas</label>
                <div class="col-md-4">
                    <select class="form-control" name="status_lunas" id="status_lunas" placeholder="Pilih Status Lunas">
                        <option value="">Pilih Status Lunas</option>
                        <option value="belum" @selected(old("status_lunas", $data->status_lunas)=="belum")>Belum</option>
                        <option value="sudah" @selected(old("status_lunas", $data->status_lunas)=="sudah")>Sudah</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-4 offset-sm-2">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{url("transaksi/piutang")}}" class="btn btn-secondary">Batal</a>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection