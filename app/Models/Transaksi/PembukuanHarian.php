<?php

namespace App\Models\Transaksi;

use App\Models\Master\Akun;
use App\Models\Master\Bank;
use Illuminate\Database\Eloquent\Model;

class PembukuanHarian extends Model
{
    protected $table      = "t_pembukuanharian";
    public    $timestamps = false;
    protected $primaryKey = "id_t_pembukuanharian";
    protected $guarded    = ["id_t_pembukuanharian"];

    public function akun()
    {
        return $this->hasMany(Akun::class, "id_m_coa");
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class, "id_m_bank");
    }
}
