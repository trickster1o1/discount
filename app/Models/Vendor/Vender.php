<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vender extends Model
{
    use HasFactory;
    protected $fillable = [
        'vendor_name','address','name','email','number','categorey','password'
    ];
}
