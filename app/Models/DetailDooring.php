<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailDooring extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_dooring',
        'tgl_muat',
        'tgl_tiba',
        'nopol',
        'estate',
        'qty_tonase',
        'qty_timbang',
        'jml_sak',
        'no_tiket',
        'st_file_name',
        'st_file_path',
        'no_sj',
        'sj_file_name',
        'sj_file_path',
        'tipe',
        'status',
        'id_kapal'
    ];
    protected $table = 'detail_dooring';

    public function detailTracking()
    {
        return $this->hasOne(DetailTracking::class,'id_kapal','id_kapal');
    }
    
    public function sisa()
    {
        return $this->hasOne(DetailDooringSisa::class,'id_dooring','id_dooring');
    }
    
    public function docDooring()
    {
        return $this->hasOne(DocDooring::class,'id_dooring','id_dooring');
    }
}
