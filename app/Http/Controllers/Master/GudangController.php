<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Gudang;
use Illuminate\Http\Request;

class GudangController extends Controller
{
    public function getIndex(Request $request)
    {
        $q    = $request->q ?? "";
        $data = Gudang::whereRaw("?='' OR nama_gudang LIKE ?", [$q, "%$q%"])->orderByRaw("nama_gudang")->paginate();
        return view("master.gudang.index", compact("data", "q"));
    }

    public function getTambah(Request $request)
    {
        return view("master.gudang.tambah");
    }

    public function postTambah(Request $request)
    {
        $request->validate(["nama_gudang" => "required"]);
        Gudang::create(["nama_gudang" => $request->nama_gudang]);
        return redirect("master/gudang")->with("success", "Berhasil menambah gudang.");
    }

    public function getEdit($id)
    {
        $data = Gudang::find($id);
        return view("master.gudang.edit", compact("data"));
    }

    public function postEdit(Request $request, $id)
    {
        $request->validate(["nama_gudang" => "required"]);
        $data = Gudang::find($id);
        $data->update(["nama_gudang" => $request->nama_gudang]);
        return redirect("master/gudang")->with("success", "Berhasil mengedit gudang.");
    }

    public function postHapus($id)
    {
        $is_barang = Gudang::whereRaw("id_m_gudang=?", [$id])->count();
        if ($is_barang > 0) {
            return response()->json("Tidak bisa dihapus, digunakan di master barang.", 500);
        }
        $data = Gudang::find($id);
        $data->delete();
        return response()->json("Ok");
    }
}
