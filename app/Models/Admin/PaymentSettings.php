<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentSettings extends Model
{
    use HasFactory;
    protected $fillable = [
        'merchant_id','esewa_id','paypal_form','paypal_qr',
        'created_by','updated_by',
    ];
}
