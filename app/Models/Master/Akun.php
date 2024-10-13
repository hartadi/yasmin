<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{
    protected $table      = "m_akun";
    public    $timestamps = false;
    protected $primaryKey = "id_m_akun";
    protected $guarded    = ["id_m_akun"];
}
