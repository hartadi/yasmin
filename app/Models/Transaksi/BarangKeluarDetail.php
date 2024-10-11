<?php

namespace App\Models\Transaksi;

use Illuminate\Database\Eloquent\Model;

class BarangKeluarDetail extends Model
{
    protected $table      = "t_barangkeluar_d";
    public    $timestamps = false;
    protected $primaryKey = "id_t_barangkeluar_d";
    protected $guarded    = ["id_t_barangkeluar_d"];

    public function barang_keluar()
    {
        return $this->belongsTo(BarangKeluar::class, "id_t_barangkeluar_h");
    }
}
