<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTrackingSisa extends Model
{
    use HasFactory;

    protected $fillable = ['id_track','qty_tonase_sisa','qty_total_tonase','status','tipe'];
    protected $table = 'detail_tracking_sisa';
}
