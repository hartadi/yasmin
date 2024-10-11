<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Master\Barang;
use App\Models\Master\Departemen;
use App\Models\Master\Gudang;
use App\Models\Transaksi\BarangMasuk;
use App\Models\Transaksi\BarangMasukDetail;
use App\Models\Transaksi\FifoMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ArusBarangController extends Controller
{
    public function getIndex(Request $request)
    {
        $q      = $request->q ?? "";
        $barang = Barang::find(3);
        $data   = FifoMasuk::with("fifo_keluar")->whereRaw("barang_id=?", [$barang->id_m_barang])->orderByRaw("tanggal_terima")->get();

        return view("laporan.arus-barang.index", compact("barang", "data"));
    }
}
