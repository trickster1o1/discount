<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Banner extends Model
{
    use HasFactory, Sortable;

    protected $table = 'banners';

    protected $fillable = ['title', 'banner_type', 'image', 'video', 'tag_line', 'primary_button_title', 'primary_button_link', 'secondary_button_link', 'secondary_button_title', 'status',
        'created_by','updated_by',
    ];

    public static function getTotal($filter = [])
    {
        $query = Banner::where('status', '!=', 'deleted');
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where('title', 'like', '%' . $filter['filter_search_text'] . '%');
        }
        $total_data = $query->count();
        return $total_data;
    }

    public static function getData($sort = [], $pagination = [], $filter = [])
    {
        $query = Banner::where('status', '!=', 'deleted');
        //filter conditions begins
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where('title', 'like', '%' . $filter['filter_search_text'] . '%');
        }
        //filter condition ends
        $banners = $query->orderby($sort['field'], $sort['position'])->offset($pagination['offset'])->limit($pagination['limit'])->get();
        return $banners;
    }
}
