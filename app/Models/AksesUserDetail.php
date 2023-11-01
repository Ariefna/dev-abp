<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AksesUserDetail extends Model
{
    protected $table = 'akses_user_detail'; // Menyatakan nama tabel

    protected $primaryKey = 'akses_user_detail_id'; // Menyatakan primary key

    public $timestamps = true; // Menyatakan penggunaan timestamps

    protected $fillable = [
        'akses_group_id', // Kolom-kolom yang dapat diisi
        'action_menu_id',
        // 'created_at', 'updated_at' tidak perlu dimasukkan ke $fillable karena Eloquent akan menangani kolom ini secara otomatis
    ];
}