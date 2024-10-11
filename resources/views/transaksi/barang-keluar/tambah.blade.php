@extends('layouts.app')
@section('title') Tambah Barang Keluar @endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST">
            @csrf

            <div class="form-group row">
                <label for="no_barang_keluar" class="col-md-2 col-form-label">No Barang Keluar</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="no_barang_keluar" id="no_barang_keluar" placeholder="auto" readonly>
                </div>
            </div>

            <div class="form-group row">
                <label for="tanggal_barangkeluar" class="col-md-2 col-form-label">Tanggal Barang Keluar</label>
                <div class="col-md-4">
                    <input type="text" class="form-control datepicker" name="tanggal_barangkeluar" id="tanggal_barangkeluar" data-toggle="datetimepicker" data-target="#tanggal_barangkeluar" value="{{old("tanggal_barangkeluar")}}" />
                </div>
            </div>

            <div class="form-group row">
                <label for="id_m_konsumen" class="col-md-2 col-form-label">Konsumen / Stakeholder yang mengeluarkan barang</label>
                <div class="col-md-4">
                    <select class="form-control" name="id_m_konsumen" id="id_m_konsumen" placeholder="Pilih Konsumen">
                        @foreach ($konsumen_list as $key => $item)
                        <option value="{{$key}}">{{$item}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="no_invoice" class="col-md-2 col-form-label">No Invoice</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="no_invoice" id="no_invoice" placeholder="Enter No invoice" value="{{old("no_invoice")}}" />
                </div>
            </div>

            <div class="form-group row">
                <label for="pic" class="col-md-2 col-form-label">PIC Barang keluar</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="pic" id="pic" placeholder="Enter PIC Barang keluar" value="{{old("pic")}}" />
                </div>
            </div>

            <div class="form-group row">
                <label for="keterangan" class="col-md-2 col-form-label">Catatan / Keterangan</label>
                <div class="col-md-4">
                    <textarea class="form-control" name="keterangan" id="keterangan" rows="3" placeholder="Enter Catatan">{{old("keterangan")}}</textarea>
                </div>
            </div>

            <table class="table table-bordered align-middle">
                <thead>
                    <tr class="text-center">
                        <th width="50"><button class="btn btn-sm btn-primary" id="btn-tambah" type="button"><i class="fa fa-plus"></i></button></th>
                        <th>Gudang</th>
                        <th>Barang</th>
                        <th width="100">Jumlah</th>
                        <th width="150">Keterangan</th>
                    </tr>
                </thead>
                <tbody id="tb-detail">

                </tbody>
            </table>

            <div class="form-group row">
                <div class="col-md-4 offset-sm-2">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{url("transaksi/barang-keluar")}}" class="btn btn-secondary">Batal</a>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection

@section('script')
<script>
    $(function () {
        $("#btn-tambah").click(function () {
            let tr = `<tr>
                <td><button class="btn btn-sm btn-danger btn-hapus" type="button"><i class="fa fa-trash-alt"></i></button></td>
                <td><select class="form-control" name="id_m_gudang[]" id="id_m_gudang">
                        @foreach($gudang_list as $key => $item)
                        <option value="{{$key}}">{{$item}}</option>
                        @endforeach
                    </select>
                </td>
                <td><select class="form-control" name="id_m_barang[]" id="id_m_barang">
                    @foreach($barang_list as $key => $item)
                    <option value="{{$key}}">{{$item}}</option>
                    @endforeach
                    </select>
                </td>
                <td><input type="text" name="jumlah_pengeluaran[]" id="jumlah_pengeluaran" class="form-control jumlah_pengeluaran numeric2" /></td>
                <td><input type="text" name="catatan_detail[]" id="catatan_detail" class="form-control" /></td>
            </tr>`;
            $("#tb-detail").append(tr);
            initControl();
        });
        $("body").delegate(".btn-hapus", "click", function () {
            let tr = $(this).closest("tr");
            $.confirm({
                title  : 'Yakin hapus?',
                content: '',
                buttons: {
                    ya: function () {
                        tr.remove();
                    },
                    batal: function () {},
                }
            });
        });
    });
</script>
@endsection