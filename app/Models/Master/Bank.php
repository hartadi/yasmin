<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $table      = "m_bank";
    public    $timestamps = false;
    protected $primaryKey = "id_m_bank";
    protected $guarded    = ["id_m_bank"];
}
