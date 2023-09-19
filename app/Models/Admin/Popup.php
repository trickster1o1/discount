<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Popup extends Model
{
    use HasFactory;

    protected $table = 'popups';

    protected $fillable = [
        'title', 'popup_description',
            'created_by','updated_by' ,'start_date', 'start_time', 'end_date', 'end_time', 'order_by', 'status'
    ];

    public static function getTotal($filter = [])
    {
        $query = Popup::where('status', '!=', 'deleted');
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where('title', 'like', '%' . $filter['filter_search_text'] . '%');
            /*$query->orwhere('popup_description', 'like', '%' . $filter['filter_search_text'] . '%');
            $query->orwhere('status', 'like', '%' . $filter['filter_search_text'] . '%');*/
        }
        $total_data = $query->count();
        return $total_data;
    }

    public static function getData($sort = [], $pagination = [], $filter = [])
    {
        $query = Popup::select(['*'])
            ->where('status', '!=', 'deleted');
        //filter conditions begins
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where('title', 'like', '%' . $filter['filter_search_text'] . '%');
            /*$query->orwhere('popup_description', 'like', '%' . $filter['filter_search_text'] . '%');
            $query->orwhere('status', 'like', '%' . $filter['filter_search_text'] . '%');*/
        }
        //filter condition ends
        $popups = $query->orderby($sort['field'], $sort['position'])->offset($pagination['offset'])->limit($pagination['limit'])->get();
        return $popups;
    }
}
