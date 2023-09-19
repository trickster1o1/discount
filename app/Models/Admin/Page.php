<?php

namespace App\Models\Admin;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Page extends Model
{
    use HasFactory, CreatedUpdatedBy, Sortable;


    protected $table = 'pages';

    protected $fillable = [
        'title', 'slug', 'status', 'created_by', 'updated_by', 'tag_line', 'thumb_image',
         'featured_image', 'description', 'short_description', 'meta_key', 
         'meta_description', 'fb_title', 'fb_description', 'fb_image',
          'twitter_title', 'twitter_description', 'twitter_image', 'category',
           'sub_category', 'video_url','banner_image'
    ];
    public $sortable = ['title', 'category', 'sub_category', 'status'];

    public static function getTotal($filter = [])
    {
        $query = Page::join('categories', 'pages.category', '=', 'categories.id')
            ->leftjoin('sub_categories', 'pages.sub_category', '=', 'sub_categories.id')
            ->where('pages.status', '!=', 'deleted');
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where(function($group) use ($filter){
                $group->where('pages.title', 'like', '%' . $filter['filter_search_text'] . '%');
                $group->orWhere('categories.title', 'like', '%' . $filter['filter_search_text'] . '%');
                $group->orWhere('sub_categories.title', 'like', '%' . $filter['filter_search_text'] . '%');
            });
        }
        $total_data = $query->count();
        return $total_data;
    }

    public static function getData($sort = [], $pagination = [], $filter = [])
    {
        $query = Page::select(['pages.*', 'categories.title as category_title', 'sub_categories.title as sub_category_title'])
            ->join('categories', 'pages.category', '=', 'categories.id')
            ->leftjoin('sub_categories', 'pages.sub_category', '=', 'sub_categories.id')
            ->where('pages.status', '!=', 'deleted');
            //filter conditions begins
            if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
                $query->where(function($group) use ($filter){
                    $group->where('pages.title', 'like', '%' . $filter['filter_search_text'] . '%');
                    $group->orWhere('categories.title', 'like', '%' . $filter['filter_search_text'] . '%');
                    $group->orWhere('sub_categories.title', 'like', '%' . $filter['filter_search_text'] . '%');
                });
            }
            //filter condition ends
        $pages = $query->orderby($sort['field'], $sort['position'])->offset($pagination['offset'])->limit($pagination['limit'])->get();
        return $pages;
    }
}
