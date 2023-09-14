<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GudangMuat extends Model
{
    use HasFactory;
    protected $fillable = ['id_gudang','nama_gudang','kota','alamat','status'];
    protected $table = 'gudang_muats';
    protected $primaryKey = 'id_gudang';
}
