<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{
    use HasFactory;
    protected $fillable = ['fullName', 'number', 'email','address','dob','occupation','image','attachment',
'message','accepted_at','created_by','updated_by',
'accepted_by','accepted','status'];
    protected $table = 'volunteers';
    public $sortable = [
        'status','fullName','number','email','address','dob'
    ];


    public static function getTotal($filter = [])
    {
        $query = Volunteer::where('status', '!=', 'deleted');
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where('fullName', 'like', '%' . $filter['filter_search_text'] . '%')
            ->orWhere('number','like', '%' . $filter['filter_search_text'] . '%')
            ->orWhere('address','like', '%' . $filter['filter_search_text'] . '%')
            ->where('status','!=','deleted');
        }
        $total_data = $query->count();
        return $total_data;
    }

    public static function getData($sort = [], $pagination = [], $filter = [])
    {
        $query = Volunteer::where('status', '!=', 'deleted');
        //filter conditions begins
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where('fullName', 'like', '%' . $filter['filter_search_text'] . '%')->where('status', '!=','deleted');;
            $query->orWhere('number', 'like', '%' . $filter['filter_search_text'] . '%')->where('status', '!=','deleted');
            // $query->orWhere('email', 'like', '%' . $filter['filter_search_text'] . '%');
            $query->orWhere('address', 'like', '%' . $filter['filter_search_text'] . '%')->where('status', '!=','deleted');;
            // $query->orWhere('dob', 'like', '%' . $filter['filter_search_text'] . '%');
            // $query->where('status', '!=','deleted');
        }
        //filter condition ends
        $categories = $query->orderby($sort['field'], $sort['position'])->offset($pagination['offset'])->limit($pagination['limit'])->get();
        return $categories;
    }
}
