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

class SaldoBarangController extends Controller
{
    public function getIndex(Request $request)
    {
        $q      = $request->q ?? "";
        $data = DB::select("SELECT b.kode_barang,b.nama_barang,s.nama_satuan,b.stock_awal,
            (SELECT SUM(jumlah_masuk) FROM t_fifo_masuk WHERE barang_id=b.id_m_barang) AS jumlah_masuk,
            (SELECT SUM(jumlah_keluar) FROM t_fifo_masuk WHERE barang_id=b.id_m_barang) AS jumlah_keluar,
            b.stock_awal*b.harga_pembelian AS saldo_awal,
            (SELECT SUM(saldo_masuk) FROM t_fifo_masuk WHERE barang_id=b.id_m_barang) AS saldo_masuk,
            (SELECT SUM(saldo_keluar) FROM t_fifo_masuk WHERE barang_id=b.id_m_barang) AS saldo_keluar
            FROM m_barang b 
            JOIN m_satuan s ON b.id_m_satuan=s.id_m_satuan;");

        return view("laporan.saldo-barang.index", compact("data"));
    }
}
