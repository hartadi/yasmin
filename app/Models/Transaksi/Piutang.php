<?php

namespace App\Models\Transaksi;

use App\Models\Master\Akun;
use App\Models\Master\Bank;
use Illuminate\Database\Eloquent\Model;

class Piutang extends Model
{
    protected $table      = "t_piutang";
    public    $timestamps = false;
    protected $primaryKey = "id_t_piutang";
    protected $guarded    = ["id_t_piutang"];
}
