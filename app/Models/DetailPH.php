<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPH extends Model
{
    use HasFactory;
    protected $fillable = ['id_penawaran', 'id_penerima', 'oa_kpl_kayu','oa_container','status'];

    public function penerima()
    {
        return $this->hasOne(Penerima::class,'id_penerima','id_penerima');
    }
}
