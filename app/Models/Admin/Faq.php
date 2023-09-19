<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $table = 'faqs';

    protected $fillable = ['category', 'sub_category', 'question', 'answer', 'order_by', 'status',
        'created_by','updated_by'
    ];

    public static function getTotal($filter = [])
    {
        $query = Faq::join('categories', 'faqs.category', '=', 'categories.id')
            ->join('sub_categories', 'faqs.sub_category', '=', 'sub_categories.id','left')
            ->where('faqs.status', '!=', 'deleted');
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where('faqs.question', 'like', '%' . $filter['filter_search_text'] . '%');
            $query->orWhere('categories.title', 'like', '%' . $filter['filter_search_text'] . '%');
            $query->orWhere('sub_categories.title', 'like', '%' . $filter['filter_search_text'] . '%');
        }
        $total_data = $query->count();
        return $total_data;
    }

    public static function getData($sort = [], $pagination = [], $filter = [])
    {
        $query = Faq::select(['faqs.*', 'categories.title as category_title', 'sub_categories.title as sub_category_title'])
            ->join('categories', 'faqs.category', '=', 'categories.id')
            ->join('sub_categories', 'faqs.sub_category', '=', 'sub_categories.id','left')
            ->where('faqs.status', '!=', 'deleted');
        //filter conditions begins
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where('faqs.question', 'like', '%' . $filter['filter_search_text'] . '%');
            $query->orWhere('categories.title', 'like', '%' . $filter['filter_search_text'] . '%');
            $query->orWhere('sub_categories.title', 'like', '%' . $filter['filter_search_text'] . '%');
        }
        //filter condition ends
        $faqs = $query->orderby($sort['field'], $sort['position'])->offset($pagination['offset'])->limit($pagination['limit'])->get();
        return $faqs;
    }
}
