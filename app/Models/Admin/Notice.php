<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use HasFactory;

    protected $table = 'notices';

    protected $fillable = [
        'title',
        'slug',
        'status',
        'category',
        'sub_category',
        'published_date',
        'publish_time',
        'expiary_time',
        'expiary_date',
        'short_description',
        'thumb_image',
        'featured_image',
        'banner_image',
        'description',
        'is_featured',
        'order_by',
        'publish_as_popup',
        'attached_file_url',
        'meta_key',
        'meta_description',
        'fb_title',
        'fb_image',
        'created_by',
        'updated_by',
        'fb_description',
        'twitter_image',
        'twitter_title',
        'twitter_description'
    ];
    public static function getTotal($filter = [])
    {
        $query = Notice::join('categories', 'notices.category', '=', 'categories.id')
            ->join('sub_categories', 'notices.sub_category', '=', 'sub_categories.id','left')
            ->where('notices.status', '!=', 'deleted');
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where('notices.title', 'like', '%' . $filter['filter_search_text'] . '%');
            $query->orWhere('categories.title', 'like', '%' . $filter['filter_search_text'] . '%');
            $query->orWhere('sub_categories.title', 'like', '%' . $filter['filter_search_text'] . '%');
            $query->orWhere('notices.published_date', 'like', '%' . $filter['filter_search_text'] . '%');
        }
        $total_data = $query->count();
        return $total_data;
    }

    public static function getData($sort = [], $pagination = [], $filter = [])
    {
        $query = Notice::select(['notices.*', 'categories.title as category_title', 'sub_categories.title as sub_category_title'])
            ->join('categories', 'notices.category', '=', 'categories.id')
            ->join('sub_categories', 'notices.sub_category', '=', 'sub_categories.id','left')
            ->where('notices.status', '!=', 'deleted');
        //filter conditions begins
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where('notices.title', 'like', '%' . $filter['filter_search_text'] . '%');
            $query->orWhere('categories.title', 'like', '%' . $filter['filter_search_text'] . '%');
            $query->orWhere('sub_categories.title', 'like', '%' . $filter['filter_search_text'] . '%');
            $query->orWhere('notices.published_date', 'like', '%' . $filter['filter_search_text'] . '%');
        }
        //filter condition ends
        $notices = $query->orderby($sort['field'], $sort['position'])->offset($pagination['offset'])->limit($pagination['limit'])->get();
        return $notices;
    }
}
