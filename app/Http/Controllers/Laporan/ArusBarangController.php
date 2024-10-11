<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Master\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArusBarangController extends Controller
{
    public function getIndex(Request $request)
    {
        $barang_list   = Barang::join("m_satuan AS s", "m_barang.id_m_satuan", "=", "s.id_m_satuan")
            ->orderByRaw("nama_barang")->selectRaw("id_m_barang,CONCAT_WS(' - ',kode_barang,nama_barang,s.nama_satuan) AS nama_barang")->pluck("nama_barang", "id_m_barang");
        $barang    = null;
        $data      = [];
        $barang_id = $request->barang_id;
        if ($barang_id) {
            $barang = Barang::find($request->barang_id);
            $data   = DB::select("SELECT tanggal_terima AS tanggal,jumlah_masuk,0 AS jumlah_keluar,harga,jumlah_masuk*harga AS saldo_masuk,0 AS saldo_keluar FROM t_fifo_masuk WHERE barang_id=?
            UNION
            SELECT k.tanggal,0,k.jumlah,m.harga,0,k.jumlah*m.harga FROM t_fifo_keluar k JOIN t_fifo_masuk m ON k.fifo_masuk_id=m.id WHERE k.barang_id=?
            ORDER BY tanggal", [$barang->id_m_barang, $barang->id_m_barang]);
        }
        return view("laporan.arus-barang.index", compact("barang_list", "barang", "data", "barang_id"));
    }
}
