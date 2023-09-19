<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class InternalLinks extends Model
{
    use HasFactory, Sortable;

    protected $table = 'internal_links';

    protected $fillable = [ 'created_by','updated_by', 'title', 'slug', 'tagline', 'short_description', 'description', 'meta_key', 'meta_description', 'fb_title', 'fb_description', 'fb_image', 'twitter_image', 'twitter_description', 'twitter_title', 'status','featured_image','thumb_image','banner_image'];

    public $sortable = ['title', 'tagline', 'status'];

    public static function getTotal($filter = [])
    {
        $query = InternalLinks::where('internal_links.status', '!=', 'deleted');
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where(function($group) use ($filter){
                $group->where('internal_links.title', 'like', '%' . $filter['filter_search_text'] . '%');
                $group->orwhere('internal_links.tagline', 'like', '%' . $filter['filter_search_text'] . '%');
            });
        }
        $total_data = $query->count();
        return $total_data;
    }

    public static function getData($sort = [], $pagination = [], $filter = [])
    {
        $query = InternalLinks::select(['internal_links.*'])
            ->where('internal_links.status', '!=', 'deleted');
        //filter conditions begins
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where(function($group) use ($filter){
                $group->where('internal_links.title', 'like', '%' . $filter['filter_search_text'] . '%');
                $group->orwhere('internal_links.tagline', 'like', '%' . $filter['filter_search_text'] . '%');
            });
        }
        //filter condition ends
        $internal_links = $query->orderby($sort['field'], $sort['position'])->offset($pagination['offset'])->limit($pagination['limit'])->get();
        return $internal_links;
    }
}
