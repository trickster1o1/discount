<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmtpSetting extends Model
{
    use HasFactory;
    protected $fillable = [
        'hostname','port','auth','encryption','username','password','created_by','updated_by',
    ];
    

}
