<?php

namespace App\Models\Transaksi;

use App\Models\Master\Departemen;
use App\Models\Master\Konsumen;
use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    protected $table      = "t_barangkeluar_h";
    public    $timestamps = false;
    protected $primaryKey = "id_t_barangkeluar_h";
    protected $guarded    = ["id_t_barangkeluar_h"];

    public function detail()
    {
        return $this->hasMany(BarangKeluarDetail::class, "id_t_barangkeluar_h");
    }

    public function konsumen()
    {
        return $this->belongsTo(Konsumen::class, "id_m_konsumen");
    }
}
