<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GudangMuat extends Model
{
    use HasFactory;
    protected $fillable = ['nama_gudang','kota','alamat','status'];
}
