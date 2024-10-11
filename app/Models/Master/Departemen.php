<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    protected $table      = "m_departemen";
    public    $timestamps = false;
    protected $primaryKey = "id_m_departemen";
    protected $guarded    = ["id_m_departemen"];
}
