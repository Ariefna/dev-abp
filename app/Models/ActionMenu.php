<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionMenu extends Model
{
    use HasFactory;
    protected $table = 'action_menu'; // Nama tabel dalam database

    protected $fillable = [
        'nama_action',
        'menu_halaman_id',
        'status',
    ];

    public function menuHalaman()
    {
        return $this->belongsTo(MenuHalaman::class, 'menu_halaman_id');
    }
}
