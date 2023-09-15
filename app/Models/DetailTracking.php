<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTracking extends Model
{
    use HasFactory;
    protected $fillable = ['id_track','id_gudang','id_kapal', 'qty_tonase', 'qty_timbang','jml_sak','nopol','no_container','voyage', 'no_segel','tgl_muat','td','td_jkt','ta','no_sj','sj_file_name','sj_file_path','st_file_name','st_file_path','status'];
    protected $table = 'detail_tracking';    

    public function docTracking()
    {
        return $this->belongsTo(DocTracking::class,'id_track','id_track');
    }
}
