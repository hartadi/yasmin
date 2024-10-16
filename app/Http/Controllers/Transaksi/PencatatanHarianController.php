<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\Master\Akun;
use App\Models\Master\Bank;
use App\Models\Transaksi\PembukuanHarian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PencatatanHarianController extends Controller
{
    public function getIndex(Request $request)
    {
        $q    = $request->q ?? "";
        $data = PembukuanHarian::whereRaw(
            "?='' OR no_transaksi LIKE ? OR keterangan LIKE ?",
            [$q, "%$q%", "%$q%"]
        )->orderByRaw("tanggal_transaksi DESC")->paginate();

        return view("transaksi.pencatatan-harian.index", compact("data"));
    }

    public function getTambah()
    {
        $akun_list = Akun::orderByRaw("kode_coa")->selectRaw("id_m_coa,CONCAT_WS(' - ',kode_coa,nama_coa) AS nama_coa")->pluck("nama_coa", "id_m_coa");
        $bank_list = Bank::orderByRaw("nama_bank")->selectRaw("id_m_bank,CONCAT_WS(' - ',kode_bank,nama_bank) AS nama_bank")->pluck("nama_bank", "id_m_bank");

        return view("transaksi.pencatatan-harian.tambah", compact("akun_list", "bank_list"));
    }
    public function postTambah(Request $request)
    {
        $request->validate([
            "tanggal_transaksi" => "required|date",
            "jenis_transaksi"   => "required",
            "tipe_transaksi"    => "required",
            "id_m_coa"          => "required",
            "id_m_bank"         => "required_if:tipe_transaksi,bank",
            "nilai_transaksi"   => "required|numeric",
            "keterangan"        => ""
        ]);

        try {
            DB::beginTransaction();

            $prefix          = "";
            $jenis_transaksi = $request->jenis_transaksi;
            $tipe_transaksi  = $request->tipe_transaksi;
            $nilai_debet     = 0;
            $nilai_credit    = 0;
            if ($jenis_transaksi == "penerimaan") {
                $nilai_debet = $request->nilai_transaksi;
                if ($tipe_transaksi == "tunai") {
                    $prefix = "KM";
                } else {
                    $prefix = "BM";
                }
            } else {
                $nilai_credit = $request->nilai_transaksi;
                if ($tipe_transaksi == "tunai") {
                    $prefix = "KK";
                } else {
                    $prefix = "BK";
                }
            }

            $coa  = Akun::find($request->id_m_coa);
            $bank = Bank::find($request->id_m_bank);
            PembukuanHarian::create([
                "no_transaksi"      => $this->get_no_transaksi($request->tanggal_transaksi, $prefix),
                "tanggal_transaksi" => date("Y-m-d", strtotime($request->tanggal_transaksi)),
                "jenis_transaksi"   => $request->jenis_transaksi,
                "tipe_transaksi"    => $request->tipe_transaksi,
                "id_m_coa"          => $request->id_m_coa,
                "coa"               => $coa ? $coa->kode_coa . " - " . $coa->nama_coa : "",
                "id_m_bank"         => $request->id_m_bank,
                "bank"              => $bank ? $bank->kode_bank . " - " . $bank->nama_bank : "",
                "nilai_transaksi"   => $request->nilai_transaksi,
                "nilai_debet"       => $nilai_debet,
                "nilai_credit"      => $nilai_credit,
                "keterangan"        => $request->keterangan,
            ]);

            DB::commit();
            return redirect("transaksi/pencatatan-harian")->with("success", "Berhasil menambah Pencatatan Pembukuan Harian.");
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($th->getMessage());
        }
    }

    public function getEdit($id)
    {
        $data = PembukuanHarian::find($id);

        $akun_list = Akun::orderByRaw("kode_coa")->selectRaw("id_m_coa,CONCAT_WS(' - ',kode_coa,nama_coa) AS nama_coa")->pluck("nama_coa", "id_m_coa");
        $bank_list = Bank::orderByRaw("nama_bank")->selectRaw("id_m_bank,CONCAT_WS(' - ',kode_bank,nama_bank) AS nama_bank")->pluck("nama_bank", "id_m_bank");

        return view("transaksi.pencatatan-harian.edit", compact("data", "akun_list", "bank_list"));
    }
    public function postEdit(Request $request, $id)
    {
        $request->validate([
            "tanggal_transaksi" => "required|date",
            "jenis_transaksi"   => "required",
            "tipe_transaksi"    => "required",
            "id_m_coa"          => "required",
            "id_m_bank"         => "required_if:tipe_transaksi,bank",
            "nilai_transaksi"   => "required|numeric",
            "keterangan"        => ""
        ]);

        try {
            DB::beginTransaction();

            $prefix          = "";
            $jenis_transaksi = $request->jenis_transaksi;
            $tipe_transaksi  = $request->tipe_transaksi;
            $nilai_debet     = 0;
            $nilai_credit    = 0;
            if ($jenis_transaksi == "penerimaan") {
                $nilai_debet = $request->nilai_transaksi;
                if ($tipe_transaksi == "tunai") {
                    $prefix = "KM";
                } else {
                    $prefix = "BM";
                }
            } else {
                $nilai_credit = $request->nilai_transaksi;
                if ($tipe_transaksi == "tunai") {
                    $prefix = "KK";
                } else {
                    $prefix = "BK";
                }
            }

            $coa  = Akun::find($request->id_m_coa);
            $bank = Bank::find($request->id_m_bank);
            $pembukuan = PembukuanHarian::find($id);
            $pembukuan->update([
                // "no_transaksi"      => $this->get_no_transaksi($request->tanggal_transaksi, $prefix),
                "tanggal_transaksi" => date("Y-m-d", strtotime($request->tanggal_transaksi)),
                "jenis_transaksi"   => $request->jenis_transaksi,
                "tipe_transaksi"    => $request->tipe_transaksi,
                "id_m_coa"          => $request->id_m_coa,
                "coa"               => $coa ? $coa->kode_coa . " - " . $coa->nama_coa : "",
                "id_m_bank"         => $request->id_m_bank,
                "bank"              => $bank ? $bank->kode_bank . " - " . $bank->nama_bank : "",
                "nilai_transaksi"   => $request->nilai_transaksi,
                "nilai_debet"       => $nilai_debet,
                "nilai_credit"      => $nilai_credit,
                "keterangan"        => $request->keterangan,
            ]);

            DB::commit();
            return redirect("transaksi/pencatatan-harian")->with("success", "Berhasil mengedit Pencatatan Pembukuan Harian.");
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($th->getMessage());
        }
    }

    public function postHapus($id)
    {
        $data = PembukuanHarian::find($id);
        $data->delete();
        return response()->json("Ok");
    }

    function get_no_transaksi($tanggal_transaksi, $prefix)
    {
        $prefix  = format("$prefix-{0}", date('m-Y', strtotime($tanggal_transaksi)));
        $last_no = PembukuanHarian::whereRaw("no_transaksi LIKE ?", "$prefix%")
            ->orderByRaw("no_transaksi DESC")->lockForUpdate()->first();
        $no = $last_no ? (intval(str_replace($prefix, "", $last_no->no_transaksi)) + 1) : 1;
        return $prefix . str_pad($no, 4, "0", STR_PAD_LEFT);
    }
}
