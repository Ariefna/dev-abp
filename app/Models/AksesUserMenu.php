<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AksesUserMenu extends Model
{
    protected $table = 'akses_user_menu'; // Menyatakan nama tabel

    protected $primaryKey = 'akses_user_menu_id'; // Menyatakan primary key

    public $timestamps = true; // Menyatakan penggunaan timestamps

    protected $fillable = [
        'akses_group_id', // Menyatakan kolom-kolom yang dapat diisi (fillable)
        'menu_halaman_id',
    ];
}
