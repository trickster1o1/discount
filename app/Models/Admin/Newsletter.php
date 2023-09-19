<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    use HasFactory;
    protected $fillable = [
        'title','date','description','thumb_image','attachment','order_by','created_by',
        'updated_by','status','slug',
    ];
    protected $table = 'newsletters';
    public $sortable = ['status','title','date','order_by'];



    public static function getTotal($filter = [])
    {
        $query = Newsletter::where('status', '!=', 'deleted');
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where('title', 'like', '%' . $filter['filter_search_text'] . '%')
            ->orWhere('date','like', '%' . $filter['filter_search_text'] . '%')
            ->where('status','!=','deleted');
        }
        $total_data = $query->count();
        return $total_data;
    }

    public static function getData($sort = [], $pagination = [], $filter = [])
    {
        $query = Newsletter::where('status', '!=', 'deleted');
        //filter conditions begins
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where('title', 'like', '%' . $filter['filter_search_text'] . '%');
            $query->orWhere('date', 'like', '%' . $filter['filter_search_text'] . '%');
            $query->where('status', '!=','deleted');
        }
        //filter condition ends
        $categories = $query->orderby($sort['field'], $sort['position'])->offset($pagination['offset'])->limit($pagination['limit'])->get();
        return $categories;
    }

}
