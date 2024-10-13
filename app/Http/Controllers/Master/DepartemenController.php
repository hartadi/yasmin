<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Departemen;
use Illuminate\Http\Request;

class DepartemenController extends Controller
{
    public function getIndex(Request $request)
    {
        $q    = $request->q ?? "";
        $data = Departemen::whereRaw("?='' OR nama_departemen LIKE ?", [$q, "%$q%"])->orderByRaw("nama_departemen")->paginate();
        return view("master.departemen.index", compact("data", "q"));
    }

    public function getTambah(Request $request)
    {
        return view("master.departemen.tambah");
    }

    public function postTambah(Request $request)
    {
        $request->validate(["nama_departemen" => "required"]);
        Departemen::create(["nama_departemen" => $request->nama_departemen]);
        return redirect("master/departemen")->with("success", "Berhasil menambah departemen.");
    }

    public function getEdit($id)
    {
        $data = Departemen::find($id);
        return view("master.departemen.edit", compact("data"));
    }

    public function postEdit(Request $request, $id)
    {
        $request->validate(["nama_departemen" => "required"]);
        $data = Departemen::find($id);
        $data->update(["nama_departemen" => $request->nama_departemen]);
        return redirect("master/departemen")->with("success", "Berhasil mengedit departemen.");
    }

    public function postHapus($id)
    {
        $is_barang = Departemen::whereRaw("id_m_departemen=?", [$id])->count();
        if ($is_barang > 0) {
            return response()->json("Tidak bisa dihapus, digunakan di master barang.", 500);
        }
        $data = Departemen::find($id);
        $data->delete();
        return response()->json("Ok");
    }
}
