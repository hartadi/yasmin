@extends('layouts.app')
@section('title') Tambah Barang Masuk @endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST">
            @csrf

            <div class="form-group row">
                <label for="no_barang_masuk" class="col-md-2 col-form-label">No Barang Masuk</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="no_barang_masuk" id="no_barang_masuk" placeholder="auto" readonly>
                </div>
            </div>

            <div class="form-group row">
                <label for="tanggal_barangmasuk" class="col-md-2 col-form-label">Tanggal Barang Masuk</label>
                <div class="col-md-4">
                    <input type="text" class="form-control datepicker" name="tanggal_barangmasuk" id="tanggal_barangmasuk" data-toggle="datetimepicker" data-target="#tanggal_barangmasuk" value="{{old("tanggal_barangmasuk")}}" />
                </div>
            </div>

            <div class="form-group row">
                <label for="id_m_departemen" class="col-md-2 col-form-label">Departemen</label>
                <div class="col-md-4">
                    <select class="form-control" name="id_m_departemen" id="id_m_departemen" placeholder="Pilih Departemen">
                        @foreach ($departemen_list as $key => $item)
                        <option value="{{$key}}">{{$item}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="no_penerimaan" class="col-md-2 col-form-label">No Penerimaan</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="no_penerimaan" id="no_penerimaan" placeholder="Enter No Penerimaan" value="{{old("no_penerimaan")}}" />
                </div>
            </div>

            <div class="form-group row">
                <label for="pic" class="col-md-2 col-form-label">PIC Barang Masuk</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="pic" id="pic" placeholder="Enter PIC Barang Masuk" value="{{old("pic")}}" />
                </div>
            </div>

            <div class="form-group row">
                <label for="catatan" class="col-md-2 col-form-label">Catatan</label>
                <div class="col-md-4">
                    <textarea class="form-control" name="catatan" id="catatan" rows="3" placeholder="Enter Catatan">{{old("catatan")}}</textarea>
                </div>
            </div>

            <table class="table table-bordered align-middle">
                <thead>
                    <tr class="text-center">
                        <th width="50"><button class="btn btn-sm btn-primary" id="btn-tambah" type="button"><i class="fa fa-plus"></i></button></th>
                        <th>Lokasi Penyimpanan</th>
                        <th>Barang</th>
                        <th width="150">Harga Satuan</th>
                        <th width="100">Jumlah</th>
                        <th width="150">Harga Total</th>
                        <th width="150">Keterangan</th>
                    </tr>
                </thead>
                <tbody id="tb-detail">

                </tbody>
            </table>

            <div class="form-group row">
                <div class="col-md-4 offset-sm-2">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{url("transaksi/barang-masuk")}}" class="btn btn-secondary">Batal</a>
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
                <td><input type="text" name="harga_satuan[]" id="harga_satuan" class="form-control harga_satuan numeric2" width="100" /></td>
                <td><input type="text" name="jumlah_pesan[]" id="jumlah_pesan" class="form-control jumlah_pesan numeric2" /></td>
                <td><input type="text" name="harga_total[]" id="harga_total" class="form-control harga_total numeric2" readonly /></td>
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
        $("body").delegate(".harga_satuan,.jumlah_pesan", "change", function () {
            let tr     = $(this).closest("tr");
            let harga  = $(".harga_satuan", tr).val();
            let jumlah = $(".jumlah_pesan", tr).val();
            $(".harga_total", tr).val(harga*jumlah);
        });
    });
</script>
@endsection