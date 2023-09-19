<?php

namespace App\Models\Admin;


use App\Models\Admin\Gallary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kyslik\ColumnSortable\Sortable;

class Album extends Model
{
    use HasFactory, Sortable;

    protected $table = 'albums';

    protected $fillable = ['title', 'slug', 'status','album_description','album_short_description','thumb_image','banner_image',
        'tagline','meta_key','meta_description','fb_title','fb_description',
        'fb_image','twitter_title','twitter_description','twitter_image','created_by','updated_by',
    ];

    public $sortbale = ['title', 'slug', 'status'];


    public static function getTotal($filter = [])
    {
        $query = Album::where('status', '!=', 'deleted');
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where(function($group) use ($filter){
                $group->where('title', 'like', '%' . $filter['filter_search_text'] . '%')
                ->orWhere('slug','like', '%' . $filter['filter_search_text'] . '%');
            });
        }
        $total_data = $query->count();
        return $total_data;
    }

    public static function getData($sort = [], $pagination = [], $filter = [])
    {
        $query = Album::select('albums.*',\DB::raw("(SELECT count(*) from galleries where album_id = albums.id ) as total_image"))
        ->where('status', '!=', 'deleted');
        //filter conditions begins
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where(function($group) use ($filter){
                $group->where('title', 'like', '%' . $filter['filter_search_text'] . '%')
                ->orWhere('slug','like', '%' . $filter['filter_search_text'] . '%');
            });
        }
        //filter condition ends
        $categories = $query->orderby($sort['field'], $sort['position'])->offset($pagination['offset'])->limit($pagination['limit'])->get();
        return $categories;
    }


    public function gallary()
    {
        return $this->hasMany(Gallary::class);
    }
}
