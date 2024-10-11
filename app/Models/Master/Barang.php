<?php

namespace App\Models\Master;

use App\Models\Transaksi\FifoMasuk;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table      = "m_barang";
    public    $timestamps = false;
    protected $primaryKey = "id_m_barang";
    protected $guarded    = ["id_m_barang"];

    public function fifo_masuk()
    {
        return $this->hasMany(FifoMasuk::class, "barang_id");
    }
}
