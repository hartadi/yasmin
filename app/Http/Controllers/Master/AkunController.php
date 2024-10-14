<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Akun;
use App\Models\Transaksi\BarangKeluar;
use App\Models\Transaksi\PembukuanHarian;
use Illuminate\Http\Request;

class AkunController extends Controller
{
    public function getIndex(Request $request)
    {
        $q    = $request->q ?? "";
        $data = Akun::whereRaw(
            "?='' OR kode_coa LIKE ? OR nama_coa LIKE ? OR keterangan LIKE ?",
            [$q, "%$q%", "%$q%", "%$q%"]
        )->orderByRaw("kode_coa")->paginate();
        return view("master.akun.index", compact("data", "q"));
    }

    public function getTambah(Request $request)
    {
        return view("master.akun.tambah");
    }

    public function postTambah(Request $request)
    {
        $request->validate([
            "kode_coa"   => "required",
            "nama_coa"   => "required",
            "tipe_coa"   => "required",
            "keterangan" => "",
        ]);

        Akun::create([
            "kode_coa"   => $request->kode_coa,
            "nama_coa"   => $request->nama_coa,
            "tipe_coa"   => $request->tipe_coa,
            "keterangan" => $request->keterangan,
        ]);
        return redirect("master/akun")->with("success", "Berhasil menambah akun.");
    }

    public function getEdit($id)
    {
        $data = Akun::find($id);
        return view("master.akun.edit", compact("data"));
    }

    public function postEdit(Request $request, $id)
    {
        $request->validate([
            // "kode_coa"   => "required",
            "nama_coa"   => "required",
            "tipe_coa"   => "required",
            "keterangan" => "",
        ]);
        $data = Akun::find($id);
        $data->update([
            // "kode_coa"   => $request->kode_coa,
            "nama_coa"   => $request->nama_coa,
            "tipe_coa"   => $request->tipe_coa,
            "keterangan" => $request->keterangan,
        ]);
        return redirect("master/akun")->with("success", "Berhasil mengedit akun.");
    }

    public function postHapus($id)
    {
        $is_digunakan = PembukuanHarian::whereRaw("id_m_coa=?", [$id])->count();
        if ($is_digunakan > 0) {
            return response()->json("Tidak bisa dihapus, digunakan di pembukuan harian.", 500);
        }
        $data = Akun::find($id);
        $data->delete();
        return response()->json("Ok");
    }
}
