<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailDooring extends Model
{
    use HasFactory;
    protected $fillable = ['id_dooring','tgl_muat','tgl_tiba','nopol','qty_tonase','qty_timbang','jml_sak','no_tiket','st_file_name','st_file_path','no_sj','sj_file_name','sj_file_path','tipe','status'];
    protected $table = 'detail_dooring';
}
