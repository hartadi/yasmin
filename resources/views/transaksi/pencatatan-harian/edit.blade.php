@extends('layouts.app')
@section('title') Edit Pencatatan Pembukuan Harian @endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST">
            @csrf

            <div class="form-group row">
                <label for="no_transaksi" class="col-md-2 col-form-label">No Transaksi</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="no_transaksi" id="no_transaksi" placeholder="auto" readonly value="{{old("no_transaksi")??$data->no_transaksi}}" />
                </div>
            </div>

            <div class="form-group row">
                <label for="tanggal_transaksi" class="col-md-2 col-form-label">Tanggal Transaksi</label>
                <div class="col-md-4">
                    <input type="text" class="form-control datepicker" name="tanggal_transaksi" id="tanggal_transaksi" data-toggle="datetimepicker" data-target="#tanggal_transaksi" value="{{old("tanggal_transaksi")??$data->tanggal_transaksi}}" />
                </div>
            </div>

            <div class="form-group row">
                <label for="jenis_transaksi" class="col-md-2 col-form-label">Jenis Transaksi</label>
                <div class="col-md-4">
                    <select class="form-control" name="jenis_transaksi" id="jenis_transaksi" placeholder="Pilih Jenis Transaksi">
                        <option value="">Pilih Jenis Transaksi</option>
                        <option value="penerimaan" @selected((old("jenis_transaksi")??$data->jenis_transaksi)=="penerimaan")>Penerimaan</option>
                        <option value="pengeluaran" @selected((old("jenis_transaksi")??$data->jenis_transaksi)=="pengeluaran")>Pengeluaran</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="tipe_transaksi" class="col-md-2 col-form-label">Tipe Transaksi</label>
                <div class="col-md-4">
                    <select class="form-control" name="tipe_transaksi" id="tipe_transaksi" placeholder="Pilih Tipe Transaksi">
                        <option value="">Pilih Tipe Transaksi</option>
                        <option value="tunai" @selected((old("tipe_transaksi")??$data->tipe_transaksi)=="tunai")>Cash / Tunai</option>
                        <option value="bank" @selected((old("tipe_transaksi")??$data->tipe_transaksi)=="bank")>Bank / Transfer / Cheque Giro</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="id_m_coa" class="col-md-2 col-form-label">Kode Akun / COA</label>
                <div class="col-md-4">
                    <select class="form-control" name="id_m_coa" id="id_m_coa" placeholder="Pilih Kode Akun / COA" readonly>
                        <option value="">Pilih Akun</option>
                        @foreach ($akun_list as $key => $item)
                        <option value="{{$key}}" @selected((old("id_m_coa")??$data->id_m_coa)==$key)>{{$item}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="id_m_bank" class="col-md-2 col-form-label">Bank</label>
                <div class="col-md-4">
                    <select class="form-control" name="id_m_bank" id="id_m_bank" placeholder="Pilih Bank" readonly>
                        <option value="">Pilih Bank</option>
                        @foreach ($bank_list as $key => $item)
                        <option value="{{$key}}" @selected((old("id_m_bank")??$data->id_m_bank)==$key)>{{$item}}</option>
                        @endforeach
                    </select>
                </div>
            </div>


            <div class="form-group row">
                <label for="nilai_transaksi" class="col-md-2 col-form-label">Nominal Transaksi</label>
                <div class="col-md-4">
                    <input type="text" class="form-control numeric" name="nilai_transaksi" id="nilai_transaksi" placeholder="Nominal Transaksi" value="{{old("nilai_transaksi") ?? $data->nilai_transaksi}}" />
                </div>
            </div>

            <div class="form-group row">
                <label for="keterangan" class="col-md-2 col-form-label">Keterangan</label>
                <div class="col-md-4">
                    <textarea class="form-control" name="keterangan" id="keterangan" rows="3" placeholder="Keterangan">{{old("keterangan")??$data->keterangan}}</textarea>
                </div>
            </div>

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
        $("#jenis_transaksi,#tipe_transaksi").change(function () {
            let jenis_transaksi = $("#jenis_transaksi").val();
            let tipe_transaksi  = $("#tipe_transaksi").val();
            if(jenis_transaksi == "" || tipe_transaksi == "") return;
            if (jenis_transaksi == "penerimaan") {
                if(tipe_transaksi == "tunai") {
                    $("#id_m_coa").val(1);
                    $("#id_m_bank").val("");
                    $("#id_m_bank").attr("readonly","readonly");
                } else {
                    $("#id_m_coa").val(3);
                    $("#id_m_bank").val("");
                    $("#id_m_bank").removeAttr("readonly");
                }
            } else {
                if(tipe_transaksi == "tunai") {
                    $("#id_m_coa").val(2);
                    $("#id_m_bank").val("");
                    $("#id_m_bank").attr("readonly","readonly");
                } else {
                    $("#id_m_coa").val(4);
                    $("#id_m_bank").val("");
                    $("#id_m_bank").removeAttr("readonly");
                }
            }
        });
    });
</script>
@endsection