<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kapal extends Model
{
    use HasFactory;
    protected $fillable = ['id_company_port', 'nama_kapal','kode_kapal','status'];

    public function cPort()
    {
        return $this->hasOne(CPort::class,'id_company_port','id_company_port');
    }
}
