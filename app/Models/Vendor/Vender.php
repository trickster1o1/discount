<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use App\Traits\CreatedUpdatedBy;


class Vender extends Model
{
    use HasFactory, CreatedUpdatedBy, Sortable;
    protected $table = 'venders';
    protected $fillable = [
        'vendor_name','address','name','email','number','categorey','password','status',

    ];

    public static function getTotal($filter = [])
    {
        $query = Vender::where('status', '!=', 'deleted');
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where(function($group) use ($filter){
                $group->where('vendor_name', 'like', '%' . $filter['filter_search_text'] . '%');
                $group->orWhere('email', 'like', '%' . $filter['filter_search_text'] . '%');
                $group->orWhere('number', 'like', '%' . $filter['filter_search_text'] . '%');
            });
        }
        $total_data = $query->count();
        return $total_data;
    }

    public static function getData($sort = [], $pagination = [], $filter = [])
    {
        $query = Vender::where('status', '!=', 'deleted');
        //filter conditions begins
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where(function($group) use ($filter){
                $group->where('vendor_name', 'like', '%' . $filter['filter_search_text'] . '%');
                $group->orWhere('email', 'like', '%' . $filter['filter_search_text'] . '%');
                $group->orWhere('number', 'like', '%' . $filter['filter_search_text'] . '%');
            });
        }
        //filter condition ends
        $vendors = $query->orderby($sort['field'], $sort['position'])->offset($pagination['offset'])->limit($pagination['limit'])->get();
        return $vendors;
    }

}
