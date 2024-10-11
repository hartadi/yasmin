<?php

namespace App\Models\Transaksi;

use App\Models\Master\Barang;
use Illuminate\Database\Eloquent\Model;

class FifoMasuk extends Model
{
    protected $table      = "t_fifo_masuk";
    public    $timestamps = false;
    protected $primaryKey = "id";
    protected $guarded    = ["id"];

    public function barang()
    {
        return $this->belongsTo(Barang::class, "barang_id");
    }

    public function fifo_keluar()
    {
        return $this->hasMany(FifoKeluar::class, "fifo_masuk_id");
    }
}
