<?php

namespace App\Models\Admin;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kyslik\ColumnSortable\Sortable;

class Category extends Model
{
    use HasFactory, CreatedUpdatedBy, Sortable;

    protected $table = 'categories';

    protected $fillable = [
        'title', 'slug', 'category_type', 'status', 'created_by', 'updated_by', 'tag_line', 'thumb_image', 'featured_image','banner_image', 'description', 'short_description', 'meta_key', 'meta_description', 'fb_title', 'fb_description', 'fb_image', 'twitter_title', 'twitter_description', 'twitter_image',
    ];
    public $sortable = ['title', 'status', 'category_type'];

    public static function getTotal($filter = [])
    {
        $query = Category::join('category_types', 'categories.category_type', '=', 'category_types.slug')
            ->where('categories.status', '!=', 'deleted');
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where(function($group) use ($filter){
                $group->where('categories.title', 'like', '%' . $filter['filter_search_text'] . '%');
                $group->orWhere('category_types.title', 'like', '%' . $filter['filter_search_text'] . '%');
            });
        }
        $total_data = $query->count();
        return $total_data;
    }

    public static function getData($sort = [], $pagination = [], $filter = [])
    {
        $query = Category::select(['categories.*', 'category_types.title as category_type_title'])
            ->join('category_types', 'categories.category_type', '=', 'category_types.slug')
            ->where('categories.status', '!=', 'deleted');
        //filter conditions begins
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where(function($group) use ($filter){
                $group->where('categories.title', 'like', '%' . $filter['filter_search_text'] . '%');
                $group->orWhere('category_types.title', 'like', '%' . $filter['filter_search_text'] . '%');
            });
        }
        //filter condition ends
        $categories = $query->orderby($sort['field'], $sort['position'])->offset($pagination['offset'])->limit($pagination['limit'])->get();
        return $categories;
    }
}
