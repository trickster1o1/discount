<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankDetail extends Model
{
    use HasFactory;
    protected $table = 'bank_details';

    protected $fillable = [
        'bank_detail','order_by','status','created_by','updated_by',
    ];

    public static function getTotal($filter = [])
    {
        $query = BankDetail::where('status', '!=', 'deleted');
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where('bank_detail', 'like', '%' . $filter['filter_search_text'] . '%')
            ->where('status','!=','deleted');
        }
        $total_data = $query->count();
        return $total_data;
    }

    public static function getData($sort = [], $pagination = [], $filter = [])
    {
        $query = BankDetail::where('status', '!=', 'deleted');
        //filter conditions begins
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where('bank_detail', 'like', '%' . $filter['filter_search_text'] . '%');
            $query->orWhere('amount', 'like', '%' . $filter['filter_search_text'] . '%');
            $query->where('status', '!=','deleted');
        }
        //filter condition ends
        $categories = $query->orderby($sort['field'], $sort['position'])->offset($pagination['offset'])->limit($pagination['limit'])->get();
        return $categories;
    }

}
