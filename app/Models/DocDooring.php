<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocDooring extends Model
{
    use HasFactory;
    
    protected $fillable = ['id_track','id_detail_track','sb_file_name','sb_file_path','sr_file_name','sr_file_path','status'];
    protected $table = 'doc_dooring';
}
