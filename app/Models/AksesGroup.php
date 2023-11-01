<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AksesGroup extends Model
{
    protected $table = 'akses_group'; // Menyatakan nama tabel

    protected $primaryKey = 'akses_group_id'; // Menyatakan primary key

    public $timestamps = true; // Menyatakan penggunaan timestamps

    protected $fillable = [
        'nama', // Menyatakan kolom-kolom yang dapat diisi (fillable)
        // 'created_at', 'updated_at' tidak perlu dimasukkan ke $fillable karena Eloquent akan menangani kolom ini secara otomatis
    ];

    // Jika nama kolom timestamp tidak standar (bukan created_at dan updated_at), Anda perlu menyatakan secara manual seperti di bawah ini:
    // const CREATED_AT = 'nama_kolom_created_at';
    // const UPDATED_AT = 'nama_kolom_updated_at';
}
