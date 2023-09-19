<?php

namespace App\Models;

use App\Models\Admin\Product;
use App\Models\Admin\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id','product_id','sub_total','vat','total','quantity',
    ];
    
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function product($id) {
        return Product::where('id',$id)->first();
    }
}
