<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;
    protected $fillable = ['po_muat','po_kebun', 'no_pl','simb','tgl', 'id_detail_ph', 'id','qty','qty2','total_curah','total_container','total_qty','total_all','file_name','file_path','status'];
    
    public function detailPhs()
    {
        return $this->hasOne(DetailPH::class,'id_detail_ph','id_detail_ph');
    }
}
