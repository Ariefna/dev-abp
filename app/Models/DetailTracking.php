<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTracking extends Model
{
    use HasFactory;
    protected $fillable = ['id_track','id_gudang','id_kapal', 'qty_tonase', 'qty_timbang','jml_sak','nopol','no_container','voyage', 'no_segel','tgl_muat','td','td_jkt','ta','no_sj',
    'sj_file_name','sj_file_path','st_file_name','st_file_path',
    'status','harga_hpp','track_file','track_path','door_file','door_path'];
    protected $table = 'detail_tracking';    

    public function docTracking()
    {
        return $this->belongsTo(DocTracking::class,'id_track','id_track');
    }
    
    public function kapal()
    {
        return $this->hasOne(Kapal::class,'id','id_kapal');
    }
}
