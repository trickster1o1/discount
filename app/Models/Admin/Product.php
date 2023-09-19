<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';

    protected $fillable = [
        'title','price','slug', 'status', 'created_by', 'updated_by', 'thumb_image', 'featured_image','imga','imgb','imgc','imgd', 'description', 'short_description', 'meta_key', 'meta_description', 'fb_title', 'fb_description', 'fb_image', 'twitter_title', 'twitter_description', 'twitter_image', 'category', 'tags', 'is_featured',
    ];

    public $sortable  = ['title', 'category','price','status'];


    
    public static function getTotal($filter = [])
    {
        $query = Product::join('categories', 'products.category', '=', 'categories.id')
            ->where('products.status', '!=', 'deleted');
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where(function($group) use ($filter){
                $group->where('products.title', 'like', '%' . $filter['filter_search_text'] . '%');
                $group->orWhere('categories.title', 'like', '%' . $filter['filter_search_text'] . '%');
            });
        }
        $total_data = $query->count();
        return $total_data;
    }

    public static function getData($sort = [], $pagination = [], $filter = [])
    {
        $query = Product::select(['products.*', 'categories.title as category_title'])
            ->join('categories', 'products.category', '=', 'categories.id')
            ->where('products.status', '!=', 'deleted');
        //filter conditions begins
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where(function($group) use ($filter){
                $group->where('products.title', 'like', '%' . $filter['filter_search_text'] . '%');
                $group->orWhere('categories.title', 'like', '%' . $filter['filter_search_text'] . '%');
                $group->orWhere('products.price', 'like', '%' . $filter['filter_search_text'] . '%');
            });
        }
        //filter condition ends
        $products = $query->orderby($sort['field'], $sort['position'])->offset($pagination['offset'])->limit($pagination['limit'])->get();
        return $products;
    }


    public function discount() {
        return $this->hasOne(Discount::class);
    }

    public function category($id) {
        return Category::where('id',$id)->first()->title;
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }

}
