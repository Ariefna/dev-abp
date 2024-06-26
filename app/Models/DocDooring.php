<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocDooring extends Model
{
    use HasFactory;
    
    protected $fillable = ['id_track','id_detail_track','sb_file_name','sb_file_path','sr_file_name','sr_file_path','status','created_by'];
    protected $table = 'doc_dooring';

    public function detailDooring()
    {
        return $this->hasMany(DetailDooring::class,'id_dooring','id_dooring');
    }
    
    public function docTracking()
    {
        return $this->hasOne(DocTracking::class,'id_track','id_track');
    }
    public function invoiceDp()
    {
        return $this->hasMany(InvoiceDp::class,'id_track','id_track');
    }
    public function detailTracking()
    {
        return $this->hasMany(DetailDooring::class,'id_detail_track','id_detail_track');
    }
}
