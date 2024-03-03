<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailDooringSisa extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_door_sisa';
    protected $fillable = ['id_dooring','qty_tonase_sisa','qty_total_tonase','status','tipe'];
    protected $table = 'detail_dooring_sisa';
}