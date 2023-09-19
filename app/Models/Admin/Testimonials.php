<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonials extends Model
{
    use HasFactory;
    protected $fillable = [
        'title','image','message','name','status'
    ];
    protected $table = 'testimonials';
    public $sortable = ['status','title','name','message'];

    public static function getTotal($filter = [])
    {
        $query = Testimonials::where('status', '!=', 'deleted');
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where('name', 'like', '%' . $filter['filter_search_text'] . '%')
            ->orWhere('message','like', '%' . $filter['filter_search_text'] . '%')
            ->orWhere('title','like', '%' . $filter['filter_search_text'] . '%')
            ->where('status','!=','deleted');
        }
        $total_data = $query->count();
        return $total_data;
    }

    public static function getData($sort = [], $pagination = [], $filter = [])
    {
        $query = Testimonials::where('status', '!=', 'deleted');
        //filter conditions begins
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where('name', 'like', '%' . $filter['filter_search_text'] . '%');
            $query->where('message', 'like', '%' . $filter['filter_search_text'] . '%');
            $query->orWhere('title', 'like', '%' . $filter['filter_search_text'] . '%');
            $query->where('status', '!=','deleted');
        }
        //filter condition ends
        $categories = $query->orderby($sort['field'], $sort['position'])->offset($pagination['offset'])->limit($pagination['limit'])->get();
        return $categories;
    }

}
