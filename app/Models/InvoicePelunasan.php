<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicePelunasan extends Model
{
    use HasFactory;
    protected $table = 'invoice_pelunasan';
    protected $fillable = [
        'id_invoice_dp',
        'id_bank',
        'id_dooring',
        'invoice_date',
        'invoice_no',
        'tipe_job',
        'rinci_tipe',
        'terms',
        'total_invoice',
        'status',
    ];
}
