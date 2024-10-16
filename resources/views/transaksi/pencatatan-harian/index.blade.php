@extends('layouts.app')
@section('title') Pencatatan Pembukuan Harian @endsection

@section('content')
<div class="card">
    <div class="card-header">
        <form class="form-inline">
            <a href="{{url("transaksi/pencatatan-harian/tambah")}}" class="btn btn-primary mb-1 mr-1">Tambah</a>
            <input type="text" class="form-control mb-1 mr-1" placeholder="Cari">
            <button type="submit" class="btn btn-primary mb-1"><i class="fa fa-search"></i></button>
        </form>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width:100px">Action</th>
                    <th>No Transaksi</th>
                    <th>Tanggal Transaksi</th>
                    <th>Jenis Transaksi</th>
                    <th>Tipe Transaksi</th>
                    <th>COA</th>
                    <th>Bank</th>
                    <th>Keterangan</th>
                    <th>Debit</th>
                    <th>Credit</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                <tr>
                    <td class="text-center">
                        <a href="{{url("transaksi/pencatatan-harian/edit", $item->id_t_pembukuanharian)}}" class="btn btn-icon btn-sm btn-primary"><i class="fa fa-pencil-alt"></i></a>
                        <button class="btn btn-icon btn-sm btn-danger btn-hapus" data-id="{{$item->id_t_pembukuanharian}}"><i class="fa fa-trash-alt"></i></button>
                    </td>
                    <td>{{$item->no_transaksi}}</td>
                    <td>{{$item->tanggal_transaksi}}</td>
                    <td>{{$item->jenis_transaksi}}</td>
                    <td>{{$item->tipe_transaksi}}</td>
                    <td>{{$item->coa}}</td>
                    <td>{{$item->bank}}</td>
                    <td>{{$item->keterangan}}</td>
                    <td class="text-right">{{number($item->nilai_debet)}}</td>
                    <td class="text-right">{{number($item->nilai_credit)}}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="10">Tidak ada data.</td>
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
                        $.post(`{{url("transaksi/pencatatan-harian/hapus")}}/${id}`, function(data){
                            $.alert("Berhasil menghapus pencatatan pembukuan harian.");
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