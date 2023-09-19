<?php

namespace App\Models\Admin;

use App\Models\ProgramComment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;
    protected $fillable = [
        'title','slug','category','sub_category','thumb_image','featured_image','is_featured',
        'status','order_by','gallery_id','attached_file_url','start_date','start_time','end_date','end_time',
        'location','short_description','description','meta_key','meta_description','fb_title','fb_description',
        'fb_image','twitter_title',
        'created_by','updated_by',
        'twitter_description','twitter_image','target_amount','donation_amount','banner_image','organizer'
    ];
    protected $table = 'programs';


    public static function getTotal($filter = [])
    {
        $query = Program::where('status', '!=', 'deleted');
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where(function($group) use ($filter){
                $group->where('title', 'like', '%' . $filter['filter_search_text'] . '%')
                ->orWhere('start_date','like', '%' . $filter['filter_search_text'] . '%')
                ->orWhere('donation_amount','like', '%' . $filter['filter_search_text'] . '%')
                ->orWhere('target_amount','like', '%' . $filter['filter_search_text'] . '%');
            });

        }
        $total_data = $query->count();
        return $total_data;
    }

    public static function getData($sort = [], $pagination = [], $filter = [])
    {
        $query = Program::where('status', '!=', 'deleted');
        //filter conditions begins
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where(function($group) use ($filter){
                $group->where('title', 'like', '%' . $filter['filter_search_text'] . '%')
                ->orWhere('start_date','like', '%' . $filter['filter_search_text'] . '%')
                ->orWhere('donation_amount','like', '%' . $filter['filter_search_text'] . '%')
                ->orWhere('target_amount','like', '%' . $filter['filter_search_text'] . '%');
            });
        }
        //filter condition ends
        $categories = $query->orderby($sort['field'], $sort['position'])->offset($pagination['offset'])->limit($pagination['limit'])->get();
        return $categories;
    }

    function album() {
        return Album::where('id',$this->gallery_id)->first();
    }

    function comments() {
        return $this->hasMany(ProgramComment::class);
    }
}
