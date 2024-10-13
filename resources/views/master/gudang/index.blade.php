@extends('layouts.app')
@section('title') Gudang @endsection

@section('content')
<div class="card">
    <div class="card-header">
        <form class="form-inline">
            <a href="{{url("master/gudang/tambah")}}" class="btn btn-primary mb-1 mr-1">Tambah</a>
            <input type="text" class="form-control mb-1 mr-1" placeholder="Cari" name="q" value="{{$q}}">
            <button type="submit" class="btn btn-primary mb-1"><i class="fa fa-search"></i></button>
        </form>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width:100px">Action</th>
                    <th>Kode Gudang</th>
                    <th>Nama Gudang</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                <tr>
                    <td class="text-center">
                        <a href="{{url("master/gudang/edit", $item->id_m_gudang)}}" class="btn btn-icon btn-sm btn-primary"><i class="fa fa-pencil-alt"></i></a>
                        <button class="btn btn-icon btn-sm btn-danger btn-hapus" data-id="{{$item->id_m_gudang}}"><i class="fa fa-trash-alt"></i></button>
                    </td>
                    <td>{{$item->kode_gudang}}</td>
                    <td>{{$item->nama_gudang}}</td>
                    <td>{{$item->keterangan}}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">Tidak ada data.</td>
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
                        $.post(`{{url("master/gudang/hapus")}}/${id}`, function(data){
                            $.alert("Berhasil menghapus gudang.");
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