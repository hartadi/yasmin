<?php

namespace App\Models\Transaksi;

use Illuminate\Database\Eloquent\Model;

class BarangMasukDetail extends Model
{
    protected $table      = "t_barangmasuk_d";
    public    $timestamps = false;
    protected $primaryKey = "id_t_barangmasuk_d";
    protected $guarded    = ["id_t_barangmasuk_d"];

    public function barang_masuk()
    {
        return $this->belongsTo(BarangMasuk::class, "id_t_barangmasuk_h");
    }
}
