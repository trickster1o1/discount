<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CounterInformation extends Model
{
    use HasFactory;

    protected $table = 'counter_information';

    protected $fillable = ['title', 'short_description', 'icon_class', 'thumb_image', 'counter_number', 'status','created_by','updated_by', 'order_by'];

    public static function getTotal($filter = [])
    {
        $query = CounterInformation::where('counter_information.status', '!=', 'deleted');
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where('counter_information.title', 'like', '%' . $filter['filter_search_text'] . '%');
            //$query->orwhere('counter_information.status', 'like', '%' . $filter['filter_search_text'] . '%');
        }
        $total_data = $query->count();
        return $total_data;
    }

    public static function getData($sort = [], $pagination = [], $filter = [])
    {
        $query = CounterInformation::select(['counter_information.*'])
            ->where('counter_information.status', '!=', 'deleted');
        //filter conditions begins
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where('counter_information.title', 'like', '%' . $filter['filter_search_text'] . '%');
            //$query->orwhere('counter_information.status', 'like', '%' . $filter['filter_search_text'] . '%');
        }
        //filter condition ends
        $conter_informations = $query->orderby($sort['field'], $sort['position'])->offset($pagination['offset'])->limit($pagination['limit'])->get();
        return $conter_informations;
    }
}
