<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\Master\Barang;
use App\Models\Master\Departemen;
use App\Models\Master\Gudang;
use App\Models\Transaksi\BarangMasuk;
use App\Models\Transaksi\BarangMasukDetail;
use App\Models\Transaksi\FifoMasuk;
use App\Models\Transaksi\Piutang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PiutangController extends Controller
{
    public function getIndex(Request $request)
    {
        $q    = $request->q ?? "";
        $data = Piutang::whereRaw(
            "?='' OR no_transaksi LIKE ? OR pic_piutang LIKE ? OR keterangan LIKE ?",
            [$q, "%$q%", "%$q%", "%$q%"]
        )->orderByRaw("tanggal_transaksi DESC")->paginate();

        $status_piutang = DB::select("SELECT
            (SELECT sum(nominal_piutang) FROM t_piutang WHERE status_lunas='belum') AS belum_lunas,
            (SELECT sum(nominal_piutang) FROM t_piutang WHERE status_lunas='sudah') AS sudah_lunas")[0];

        return view("transaksi.piutang.index", compact("data", "status_piutang"));
    }

    public function getTambah()
    {
        return view("transaksi.piutang.tambah");
    }
    public function postTambah(Request $request)
    {
        $request->validate([
            "tanggal_transaksi" => "required|date",
            "pic_piutang"       => "required",
            "nominal_piutang"   => "required|numeric",
            "keterangan"        => "required",
            "status_lunas"      => "required",
        ]);

        try {
            DB::beginTransaction();
            Piutang::create([
                "no_transaksi"      => $this->get_no_transaksi($request->tanggal_transaksi),
                "tanggal_transaksi" => date("Y-m-d", strtotime($request->tanggal_transaksi)),
                "pic_piutang"       => $request->pic_piutang,
                "nominal_piutang"   => $request->nominal_piutang,
                "keterangan"        => $request->keterangan,
                "status_lunas"      => $request->status_lunas,
            ]);
            DB::commit();
            return redirect("transaksi/piutang")->with("success", "Berhasil menambah Piutang.");
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($th->getMessage());
        }
    }

    public function getEdit($id)
    {
        $data = Piutang::find($id);
        return view("transaksi.piutang.edit", compact("data"));
    }
    public function postEdit(Request $request, $id)
    {
        $request->validate([
            "tanggal_transaksi" => "required|date",
            "pic_piutang"       => "required",
            "nominal_piutang"   => "required|numeric",
            "keterangan"        => "required",
            "status_lunas"      => "required",
        ]);

        try {
            DB::beginTransaction();
            $piutang = Piutang::find($id);
            $piutang->update([
                // "no_transaksi"      => $this->get_no_transaksi($request->tanggal_transaksi),
                "tanggal_transaksi" => date("Y-m-d", strtotime($request->tanggal_transaksi)),
                "pic_piutang"       => $request->pic_piutang,
                "nominal_piutang"   => $request->nominal_piutang,
                "keterangan"        => $request->keterangan,
                "status_lunas"      => $request->status_lunas,
            ]);
            DB::commit();
            return redirect("transaksi/piutang")->with("success", "Berhasil mengedit Piutang.");
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($th->getMessage());
        }
    }

    public function postHapus($id)
    {
        $data = Piutang::find($id);
        $data->delete();
        return response()->json("Ok");
    }

    function get_no_transaksi($tanggal_transaksi)
    {
        $prefix  = format("PIUTANG-{0}-", date('m-Y', strtotime($tanggal_transaksi)));
        $last_no = Piutang::whereRaw("no_transaksi LIKE ?", "$prefix%")
            ->orderByRaw("no_transaksi DESC")->lockForUpdate()->first();
        $no = $last_no ? (intval(str_replace($prefix, "", $last_no->no_transaksi)) + 1) : 1;
        return $prefix . str_pad($no, 4, "0", STR_PAD_LEFT);
    }
}
