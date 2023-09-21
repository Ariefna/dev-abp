<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDP extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_bank',
        'id_track',
        'invoice_date',
        'invoice_no',
        'tipe_job',
        'rinci_tipe',
        'terms',
        'total_invoice',
        'status'
    ];
    protected $table = 'invoice_dp';

    public function docTracking()
    {
        return $this->hasOne(DocTracking::class,'id_track','id_track');
    }

    public function detailInvoiceDp()
    {
        return $this->hasMany(DetailInvoiceDP::class,'id_invoice_dp','id_invoice_dp');
    }
}
