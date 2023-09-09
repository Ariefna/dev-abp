<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortOfLoading extends Model
{
    use HasFactory;
    protected $fillable = ['nama_pol','status'];
    protected $table = 'port_of_loading';
}
