<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class Permission extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $fillable = [
        'name', 'permission_code', 'status', 'created_by', 'updated_by'
    ];

    public function menus()
    {
        return $this->belongsToMany(Menu::class);
    }
    public static function getTotal($filter = [])
    {
        $query = Permission::where('permissions.status', '!=', 'deleted');
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where(function($group) use ($filter){
                $group->where('permissions.name', 'like', '%' . $filter['filter_search_text'] . '%');
                $group->orwhere('permissions.permission_code', 'like', '%' . $filter['filter_search_text'] . '%');
            });
        }
        $total_data = $query->count();
        return $total_data;
    }

    public static function getData($sort = [], $pagination = [], $filter = [])
    {
        $query = Permission::select(['permissions.*'])
            ->where('permissions.status', '!=', 'deleted');
        //filter conditions begins
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where(function($group) use ($filter){
                $group->where('permissions.name', 'like', '%' . $filter['filter_search_text'] . '%');
                $group->orwhere('permissions.permission_code', 'like', '%' . $filter['filter_search_text'] . '%');
            });
        }
        //filter condition ends
        $permissions = $query->orderby($sort['field'], $sort['position'])->offset($pagination['offset'])->limit($pagination['limit'])->get();
        return $permissions;
    }
}
