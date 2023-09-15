<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penerima extends Model
{
    use HasFactory;
    protected $fillable = ['id_pt_penerima', 'id_grup', 'alamat', 'estate','status'];

    public function ptPenerima()
    {
        return $this->hasOne(ptPenerima::class,'id_pt_penerima','id_pt_penerima');
    }
}
