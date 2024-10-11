<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\Master\Barang;
use App\Models\Master\Departemen;
use App\Models\Master\Gudang;
use App\Models\Master\Konsumen;
use App\Models\Transaksi\BarangKeluar;
use App\Models\Transaksi\BarangKeluarDetail;
use App\Models\Transaksi\BarangMasuk;
use App\Models\Transaksi\BarangMasukDetail;
use App\Models\Transaksi\FifoKeluar;
use App\Models\Transaksi\FifoMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BarangKeluarController extends Controller
{
    public function getIndex(Request $request)
    {
        $q    = $request->q ?? "";
        $data = BarangKeluar::with("konsumen")->whereRaw(
            "?='' OR no_barangkeluar LIKE ? OR no_invoice LIKE ? OR pic LIKE ? OR keterangan LIKE ?",
            [$q, "%$q%", "%$q%", "%$q%", "%$q%"]
        )->orderByRaw("tanggal_barangkeluar DESC")->paginate();

        return view("transaksi.barang-keluar.index", compact("data"));
    }

    public function getTambah()
    {
        $konsumen_list = Konsumen::orderByRaw("nama_konsumen")->selectRaw("id_m_konsumen,CONCAT_WS(' - ',kode_konsumen,nama_konsumen,no_telp) AS nama_konsumen")->pluck("nama_konsumen", "id_m_konsumen");
        $gudang_list   = Gudang::orderByRaw("nama_gudang")->selectRaw("id_m_gudang,CONCAT_WS(' - ',kode_gudang,nama_gudang) AS nama_gudang")->pluck("nama_gudang", "id_m_gudang");
        $barang_list   = Barang::join("m_satuan AS s", "m_barang.id_m_satuan", "=", "s.id_m_satuan")
            ->orderByRaw("nama_barang")->selectRaw("id_m_barang,CONCAT_WS(' - ',kode_barang,nama_barang,s.nama_satuan) AS nama_barang")->pluck("nama_barang", "id_m_barang");

        return view("transaksi.barang-keluar.tambah", compact("konsumen_list", "gudang_list", "barang_list"));
    }
    public function postTambah(Request $request)
    {
        $request->validate([
            "tanggal_barangkeluar" => "required|date",
            "id_m_konsumen"        => "required",
            "no_invoice"           => "",
            "pic"                  => "",
            "keterangan"           => "",

            "id_m_barang"        => "required|array",
            "id_m_gudang"        => "required|array",
            "jumlah_pengeluaran" => "required|array",
            "catatan_detail"     => "array",

            "jumlah_pengeluaran.*" => "numeric",
        ]);

        try {
            DB::beginTransaction();
            $barang_keluar = BarangKeluar::create([
                "no_barangkeluar"      => $this->get_no_transaksi($request->tanggal_barangkeluar),
                "tanggal_barangkeluar" => date("Y-m-d", strtotime($request->tanggal_barangkeluar)),
                "id_m_konsumen"        => $request->id_m_konsumen,
                "no_invoice"           => $request->no_invoice,
                "pic"                  => $request->pic,
                "keterangan"           => $request->keterangan,
            ]);

            $barang_id          = $request->id_m_barang;
            $gudang_id          = $request->id_m_gudang;
            $jumlah_pengeluaran = $request->jumlah_pengeluaran;
            $catatan_detail     = $request->catatan_detail;

            foreach ($barang_id as $i => $item) {
                BarangKeluarDetail::create([
                    "id_t_barangkeluar_h" => $barang_keluar->id_t_barangkeluar_h,
                    "id_m_barang"         => $barang_id[$i],
                    "id_m_gudang"         => $gudang_id[$i],
                    "jumlah_pengeluaran"  => $jumlah_pengeluaran[$i],
                    "catatan"             => $catatan_detail[$i]
                ]);

                $item_jumlah_keluar = $jumlah_pengeluaran[$i];
                $fifo_masuk         = FifoMasuk::whereRaw("barang_id=? AND jumlah_sisa>0", [$barang_id[$i]])->orderBy('tanggal_terima')->get();
                if ($item_jumlah_keluar > $fifo_masuk->sum("jumlah_sisa")) {
                    return redirect()->back()->withInput()->with("error", "Jumlah barang keluar melebihi sisa stok tersedia di gudang.");
                }

                foreach ($fifo_masuk as $batch) {
                    if ($batch->jumlah_sisa >= $item_jumlah_keluar) {
                        $batch->jumlah_keluar += $item_jumlah_keluar;
                        $batch->save();

                        $batch_jumlah_keluar   = $item_jumlah_keluar;
                        FifoKeluar::create([
                            'barang_id'     => $barang_id[$i],
                            'fifo_masuk_id' => $batch->id,
                            'tanggal'       => $barang_keluar->tanggal_barangkeluar,
                            'jumlah'        => $batch_jumlah_keluar,
                            'ref_id'        => $barang_keluar->id_t_barangkeluar_h,
                        ]);
                        break;
                    } else {
                        $batch_jumlah_keluar   = $batch->jumlah_sisa;
                        $item_jumlah_keluar   -= $batch->jumlah_sisa;
                        $batch->jumlah_keluar += $batch->jumlah_sisa;
                        $batch->save();

                        FifoKeluar::create([
                            'barang_id'     => $barang_id[$i],
                            'fifo_masuk_id' => $batch->id,
                            'tanggal'       => $barang_keluar->tanggal_barangkeluar,
                            'jumlah'        => $batch_jumlah_keluar,
                            'ref_id'        => $barang_keluar->id_t_barangkeluar_h,
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect("transaksi/barang-keluar")->with("success", "Berhasil menambah Barang Keluar.");
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($th->getMessage());
        }
    }

    function get_no_transaksi($tanggal_transaksi)
    {
        $prefix  = format("BK-{0}", date('m-Y', strtotime($tanggal_transaksi)));
        $last_no = BarangKeluar::whereRaw("no_barangkeluar LIKE ?", "$prefix%")
            ->orderByRaw("no_barangkeluar DESC")->lockForUpdate()->first();
        $no = $last_no ? (intval(str_replace($prefix, "", $last_no->no_barangkeluar)) + 1) : 1;
        return $prefix . str_pad($no, 4, "0", STR_PAD_LEFT);
    }
}
