<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailInvoicePel extends Model
{
    protected $table = 'detail_invoice_pel'; // Nama tabel di database
    protected $primaryKey = 'id_detail_pel'; // Kolom primary key
    public $timestamps = true; // Aktifkan timestamps (created_at dan updated_at)

    protected $fillable = [
        'id_invoice_pel',
        'estate',
        'total_tonase_dooring',
        'total_tonase_timbang',
        'total_tonase_real',
        'total_harga_dooring',
        'total_harga_timbang',
        'total_harga_real',
        'harga_brg',
        'prosentase_ppn',
        'total_ppn',
        'tipe',
        'status',
    ];
}
