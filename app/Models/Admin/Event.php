<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'title','slug','category','sub_category','thumb_image','featured_image','banner_image','is_featured',
        'status','order_by','gallery_id','attached_file_url','start_date','start_time','end_date','end_time',
        'location','short_description','description','meta_key','meta_description','fb_title','fb_description',
        'fb_image','twitter_title','twitter_description','twitter_image','created_by','updated_by',
    ];
    protected $table = 'events';


    public static function getTotal($filter = [])
    {
        $query = Event::where('status', '!=', 'deleted');
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where('title', 'like', '%' . $filter['filter_search_text'] . '%')
            ->orWhere('start_date','like', '%' . $filter['filter_search_text'] . '%')
            ->where('status','!=','deleted');
        }
        $total_data = $query->count();
        return $total_data;
    }

    public static function getData($sort = [], $pagination = [], $filter = [])
    {
        $query = Event::where('status', '!=', 'deleted');
        //filter conditions begins
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where('title', 'like', '%' . $filter['filter_search_text'] . '%');
            $query->orWhere('start_date', 'like', '%' . $filter['filter_search_text'] . '%');
            $query->where('status', '!=','deleted');
        }
        //filter condition ends
        $categories = $query->orderby($sort['field'], $sort['position'])->offset($pagination['offset'])->limit($pagination['limit'])->get();
        return $categories;
    }

    
}
