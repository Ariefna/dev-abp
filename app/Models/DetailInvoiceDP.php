<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailInvoiceDP extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_invoice_dp',
        'id_track',
        'total_harga',
        'sub_total',
        'prosentase_dp',
        'total_dp',
        'prosentase_ppn',
        'total_ppn',
        'status'
    ];
    protected $table = 'detail_invoice_dp';
}
