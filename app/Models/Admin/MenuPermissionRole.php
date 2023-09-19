<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuPermissionRole extends Model
{
    use HasFactory;

    protected $table = 'menu_permission_role';
    protected $created_at = NULL;
    protected $updated_at = NULL;
    protected $with = ['menu', 'permission', 'role'];

    protected $fillable = [
        'menu_id', 'permission_id', 'role_id'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
