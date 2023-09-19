<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class EmailTemplates extends Model
{
    use HasFactory, Sortable;

    protected $table = 'email_templates';

    protected $fillable = ['template_name', 'admin_user', 'user_subject', 'custom_email', 'user_message', 'admin_subject', 'admin_message', 'status',
        'created_by','updated_by',
    ];

    public $sortable = ['template_name', 'user_subject'];

    public static function getTotal($filter = [])
    {
        $query = EmailTemplates::where('email_templates.status', '!=', 'deleted');
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where('email_teamplates.template_name', 'like', '%' . $filter['filter_search_text'] . '%');
            $query->orWhere('email_teamplates.user_subject', 'like', '%' . $filter['filter_search_text'] . '%');
        }
        $total_data = $query->count();
        return $total_data;
    }

    public static function getData($sort = [], $pagination = [], $filter = [])
    {
        $query = EmailTemplates::select(['email_templates.*'])
            ->where('email_templates.status', '!=', 'deleted');
        //filter conditions begins
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where('email_teamplates.template_name', 'like', '%' . $filter['filter_search_text'] . '%');
            $query->orWhere('email_teamplates.user_subject', 'like', '%' . $filter['filter_search_text'] . '%');
        }
        //filter condition ends
        $email_teamplates = $query->orderby($sort['field'], $sort['position'])->offset($pagination['offset'])->limit($pagination['limit'])->get();
        return $email_teamplates;
    }
}
