<?php

namespace App\Http\Controllers\Transaksi;

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

class PiutangController extends Controller
{
    public function getIndex(Request $request)
    {
        $q    = $request->q ?? "";
        $data = BarangMasuk::with("departemen")->whereRaw(
            "?='' OR no_barangmasuk LIKE ? OR no_penerimaan LIKE ? OR pic LIKE ? OR catatan LIKE ?",
            [$q, "%$q%", "%$q%", "%$q%", "%$q%"]
        )->orderByRaw("tanggal_barangmasuk DESC")->paginate();

        return view("transaksi.barang-masuk.index", compact("data"));
    }

    public function getTambah()
    {
        $departemen_list = Departemen::orderByRaw("nama_departemen")->selectRaw("id_m_departemen,CONCAT_WS(' - ',kode_departemen,nama_departemen) AS nama_departemen")->pluck("nama_departemen", "id_m_departemen");
        $gudang_list     = Gudang::orderByRaw("nama_gudang")->selectRaw("id_m_gudang,CONCAT_WS(' - ',kode_gudang,nama_gudang) AS nama_gudang")->pluck("nama_gudang", "id_m_gudang");
        $barang_list     = Barang::join("m_satuan AS s", "m_barang.id_m_satuan", "=", "s.id_m_satuan")
            ->orderByRaw("nama_barang")->selectRaw("id_m_barang,CONCAT_WS(' - ',kode_barang,nama_barang,s.nama_satuan) AS nama_barang")->pluck("nama_barang", "id_m_barang");

        return view("transaksi.barang-masuk.tambah", compact("departemen_list", "gudang_list", "barang_list"));
    }
    public function postTambah(Request $request)
    {
        $request->validate([
            "tanggal_barangmasuk" => "required|date",
            "id_m_departemen"     => "required",
            "no_penerimaan"       => "",
            "pic"                 => "",
            "catatan"             => "",

            "id_m_barang"    => "required|array",
            "id_m_gudang"    => "required|array",
            "harga_satuan"   => "required|array",
            "jumlah_pesan"   => "required|array",
            "harga_total"    => "array",
            "catatan_detail" => "array",

            "harga_satuan.*" => "numeric",
            "jumlah_pesan.*" => "numeric",
        ]);

        try {
            DB::beginTransaction();
            $barang_masuk = BarangMasuk::create([
                "no_barangmasuk"      => $this->get_no_transaksi($request->tanggal_barangmasuk),
                "tanggal_barangmasuk" => date("Y-m-d", strtotime($request->tanggal_barangmasuk)),
                "id_m_departemen"     => $request->id_m_departemen,
                "no_penerimaan"       => $request->no_penerimaan,
                "pic"                 => $request->pic,
                "catatan"             => $request->catatan,
            ]);

            $barang_id      = $request->id_m_barang;
            $gudang_id      = $request->id_m_gudang;
            $harga_satuan   = $request->harga_satuan;
            $jumlah_pesan   = $request->jumlah_pesan;
            $catatan_detail = $request->catatan_detail;



            foreach ($barang_id as $i => $item) {
                BarangMasukDetail::create([
                    "id_t_barangmasuk_h" => $barang_masuk->id_t_barangmasuk_h,
                    "id_m_barang"        => $barang_id[$i],
                    "id_m_gudang"        => $gudang_id[$i],
                    "harga_satuan"       => $harga_satuan[$i],
                    "jumlah_pesan"       => $jumlah_pesan[$i],
                    "harga_total"        => $harga_satuan[$i] * $jumlah_pesan[$i],
                    "catatan"            => $catatan_detail[$i]
                ]);

                FifoMasuk::create([
                    "barang_id"      => $barang_id[$i],
                    "ref_id"         => $barang_masuk->id_t_barangmasuk_h,
                    "tanggal_terima" => $barang_masuk->tanggal_barangmasuk,
                    "harga"          => $harga_satuan[$i],
                    "jumlah_masuk"   => $jumlah_pesan[$i],
                    "jumlah_keluar"  => 0
                ]);
            }

            DB::commit();
            return redirect("transaksi/barang-masuk")->with("success", "Berhasil menambah Barang Masuk.");
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($th->getMessage());
        }
    }

    function get_no_transaksi($tanggal_transaksi)
    {
        $prefix  = format("BM-{0}", date('m-Y', strtotime($tanggal_transaksi)));
        $last_no = BarangMasuk::whereRaw("no_barangmasuk LIKE ?", "$prefix%")
            ->orderByRaw("no_barangmasuk DESC")->lockForUpdate()->first();
        $no = $last_no ? (intval(str_replace($prefix, "", $last_no->no_barangmasuk)) + 1) : 1;
        return $prefix . str_pad($no, 4, "0", STR_PAD_LEFT);
    }
}
