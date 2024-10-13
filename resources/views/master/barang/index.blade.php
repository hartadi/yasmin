@extends('layouts.app')
@section('title') Barang @endsection

@section('content')
<div class="card">
    <div class="card-header">
        <form class="form-inline">
            <a href="{{url("master/barang/tambah")}}" class="btn btn-primary mb-1 mr-1">Tambah</a>
            <input type="text" class="form-control mb-1 mr-1" placeholder="Cari" name="q" value="{{$q}}">
            <button type="submit" class="btn btn-primary mb-1"><i class="fa fa-search"></i></button>
        </form>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width:100px">Action</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Satuan</th>
                    <th class="text-right">Minimal Stok</th>
                    <th class="text-right">Stok Awal</th>
                    <th class="text-right">Harga Beli</th>
                    <th class="text-right">Harga Jual</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                <tr>
                    <td class="text-center">
                        <a href="{{url("master/barang/edit", $item->id_m_barang)}}" class="btn btn-icon btn-sm btn-primary"><i class="fa fa-pencil-alt"></i></a>
                        <button class="btn btn-icon btn-sm btn-danger btn-hapus" data-id="{{$item->id_m_barang}}"><i class="fa fa-trash-alt"></i></button>
                    </td>
                    <td>{{$item->kode_barang}}</td>
                    <td>{{$item->nama_barang}}</td>
                    <td>{{$item->satuan->nama_satuan??""}}</td>
                    <td class="text-right">{{number($item->minimal_stock)}}</td>
                    <td class="text-right">{{number($item->stock_awal)}}</td>
                    <td class="text-right">{{number($item->harga_pembelian)}}</td>
                    <td class="text-right">{{number($item->harga_jual)}}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">Tidak ada data.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($data->hasPages())
        {{$data->appends(["q"=>$q])->links()}}
        @endif
    </div>
</div>
@endsection

@section('script')
<script>
    $(function () {
        $("body").delegate(".btn-hapus", "click", function () {
            let id = $(this).data("id");
            $.confirm({
                title  : 'Yakin hapus?',
                content: '',
                buttons: {
                    ya: function () {
                        $.post(`{{url("master/barang/hapus")}}/${id}`, function(data){
                            $.alert("Berhasil menghapus barang.");
                            setTimeout(() => {location.reload();}, 500);
                        });
                    },
                    batal: function () {},
                }
            });
        });
    });
</script>
@endsection