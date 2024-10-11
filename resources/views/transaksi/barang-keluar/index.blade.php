@extends('layouts.app')
@section('title') Barang Keluar @endsection

@section('content')
<div class="card">
    <div class="card-header">
        <form class="form-inline">
            <a href="{{url("transaksi/barang-keluar/tambah")}}" class="btn btn-primary mb-1 mr-1">Tambah</a>
            <input type="text" class="form-control mb-1 mr-1" placeholder="Cari">
            <button type="submit" class="btn btn-primary mb-1"><i class="fa fa-search"></i></button>
        </form>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width:100px">Action</th>
                    <th>No Barang Keluar</th>
                    <th>Tanggal</th>
                    <th>Konsumen</th>
                    <th>No Invoice</th>
                    <th>PIC</th>
                    <th>Catatan / Note</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                <tr>
                    <td class="text-center">
                        <a href="{{url("transaksi/barang-keluar/edit", $item->id_t_barangkeluar_h)}}" class="btn btn-icon btn-sm btn-primary"><i class="fa fa-pencil-alt"></i></a>
                        <a href="{{url("transaksi/barang-keluar/hapus", $item->id_t_barangkeluar_h)}}" class="btn btn-icon btn-sm btn-danger"><i class="fa fa-trash-alt"></i></a>
                    </td>
                    <td>{{$item->no_barangkeluar}}</td>
                    <td>{{$item->tanggal_barangkeluar}}</td>
                    <td>{{$item->departemen->nama_departemen??""}}</td>
                    <td>{{$item->no_penerimaan}}</td>
                    <td>{{$item->pic}}</td>
                    <td>{{$item->catatan}}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">Tidak ada data.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection