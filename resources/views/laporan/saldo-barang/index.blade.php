@extends('layouts.app')
@section('title') Laporan Saldo Barang @endsection

@section('content')
<div class="card">
    <div class="card-body">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Satuan</th>
                    <th>Stok Awal</th>
                    <th>Jumlah Masuk</th>
                    <th>Jumlah Keluar</th>
                    <th>Stok Akhir</th>
                    <th>Saldo Awal</th>
                    <th>Saldo Masuk</th>
                    <th>Saldo Keluar</th>
                    <th>Saldo Akhir</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $i => $item)
                <tr>
                    <td>{{$item->kode_barang}}</td>
                    <td>{{$item->nama_barang}}</td>
                    <td>{{$item->nama_satuan}}</td>
                    <td class="text-right">{{number($item->stock_awal)}}</td>
                    <td class="text-right">{{number($item->jumlah_masuk)}}</td>
                    <td class="text-right">{{number($item->jumlah_keluar)}}</td>
                    <td class="text-right">{{number($item->stock_awal + $item->jumlah_masuk - $item->jumlah_keluar)}}</td>
                    <td class="text-right">{{number($item->saldo_awal)}}</td>
                    <td class="text-right">{{number($item->saldo_masuk)}}</td>
                    <td class="text-right">{{number($item->saldo_keluar)}}</td>
                    <td class="text-right">{{number($item->saldo_awal + $item->saldo_masuk - $item->saldo_keluar)}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection