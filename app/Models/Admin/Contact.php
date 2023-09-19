<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = [
        'fullName','email','number','subject','message','status',
    ];
    public $sortable = ['fullName', 'number', 'email','status'];
    protected $table = 'contacts';


    public static function getTotal($filter = [])
    {
        $query = Contact::where('status', '!=', 'deleted');
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where(function($group) use ($filter){
                $group->where('fullName', 'like', '%' . $filter['filter_search_text'] . '%')
                ->orWhere('email','like', '%' . $filter['filter_search_text'] . '%')
                ->orWhere('number','like', '%' . $filter['filter_search_text'] . '%');
            });
        }
        $total_data = $query->count();
        return $total_data;
    }

    public static function getData($sort = [], $pagination = [], $filter = [])
    {
        $query = Contact::where('status', '!=', 'deleted');
        //filter conditions begins
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where(function($group) use ($filter){
                $group->where('fullName', 'like', '%' . $filter['filter_search_text'] . '%')
                ->orWhere('email','like', '%' . $filter['filter_search_text'] . '%')
                ->orWhere('number','like', '%' . $filter['filter_search_text'] . '%');
            });
        }
        //filter condition ends
        $categories = $query->orderby($sort['field'], $sort['position'])->offset($pagination['offset'])->limit($pagination['limit'])->get();
        return $categories;
    }
}
