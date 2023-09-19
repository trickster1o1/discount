<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';

    protected $fillable = ['title', 'slug', 'thumb_image', 'banner_image', 'is_featured', 'status', 'gallery_id', 'related_services', 'short_description', 'description', 'order_by', 'meta_key', 'meta_description', 'fb_title', 'fb_description', 'fb_image', 'twitter_title', 'twitter_description', 'twitter_image','icon_class','featured_image',
        'created_by','updated_by',
    ];

    public static function getTotal($filter = [])
    {
        $query = Service::where('services.status', '!=', 'deleted');
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where('services.title', 'like', '%' . $filter['filter_search_text'] . '%');
        }
        $total_data = $query->count();
        return $total_data;
    }

    public static function getData($sort = [], $pagination = [], $filter = [])
    {
        $query = Service::select(['services.*'])
            ->where('services.status', '!=', 'deleted');
        //filter conditions begins
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where('services.title', 'like', '%' . $filter['filter_search_text'] . '%');
        }
        //filter condition ends
        $services = $query->orderby($sort['field'], $sort['position'])->offset($pagination['offset'])->limit($pagination['limit'])->get();
        return $services;
    }
}
