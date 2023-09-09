<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocTracking extends Model
{
    use HasFactory;
    protected $fillable = ['no_po','id_pol','id_pod', 'status'];
    protected $table = 'doc_tracking';
    // d_tracking
}
