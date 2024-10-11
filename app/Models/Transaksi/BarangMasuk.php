<?php

namespace App\Models\Transaksi;

use App\Models\Master\Departemen;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    protected $table      = "t_barangmasuk_h";
    public    $timestamps = false;
    protected $primaryKey = "id_t_barangmasuk_h";
    protected $guarded    = ["id_t_barangmasuk_h"];

    public function detail()
    {
        return $this->hasMany(BarangMasukDetail::class, "id_t_barangmasuk_h");
    }

    public function departemen()
    {
        return $this->belongsTo(Departemen::class, "id_m_departemen");
    }
}
