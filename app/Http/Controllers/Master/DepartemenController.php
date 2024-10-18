<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Departemen;
use App\Models\Transaksi\BarangMasuk;
use Illuminate\Http\Request;

class DepartemenController extends Controller
{
    public function getIndex(Request $request)
    {
        $q    = $request->q ?? "";
        $data = Departemen::whereRaw("?='' OR nama_departemen LIKE ?", [$q, "%$q%"])->orderByRaw("kode_departemen")->paginate();
        return view("master.departemen.index", compact("data", "q"));
    }

    public function getTambah(Request $request)
    {
        return view("master.departemen.tambah");
    }

    public function postTambah(Request $request)
    {
        $request->validate(["nama_departemen" => "required"]);
        Departemen::create(["kode_departemen" => $this->get_kode(), "nama_departemen" => $request->nama_departemen, "pic" => $request->pic]);
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
        $data->update(["nama_departemen" => $request->nama_departemen, "pic" => $request->pic]);
        return redirect("master/departemen")->with("success", "Berhasil mengedit departemen.");
    }

    public function postHapus($id)
    {
        $is_digunakan = BarangMasuk::whereRaw("id_m_departemen=?", [$id])->count();
        if ($is_digunakan > 0) {
            return response()->json("Tidak bisa dihapus, sudah digunakan untuk transaksi.", 500);
        }
        $data = Departemen::find($id);
        $data->delete();
        return response()->json("Ok");
    }

    function get_kode()
    {
        $prefix  = "DEPT-";
        $last_no = Departemen::whereRaw("kode_departemen LIKE ?", "$prefix%")
            ->orderByRaw("kode_departemen DESC")->lockForUpdate()->first();
        $no = $last_no ? (intval(str_replace($prefix, "", $last_no->kode_departemen)) + 1) : 1;
        return $prefix . str_pad($no, 4, "0", STR_PAD_LEFT);;
    }
}
