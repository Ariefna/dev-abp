<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    use HasFactory;
    protected $fillable = ['no_po','id_gudang', 'id_pol','id_pod','id_kapal', 'qty_muat', 'qty_timbang','jml_bag','nopol','no_container','voyage', 'tgl_muat','td','td_jkt','eta','file_name','file_path','status'];
}
