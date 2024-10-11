<?php

namespace App\Models\Master;

use App\Models\Transaksi\FifoMasuk;
use Illuminate\Database\Eloquent\Model;

class Konsumen extends Model
{
    protected $table      = "m_konsumen";
    public    $timestamps = false;
    protected $primaryKey = "id_m_konsumen";
    protected $guarded    = ["id_m_konsumen"];
}
