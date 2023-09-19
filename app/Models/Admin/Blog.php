<?php

namespace App\Models\Admin;

use App\Models\BlogsComment;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Blog extends Model
{
    use HasFactory, CreatedUpdatedBy, Sortable;

    protected $table = 'blogs';

    protected $fillable = [
        'title', 'slug', 'status', 'created_by', 'updated_by', 'tag_line', 'thumb_image', 'featured_image', 'description', 'short_description', 'meta_key', 'meta_description', 'fb_title', 'fb_description', 'fb_image', 'twitter_title', 'twitter_description', 'twitter_image', 'category', 'author', 'publish_date', 'tags', 'setting', 'sub_category','is_featured','banner_image'
    ];

    public $sortable  = ['title', 'category', 'sub_category', 'status', 'publish_date', 'author'];

    public static function getTotal($filter = [])
    {
        $query = Blog::join('categories', 'blogs.category', '=', 'categories.id')
            ->leftJoin('sub_categories', 'blogs.sub_category', '=', 'sub_categories.id')
            ->where('blogs.status', '!=', 'deleted');
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where(function($group) use ($filter){
                $group->where('blogs.title', 'like', '%' . $filter['filter_search_text'] . '%');
                $group->orWhere('categories.title', 'like', '%' . $filter['filter_search_text'] . '%');
                $group->orWhere('sub_categories.title', 'like', '%' . $filter['filter_search_text'] . '%');
            });
        }
        $total_data = $query->count();
        return $total_data;
    }

    public static function getData($sort = [], $pagination = [], $filter = [])
    {
        $query = Blog::select(['blogs.*', 'categories.title as category_title', 'sub_categories.title as sub_category_title'])
            ->join('categories', 'blogs.category', '=', 'categories.id')
            ->leftJoin('sub_categories', 'blogs.sub_category', '=', 'sub_categories.id')
            ->where('blogs.status', '!=', 'deleted');
        //filter conditions begins
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where(function($group) use ($filter){
                $group->where('blogs.title', 'like', '%' . $filter['filter_search_text'] . '%');
                $group->orWhere('categories.title', 'like', '%' . $filter['filter_search_text'] . '%');
                $group->orWhere('sub_categories.title', 'like', '%' . $filter['filter_search_text'] . '%');
            });
        }
        //filter condition ends
        $blogs = $query->orderby($sort['field'], $sort['position'])->offset($pagination['offset'])->limit($pagination['limit'])->get();
        return $blogs;
    }

    function comments() {
        return $this->hasMany(BlogsComment::class);
    }
}
