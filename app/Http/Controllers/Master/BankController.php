<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Bank;
use App\Models\Transaksi\BarangKeluar;
use App\Models\Transaksi\PembukuanHarian;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function getIndex(Request $request)
    {
        $q    = $request->q ?? "";
        $data = Bank::whereRaw(
            "?='' OR kode_bank LIKE ? OR nama_bank LIKE ?",
            [$q, "%$q%", "%$q%"]
        )->orderByRaw("kode_bank")->paginate();
        return view("master.bank.index", compact("data", "q"));
    }

    public function getTambah(Request $request)
    {
        return view("master.bank.tambah");
    }

    public function postTambah(Request $request)
    {
        $request->validate([
            "kode_bank" => "required",
            "nama_bank" => "required",
        ]);

        Bank::create([
            "kode_bank" => $request->kode_bank,
            "nama_bank" => $request->nama_bank,
        ]);
        return redirect("master/bank")->with("success", "Berhasil menambah bank.");
    }

    public function getEdit($id)
    {
        $data = Bank::find($id);
        return view("master.bank.edit", compact("data"));
    }

    public function postEdit(Request $request, $id)
    {
        $request->validate([
            "kode_bank" => "required",
            "nama_bank" => "required",
        ]);
        $data = Bank::find($id);
        $data->update([
            "kode_bank" => $request->kode_bank,
            "nama_bank" => $request->nama_bank,
        ]);
        return redirect("master/bank")->with("success", "Berhasil mengedit bank.");
    }

    public function postHapus($id)
    {
        $is_digunakan = PembukuanHarian::whereRaw("id_m_bank=?", [$id])->count();
        if ($is_digunakan > 0) {
            return response()->json("Tidak bisa dihapus, digunakan di pembukuan harian.", 500);
        }
        $data = Bank::find($id);
        $data->delete();
        return response()->json("Ok");
    }
}
