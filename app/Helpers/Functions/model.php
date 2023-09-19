<?php

// Menu
if (!function_exists('parent_menus')) {
    function parent_menus()
    {
        return \App\Models\Admin\Menu::where(['status' => 'active', 'parent' => 0])->orderBy('position','asc')->get();
    }
}

if (!function_exists('menus')) {
    function menus($with = null)
    {
        if ($with == null) {
            $menus = new \App\Models\Admin\Menu();
        } else {
            $menus = \App\Models\Admin\Menu::with($with);
        }
        return $menus->where(['status' => 'active'])->orderBy('position')->get();
    }
}

// Permission
if (!function_exists('permissions')) {
    function permissions($with = null)
    {
        if ($with == null) {
            $permission = new \App\Models\Admin\Permission();
        } else {
            $permission = \App\Models\Admin\Permission::with($with);
        }
        return $permission->where(['status' => 'active'])->get();
    }
}

//Role
if (!function_exists('roles')) {
    function roles($with = null)
    {
        if ($with == null) {
            $role = new \App\Models\Admin\Role();
        } else {
            $role = \App\Models\Admin\Role::with($with);
        }
        return $role->where(['status' => 'active'])->get();
    }
}
