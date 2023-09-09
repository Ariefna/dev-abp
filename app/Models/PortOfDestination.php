<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortOfDestination extends Model
{
    use HasFactory;
    protected $fillable = ['nama_pod','status'];
    protected $table = 'port_of_destination';
}
