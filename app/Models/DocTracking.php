<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocTracking extends Model
{
    use HasFactory;
    protected $fillable = ['no_po','id_pol','id_pod', 'status','status_kapal','created_by'];
    protected $table = 'doc_tracking';
    // d_tracking

    public function detailTracking()
    {
        return $this->hasOne(DetailTracking::class,'id_track','id_track');
    }
    
    public function detailTrackingMultiple()
    {
        return $this->hasMany(DetailTracking::class,'id_track','id_track');
    }

    public function po()
    {
        return $this->hasOne(PurchaseOrder::class,'po_muat','no_po');
    }

    public function portOfLoading()
    {
        return $this->hasOne(PortOfLoading::class,'id','id_pol');
    }

    public function portOfDestination()
    {
        return $this->hasOne(PortOfDestination::class,'id','id_pod');
    }
}