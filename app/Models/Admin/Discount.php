<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    protected $table = 'discounts';
    protected $fillable = [
        'product_id','type','value','status','created_by','updated_by',
    ];

    public $sortable  = ['value', 'type','status'];


    
    public static function getTotal($filter = [])
    {
        $query = Discount::join('products', 'discounts.product_id', '=', 'products.id')
            ->where('discounts.status', '!=', 'deleted');
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where(function($group) use ($filter){
                $group->where('products.title', 'like', '%' . $filter['filter_search_text'] . '%');
                $group->orWhere('discounts.value', 'like', '%' . $filter['filter_search_text'] . '%');
                $group->orWhere('discounts.type', 'like', '%' . $filter['filter_search_text'] . '%');
            });
        }
        $total_data = $query->count();
        return $total_data;
    }

    public static function getData($sort = [], $pagination = [], $filter = [])
    {
        $query = Discount::select(['discounts.*', 'products.title as product_title'])
            ->join('products', 'discounts.product_id', '=', 'products.id')
            ->where('discounts.status', '!=', 'deleted');
        //filter conditions begins
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where(function($group) use ($filter){
                $group->where('products.title', 'like', '%' . $filter['filter_search_text'] . '%');
                $group->orWhere('discounts.value', 'like', '%' . $filter['filter_search_text'] . '%');
                $group->orWhere('discounts.type', 'like', '%' . $filter['filter_search_text'] . '%');
                $group->orWhere('products.price', 'like', '%' . $filter['filter_search_text'] . '%');
            });
        }
        //filter condition ends
        $discounts = $query->orderby($sort['field'], $sort['position'])->offset($pagination['offset'])->limit($pagination['limit'])->get();
        return $discounts;
    }



    public function Product() {
        return $this->belongsTo(Product::class);
    }
}
