@extends('layouts.app')
@section('title') Laporan Arus Barang @endsection

@section('content')
<div class="card">
    <div class="card-body">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th rowspan="2" width="175">Tanggal</th>
                    <th colspan="3">Masuk</th>
                    <th colspan="3">Keluar</th>
                    <th colspan="3">Sisa</th>
                </tr>
                <tr>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Nilai</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Nilai</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $i => $item)
                <tr>
                    <td>{{__date($item->tanggal_terima)}}</td>
                    <td>{{number($item->jumlah_masuk)}}</td>
                    <td>{{number($item->harga)}}</td>
                    <td>{{number($item->saldo_masuk)}}</td>
                    <td>
                        <table class="table">
                            <tr>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Nilai</th>
                            </tr>
                            @forelse ($item->fifo_keluar as $keluar)
                            <tr>
                                <td>{{number($keluar->jumlah_masuk)}}</td>
                                <td>{{number($keluar->harga)}}</td>
                                <td>{{number($keluar->saldo_masuk)}}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3">Tidak ada data.</td>
                            </tr>
                            @endforelse
                        </table>
                    </td>
                    <td></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection