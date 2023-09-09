<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PTpenerima extends Model
{
    use HasFactory;
    protected $fillable = ['nama_penerima','status'];
    protected $table = 'pt_penerima';
}
