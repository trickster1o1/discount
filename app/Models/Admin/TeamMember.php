<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use HasFactory;

    protected $table = 'team_members';

    protected $fillable = ['name', 'position', 'is_featured', 'member_image', 'message', 'order_by', 'status'];

    public static function getTotal($filter = [])
    {
        $query = TeamMember::where('team_members.status', '!=', 'deleted');
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where('team_members.name', 'like', '%' . $filter['filter_search_text'] . '%');
            $query->orwhere('team_members.status', 'like', '%' . $filter['filter_search_text'] . '%');
            $query->orwhere('team_members.position', 'like', '%' . $filter['filter_search_text'] . '%');
        }
        $total_data = $query->count();
        return $total_data;
    }

    public static function getData($sort = [], $pagination = [], $filter = [])
    {
        $query = TeamMember::select(['team_members.*'])
            ->where('team_members.status', '!=', 'deleted');
        //filter conditions begins
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where('team_members.name', 'like', '%' . $filter['filter_search_text'] . '%');
            $query->orwhere('team_members.status', 'like', '%' . $filter['filter_search_text'] . '%');
            $query->orwhere('team_members.position', 'like', '%' . $filter['filter_search_text'] . '%');
        }
        //filter condition ends
        $team_members = $query->orderby($sort['field'], $sort['position'])->offset($pagination['offset'])->limit($pagination['limit'])->get();
        return $team_members;
    }
}
