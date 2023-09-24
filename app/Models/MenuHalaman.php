<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuHalaman extends Model
{
    use HasFactory;

    protected $table = 'menu_halaman'; // Nama tabel dalam database

    protected $fillable = ['nama_menu_halaman', 'status', 'isadmin'];
}
