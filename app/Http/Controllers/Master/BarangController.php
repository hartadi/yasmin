<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Barang;
use App\Models\Master\Satuan;
use App\Models\Transaksi\BarangMasuk;
use App\Models\Transaksi\FifoKeluar;
use App\Models\Transaksi\FifoMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BarangController extends Controller
{
    public function getIndex(Request $request)
    {
        $q    = $request->q ?? "";
        $data = Barang::with("satuan")->whereRaw("?='' OR kode_barang LIKE ? OR nama_barang LIKE ?", [$q, "%$q%", "%$q%"])->orderByRaw("kode_barang")->paginate();
        return view("master.barang.index", compact("data", "q"));
    }

    public function getTambah(Request $request)
    {
        $satuan_list = Satuan::orderByRaw("nama_satuan")->pluck("nama_satuan", "id_m_satuan");
        return view("master.barang.tambah", compact("satuan_list"));
    }

    public function postTambah(Request $request)
    {
        $request->validate(["nama_barang" => "required", "id_m_satuan" => "required"]);
        try {
            DB::beginTransaction();

            $barang = Barang::create([
                "kode_barang"     => $this->get_kode(),
                "nama_barang"     => $request->nama_barang,
                "id_m_satuan"     => $request->id_m_satuan,
                "minimal_stock"   => $request->minimal_stock ?? 0,
                "stock_awal"      => $request->stock_awal ?? 0,
                "stock_masuk"     => 0,
                "harga_pembelian" => $request->harga_pembelian ?? 0,
                "harga_jual"      => $request->harga_jual ?? 0
            ]);

            FifoMasuk::create([
                "barang_id"      => $barang->id_m_barang,
                "ref_id"         => 0,
                "tanggal_terima" => '1900-01-01',
                "harga"          => $barang->harga_pembelian,
                "jumlah_masuk"   => $barang->stock_awal,
                "jumlah_keluar"  => 0
            ]);

            DB::commit();
            return redirect("master/barang")->with("success", "Berhasil menambah barang.");
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($th->getMessage());
        }
    }

    public function getEdit($id)
    {
        $data        = Barang::find($id);
        $satuan_list = Satuan::orderByRaw("nama_satuan")->pluck("nama_satuan", "id_m_satuan");

        return view("master.barang.edit", compact("data", "satuan_list"));
    }

    public function postEdit(Request $request, $id)
    {
        $request->validate(["nama_barang" => "required", "id_m_satuan" => "required"]);
        try {
            DB::beginTransaction();

            $barang = Barang::find($id);
            $barang->update([
                "nama_barang"   => $request->nama_barang,
                "id_m_satuan"   => $request->id_m_satuan,
                "minimal_stock" => $request->minimal_stock ?? 0,
                "harga_jual"    => $request->harga_jual ?? 0
            ]);

            $fifo_masuk = FifoMasuk::whereRaw("barang_id=? AND ref_id=0 AND tanggal_terima='1900-01-01'", [$barang->id_m_barang])->first();
            $fifo_message = "";
            if ($fifo_masuk->fifo_keluar->count() == 0) {
                $barang->update(["harga_pembelian" => $request->harga_pembelian, "stock_awal" => $request->stock_awal]);
                $fifo_masuk->update(["harga" => $barang->harga_pembelian, "jumlah_masuk" => $barang->stock_awal]);
            } else {
                $fifo_message = "Stok Awal Barang tidak diupdate, karena sudah digunakan untuk transaksi barang keluar.";
            }

            DB::commit();
            return redirect("master/barang")->with("success", "Berhasil mengedit barang. " . $fifo_message);
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($th->getMessage());
        }
    }

    public function postHapus($id)
    {
        $is_barang_masuk = FifoMasuk::whereRaw("barang_id=? AND ref_id<>0 AND tanggal_terima<>'1900-01-01'", [$id])->count();
        $is_barang_keluar = FifoKeluar::whereRaw("barang_id=?", [$id])->count();
        if ($is_barang_masuk > 0 || $is_barang_keluar > 0) {
            return response()->json("Tidak bisa dihapus, sudah digunakan untuk transaksi.", 500);
        }
        $data = Barang::find($id);
        $data->delete();
        return response()->json("Ok");
    }

    function get_kode()
    {
        $prefix  = "MB-";
        $last_no = Barang::whereRaw("kode_barang LIKE ?", "$prefix%")
            ->orderByRaw("kode_barang DESC")->lockForUpdate()->first();
        $no = $last_no ? (intval(str_replace($prefix, "", $last_no->kode_barang)) + 1) : 1;
        return $prefix . str_pad($no, 5, "0", STR_PAD_LEFT);;
    }
}
