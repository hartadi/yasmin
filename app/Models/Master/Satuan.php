<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    protected $table      = "m_satuan";
    public    $timestamps = false;
    protected $primaryKey = "id_m_satuan";
    protected $guarded    = ["id_m_satuan"];

    public function barang()
    {
        return $this->hasMany(Barang::class, "id_m_satuan");
    }
}
