<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class Role extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $fillable = [
        'name', 'role', 'role_code', 'status', 'created_by', 'updated_by'
    ];

    public function menuPermissionRoles()
    {
        return $this->hasMany(MenuPermissionRole::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
    public static function getTotal($filter = [])
    {
        $query = Role::where('roles.status', '!=', 'deleted');
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where(function($group) use ($filter){
                $group->where('roles.name', 'like', '%' . $filter['filter_search_text'] . '%')
                ->orwhere('roles.role_code', 'like', '%' . $filter['filter_search_text'] . '%');
            });
        }
        $total_data = $query->count();
        return $total_data;
    }

    public static function getData($sort = [], $pagination = [], $filter = [])
    {
        $query = Role::select(['roles.*'])
            ->where('roles.status', '!=', 'deleted');
        //filter conditions begins
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where(function($group) use ($filter){
                $group->where('roles.name', 'like', '%' . $filter['filter_search_text'] . '%')
                ->orwhere('roles.role_code', 'like', '%' . $filter['filter_search_text'] . '%');
            });
        }
        //filter condition ends
        $roles = $query->orderby($sort['field'], $sort['position'])->offset($pagination['offset'])->limit($pagination['limit'])->get();
        return $roles;
    }


}
