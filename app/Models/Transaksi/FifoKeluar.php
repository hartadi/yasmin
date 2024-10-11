<?php

namespace App\Models\Transaksi;

use App\Models\Master\Barang;
use Illuminate\Database\Eloquent\Model;

class FifoKeluar extends Model
{
    protected $table      = "t_fifo_keluar";
    public    $timestamps = false;
    protected $primaryKey = "id";
    protected $guarded    = ["id"];

    public function barang()
    {
        return $this->belongsTo(Barang::class, "barang_id");
    }

    public function fifo_masuk()
    {
        return $this->belongsTo(FifoMasuk::class, "fifo_masuk_id");
    }
}
