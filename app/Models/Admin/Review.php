<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $table = 'reviews';
    protected $fillable = [
        'product_id', 'user', 'rating', 'review', 'status',
    ];
    public $sortable = ['rating', 'review', 'status'];

    public static function getTotal($filter = [])
    {
        $query = Review::join('users', 'reviews.user', '=', 'users.username')
            ->where('reviews.status', '!=', 'deleted');
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where(function ($group) use ($filter) {
                $group->where('reviews.review', 'like', '%' . $filter['filter_search_text'] . '%');
                $group->orWhere('users.name', 'like', '%' . $filter['filter_search_text'] . '%');
                $group->orWhere('reviews.rating', 'like', '%' . $filter['filter_search_text'] . '%');
            });
        }
        $total_data = $query->count();
        return $total_data;
    }

    public static function getData($sort = [], $pagination = [], $filter = [])
    {
        $query = Review::select(['reviews.*', 'users.name as user_name'])
            ->join('users', 'reviews.user', '=', 'users.username')
            ->where('reviews.status', '!=', 'deleted');
        //filter conditions begins
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where(function ($group) use ($filter) {
                $group->where('reviews.review', 'like', '%' . $filter['filter_search_text'] . '%');
                $group->orWhere('users.name', 'like', '%' . $filter['filter_search_text'] . '%');
                $group->orWhere('reviews.rating', 'like', '%' . $filter['filter_search_text'] . '%');
            });
        }
        //filter condition ends
        $reviews = $query->orderby($sort['field'], $sort['position'])->offset($pagination['offset'])->limit($pagination['limit'])->get();
        return $reviews;
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function user($unm) {
        return User::where('username',$unm)->first();
    }
}
