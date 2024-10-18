<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Barang;
use App\Models\Master\Gudang;
use App\Models\Transaksi\BarangMasukDetail;
use Illuminate\Http\Request;

class GudangController extends Controller
{
    public function getIndex(Request $request)
    {
        $q    = $request->q ?? "";
        $data = Gudang::whereRaw("?='' OR nama_gudang LIKE ?", [$q, "%$q%"])->orderByRaw("kode_gudang")->paginate();
        return view("master.gudang.index", compact("data", "q"));
    }

    public function getTambah(Request $request)
    {
        return view("master.gudang.tambah");
    }

    public function postTambah(Request $request)
    {
        $request->validate(["nama_gudang" => "required"]);
        Gudang::create(["kode_gudang" => $this->get_kode(), "nama_gudang" => $request->nama_gudang, "keterangan" => $request->keterangan]);
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
        $data->update(["nama_gudang" => $request->nama_gudang, "keterangan" => $request->keterangan]);
        return redirect("master/gudang")->with("success", "Berhasil mengedit gudang.");
    }

    public function postHapus($id)
    {
        $is_digunakan = BarangMasukDetail::whereRaw("id_m_gudang=?", [$id])->count();
        if ($is_digunakan > 0) {
            return response()->json("Tidak bisa dihapus, sudah digunakan untuk transaksi.", 500);
        }
        $data = Gudang::find($id);
        $data->delete();
        return response()->json("Ok");
    }

    function get_kode()
    {
        $prefix  = "G";
        $last_no = Gudang::whereRaw("kode_gudang LIKE ?", "$prefix%")
            ->orderByRaw("kode_gudang DESC")->lockForUpdate()->first();
        $no = $last_no ? (intval(str_replace($prefix, "", $last_no->kode_gudang)) + 1) : 1;
        return $prefix . $no;
    }
}
