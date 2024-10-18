@extends('layouts.app')
@section('title') Tambah Barang @endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST">
            @csrf

            <div class="form-group row">
                <label for="kode_barang" class="col-md-2 col-form-label">Kode Barang</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="kode_barang" id="kode_barang" placeholder="Auto" readonly />
                </div>
            </div>

            <div class="form-group row">
                <label for="nama_barang" class="col-md-2 col-form-label">Nama Barang</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="nama_barang" id="nama_barang" placeholder="Nama Barang" />
                </div>
            </div>

            <div class="form-group row">
                <label for="id_m_satuan" class="col-md-2 col-form-label">Satuan</label>
                <div class="col-md-4">
                    <select class="form-control uselect2" name="id_m_satuan" id="id_m_satuan" placeholder="Pilih Satuan">
                        <option value="">Pilih Satuan</option>
                        @foreach ($satuan_list as $key => $item)
                        <option value="{{$key}}">{{$item}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="minimal_stock" class="col-md-2 col-form-label">Minimal Stok</label>
                <div class="col-md-4">
                    <input type="text" class="form-control numeric" name="minimal_stock" id="minimal_stock" placeholder="Minimal Stok" />
                </div>
            </div>

            <div class="form-group row">
                <label for="stock_awal" class="col-md-2 col-form-label">Stok Awal</label>
                <div class="col-md-4">
                    <input type="text" class="form-control numeric" name="stock_awal" id="stock_awal" placeholder="Stok Awal" />
                </div>
            </div>

            <div class="form-group row">
                <label for="harga_pembelian" class="col-md-2 col-form-label">Harga Pembelian</label>
                <div class="col-md-4">
                    <input type="text" class="form-control numeric" name="harga_pembelian" id="harga_pembelian" placeholder="Harga Pembelian" />
                </div>
            </div>

            <div class="form-group row">
                <label for="harga_jual" class="col-md-2 col-form-label">Harga Jual</label>
                <div class="col-md-4">
                    <input type="text" class="form-control numeric" name="harga_jual" id="harga_jual" placeholder="Harga Jual" />
                </div>
            </div>


            <div class="form-group row">
                <div class="col-md-4 offset-sm-2">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{url("master/barang")}}" class="btn btn-secondary">Batal</a>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection