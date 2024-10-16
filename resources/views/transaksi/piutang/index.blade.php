@extends('layouts.app')
@section('title') Piutang @endsection

@section('content')
<div class="card">
    <div class="card-header">
        <form class="form-inline">
            <a href="{{url("transaksi/piutang/tambah")}}" class="btn btn-primary mb-1 mr-1">Tambah</a>
            <input type="text" class="form-control mb-1 mr-1" placeholder="Cari">
            <button type="submit" class="btn btn-primary mb-1"><i class="fa fa-search"></i></button>
        </form>
    </div>
    <div class="card-body table-responsive">
        <div class="alert alert-info">
            Piutang Lunas : {{number($status_piutang->sudah_lunas,0,0)}}<br />
            Piutang Belum Lunas : {{number($status_piutang->belum_lunas,0,0)}}<br />
        </div>

        <table class="table table-sm">
            <thead class="table-bordered">
                <tr>
                    <th style="width:100px">Action</th>
                    <th>No Transaksi</th>
                    <th>Tanggal Transaksi</th>
                    <th>PIC Piutang</th>
                    <th>Status Lunas</th>
                    <th>Keterangan</th>
                    <th>Nominal Piutang</th>
                </tr>
            </thead>
            <tbody class="table-bordered">
                @forelse ($data as $item)
                <tr>
                    <td class="text-center">
                        <a href="{{url("transaksi/piutang/edit", $item->id_t_piutang)}}" class="btn btn-icon btn-sm btn-primary"><i class="fa fa-pencil-alt"></i></a>
                        <button class="btn btn-icon btn-sm btn-danger btn-hapus" data-id="{{$item->id_t_piutang}}"><i class="fa fa-trash-alt"></i></button>
                    </td>
                    <td>{{$item->no_transaksi}}</td>
                    <td>{{$item->tanggal_transaksi}}</td>
                    <td>{{$item->pic_piutang}}</td>
                    <td>{{$item->status_lunas}}</td>
                    <td>{{$item->keterangan}}</td>
                    <td class="text-right">{{number($item->nominal_piutang)}}</td>
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
                        $.post(`{{url("transaksi/piutang/hapus")}}/${id}`, function(data){
                            $.alert("Berhasil menghapus piutang.");
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