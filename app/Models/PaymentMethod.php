<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;
    protected $fillable = ['method', 'code', 'status','order_by','created_by','updated_by','logo'];
    protected $table = 'payment_methods';
    public $sortable = ['method', 'code', 'status'];


    public static function getTotal($filter = [])
    {
        $query = PaymentMethod::where('status', '!=', 'deleted');
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where('method', 'like', '%' . $filter['filter_search_text'] . '%')
            ->orWhere('code','like', '%' . $filter['filter_search_text'] . '%')
            ->where('status','!=','deleted');
        }
        $total_data = $query->count();
        return $total_data;
    }

    public static function getData($sort = [], $pagination = [], $filter = [])
    {
        $query = PaymentMethod::where('status', '!=', 'deleted');
        //filter conditions begins
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where('method', 'like', '%' . $filter['filter_search_text'] . '%');
            $query->orWhere('code', 'like', '%' . $filter['filter_search_text'] . '%');
            $query->where('status', '!=','deleted');
        }
        //filter condition ends
        $categories = $query->orderby($sort['field'], $sort['position'])->offset($pagination['offset'])->limit($pagination['limit'])->get();
        return $categories;
    }


}
