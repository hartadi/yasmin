<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function getIndex(Request $request)
    {
        $q    = $request->q ?? "";
        $data = Barang::with("satuan")->whereRaw("?='' OR kode_barang LIKE ? OR nama_barang LIKE ?", [$q, "%$q%", "%$q%"])->orderByRaw("nama_barang")->paginate();
        return view("master.barang.index", compact("data", "q"));
    }

    public function getTambah(Request $request)
    {
        return view("master.barang.tambah");
    }

    public function postTambah(Request $request)
    {
        $request->validate(["nama_barang" => "required"]);
        barang::create(["nama_barang" => $request->nama_barang]);
        return redirect("master/barang")->with("success", "Berhasil menambah barang.");
    }

    public function getEdit($id)
    {
        $data = barang::find($id);
        return view("master.barang.edit", compact("data"));
    }

    public function postEdit(Request $request, $id)
    {
        $request->validate(["nama_barang" => "required"]);
        $data = barang::find($id);
        $data->update(["nama_barang" => $request->nama_barang]);
        return redirect("master/barang")->with("success", "Berhasil mengedit barang.");
    }

    public function postHapus($id)
    {
        $is_barang = Barang::whereRaw("id_m_barang=?", [$id])->count();
        if ($is_barang > 0) {
            return response()->json("Tidak bisa dihapus, digunakan di master barang.", 500);
        }
        $data = barang::find($id);
        $data->delete();
        return response()->json("Ok");
    }
}
