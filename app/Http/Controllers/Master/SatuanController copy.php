<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Barang;
use App\Models\Master\Satuan;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
    public function getIndex(Request $request)
    {
        $q    = $request->q ?? "";
        $data = Satuan::whereRaw("?='' OR nama_satuan LIKE ?", [$q, "%$q%"])->orderByRaw("nama_satuan")->paginate();
        return view("master.satuan.index", compact("data", "q"));
    }

    public function getTambah(Request $request)
    {
        return view("master.satuan.tambah");
    }

    public function postTambah(Request $request)
    {
        $request->validate(["nama_satuan" => "required"]);
        Satuan::create(["nama_satuan" => $request->nama_satuan]);
        return redirect("master/satuan")->with("success", "Berhasil menambah satuan.");
    }

    public function getEdit($id)
    {
        $data = Satuan::find($id);
        return view("master.satuan.edit", compact("data"));
    }

    public function postEdit(Request $request, $id)
    {
        $request->validate(["nama_satuan" => "required"]);
        $data = Satuan::find($id);
        $data->update(["nama_satuan" => $request->nama_satuan]);
        return redirect("master/satuan")->with("success", "Berhasil mengedit satuan.");
    }

    public function postHapus($id)
    {
        $is_barang = Barang::whereRaw("id_m_satuan=?", [$id])->count();
        if ($is_barang > 0) {
            return response()->json("Tidak bisa dihapus, digunakan di master barang.", 500);
        }
        $data = Satuan::find($id);
        $data->delete();
        return response()->json("Ok");
    }
}
