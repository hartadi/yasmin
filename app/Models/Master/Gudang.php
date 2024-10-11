<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gudang extends Model
{
    protected $table      = "m_gudang";
    public    $timestamps = false;
    protected $primaryKey = "id_m_gudang";
    protected $guarded    = ["id_m_gudang"];
}
