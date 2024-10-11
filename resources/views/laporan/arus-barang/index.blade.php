@extends('layouts.app')
@section('title') Laporan Arus Barang @endsection

@section('content')
<div class="card">
    <div class="card-header">
        <form class="form-inline">
            <select class="form-control mr-1" name="barang_id" id="barang_id">
                <option value="">Pilih Barang</option>
                @foreach($barang_list as $key => $item)
                <option value="{{$key}}" @selected($barang_id==$key)>{{$item}}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
        </form>
    </div>
    <div class="card-body">
        @if($barang)
        <h3 class="text-center">Arus Barang {{$barang->kode_barang}} - {{$barang->nama_barang}}</h3>
        <table class="table table-bordered align-middle table-sm">
            <thead class="text-center bg-secondary">
                <tr>
                    <th rowspan="2" width="175">Tanggal</th>
                    <th colspan="3">Masuk</th>
                    <th colspan="3">Keluar</th>
                    <th colspan="3">Saldo Akhir</th>
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
            <?php
            $qty_sisa[]   = $barang->stock_awal;
            $harga_sisa[] = $barang->harga_pembelian;
            $saldo_sisa[] = $barang->stock_awal * $barang->harga_pembelian;
            ?>

            <tr>
                <td>Saldo Awal</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="text-right">
                    @foreach ($qty_sisa as $item)
                    {{number($item)}}<br />
                    @endforeach
                </td>
                <td class="text-right">
                    @foreach ($harga_sisa as $item)
                    @ {{number($item)}}<br />
                    @endforeach
                </td>
                <td class="text-right">
                    @foreach ($saldo_sisa as $item)
                    {{number($item)}}<br />
                    @endforeach
                </td>
            </tr>

            @foreach ($data as $i => $item)
            <?php
            if($item->jumlah_masuk>0) {
                $qty_sisa[]   = $item->jumlah_masuk;
                $harga_sisa[] = $item->harga;
                $saldo_sisa[] = $item->saldo_masuk;
            } else if($item->jumlah_keluar>0) {
                $cur_jumlah_keluar = $item->jumlah_keluar;
                foreach ($qty_sisa as $k => $q) {
                    if($q > $cur_jumlah_keluar) {
                        $qty_sisa[$k]   -= $cur_jumlah_keluar;
                        $saldo_sisa[$k] -= $cur_jumlah_keluar * $item->harga;
                        break;
                    } else {
                        $cur_jumlah_keluar -= $q;
                        $qty_sisa[$k]       = 0;
                        $saldo_sisa[$k]     = 0;
                    }
                }
            }
            ?>
            <tr>
                <td>{{__date($item->tanggal)}}</td>
                @if($item->jumlah_masuk>0)
                <td class="text-right">{{number($item->jumlah_masuk)}}</td>
                <td class="text-right">{{number($item->harga)}}</td>
                <td class="text-right">{{number($item->saldo_masuk)}}</td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                @else
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right">{{number($item->jumlah_keluar)}}</td>
                <td class="text-right">{{number($item->harga)}}</td>
                <td class="text-right">{{number($item->saldo_keluar)}}</td>
                @endif
                <td class="text-right">
                    @foreach ($qty_sisa as $item)
                    @if($item>0)
                    {{number($item)}}<br />
                    @endif
                    @endforeach
                    <span class="font-weight-bolder" style="border-top: 1px solid black;">{{number(collect($qty_sisa)->sum())}}</span>
                </td>
                <td class="text-right">
                    @foreach ($harga_sisa as $k => $item)
                    @if($qty_sisa[$k] > 0)
                    @ {{number($item)}}<br />
                    @endif
                    @endforeach
                    <span>&nbsp;</span>
                </td>
                <td class="text-right">
                    @foreach ($saldo_sisa as $k => $item)
                    @if($qty_sisa[$k] > 0)
                    {{number($item)}}<br />
                    @endif
                    @endforeach
                    <span class="font-weight-bolder" style="border-top: 1px solid black;">{{number(collect($saldo_sisa)->sum())}}</span>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection