<?php

if(!function_exists('is_authorized')){
    function is_authorized($menuCode, $permissionCode = ''){
        $menuCode = get_menu_code($menuCode);
        if(!auth()->check() || auth()->user()->role == NULL) return false;//if no role has been assigned or role is null
        if(auth()->check() && auth()->user()->role->role_code === 'SUPERADMIN') return true;
        $role_id = auth()->user()->role->id;
        $menu_data = DB::table('menus')->select('id')->where('menu_code',$menuCode)->where('status','active')->first();//get menu id with reference to menu code
        $code_data = DB::table('permissions')->select('id')->where('permission_code',$permissionCode)->where('status','active')->first();
        if($menu_data && $code_data){
            $permission = DB::table('menu_permission_role')->where('menu_id',$menu_data->id)->where('permission_id',$code_data->id)->where('role_id',$role_id)->first();
            return ($permission)?true:false;
        }else{
            return false;
        }
    }
}

if(!function_exists('authorize')){
    function authorize($menuCode, $permissionCode,$redirect = true){
        $menuCode = get_menu_code($menuCode);
        if(is_authorized($menuCode,$permissionCode)){
            return true;
        }else{
            if($redirect == true){
                abort_if(true, 403);                
            }else{
                return false;
            }            
        }
    }
}


if(!function_exists('get_menu_code')){
    function get_menu_code($menuCode){
        $menuCode = ($menuCode == 'DELETE')?'DESTROY':$menuCode;
        $menuCode = ($menuCode == 'EDIT')?'UPDATE':$menuCode;
        $menuCode = ($menuCode == 'DETAIL')?'SHOW':$menuCode;
        $menuCode = ($menuCode == 'LISTALL')?'INDEX':$menuCode;
        return $menuCode;
    }
}

if(!function_exists('menu_authorize')){
    function menu_authorize($id){
        //$menuCode = get_menu_code($menuCode);
        if(!auth()->check() || auth()->user()->role == NULL) return false;//if no role has been assigned or role is null
        if(auth()->check() && auth()->user()->role->role_code === 'SUPERADMIN') return true;
        $role_id = auth()->user()->role->id;
        $permission = DB::table('menu_permission_role')->where('menu_id',$id)->where('role_id',$role_id)->first();
        return ($permission)?true:false;
    }
}

if(!function_exists('check_permission')){
    function check_permission($menu_id,$action_id,$role_id){
        $permission = DB::table('menu_permission_role')->where('menu_id',$menu_id)->where('permission_id',$action_id)->where('role_id',$role_id)->first();
        return ($permission)?true:false;
    }
}