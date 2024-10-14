<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Barang;
use App\Models\Master\Konsumen;
use App\Models\Transaksi\BarangKeluar;
use Illuminate\Http\Request;

class KonsumenController extends Controller
{
    public function getIndex(Request $request)
    {
        $q    = $request->q ?? "";
        $data = Konsumen::whereRaw(
            "?='' OR kode_konsumen LIKE ? OR nama_konsumen LIKE ? OR alamat LIKE ? OR no_telp LIKE ? OR email LIKE ?",
            [$q, "%$q%", "%$q%", "%$q%", "%$q%", "%$q%"]
        )->orderByRaw("kode_konsumen")->paginate();
        return view("master.konsumen.index", compact("data", "q"));
    }

    public function getTambah(Request $request)
    {
        return view("master.konsumen.tambah");
    }

    public function postTambah(Request $request)
    {
        $request->validate([
            "nama_konsumen" => "required",
            "alamat"        => "",
            "no_telp"       => "",
            "email"         => "nullable|email"
        ]);

        Konsumen::create([
            "kode_konsumen" => $this->get_kode(),
            "nama_konsumen" => $request->nama_konsumen,
            "alamat"        => $request->alamat,
            "no_telp"       => $request->no_telp,
            "email"         => $request->email
        ]);
        return redirect("master/konsumen")->with("success", "Berhasil menambah konsumen.");
    }

    public function getEdit($id)
    {
        $data = Konsumen::find($id);
        return view("master.konsumen.edit", compact("data"));
    }

    public function postEdit(Request $request, $id)
    {
        $request->validate([
            "nama_konsumen" => "required",
            "alamat"        => "",
            "no_telp"       => "",
            "email"         => "nullable|email"
        ]);
        $data = Konsumen::find($id);
        $data->update([
            "nama_konsumen" => $request->nama_konsumen,
            "alamat"        => $request->alamat,
            "no_telp"       => $request->no_telp,
            "email"         => $request->email
        ]);
        return redirect("master/konsumen")->with("success", "Berhasil mengedit konsumen.");
    }

    public function postHapus($id)
    {
        $is_digunakan = BarangKeluar::whereRaw("id_m_konsumen=?", [$id])->count();
        if ($is_digunakan > 0) {
            return response()->json("Tidak bisa dihapus, digunakan di barang keluar.", 500);
        }
        $data = Konsumen::find($id);
        $data->delete();
        return response()->json("Ok");
    }

    function get_kode()
    {
        $prefix  = "C";
        $last_no = Konsumen::whereRaw("kode_konsumen LIKE ?", "$prefix%")
            ->orderByRaw("kode_konsumen DESC")->lockForUpdate()->first();
        $no = $last_no ? (intval(str_replace($prefix, "", $last_no->kode_konsumen)) + 1) : 1;
        return $prefix . $no;
    }
}
