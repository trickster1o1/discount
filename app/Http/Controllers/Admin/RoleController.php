<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreRoleRequest;
use App\Http\Requests\Admin\UpdateRoleRequest;
use App\Models\Admin\Role;
use Illuminate\Http\Request;
use App\Models\Admin\Menu;
use App\Models\Admin\Permission;
use App\Models\Admin\MenuPermissionRole;
use Toastr;

class RoleController extends Controller
{
    private $menuCode   = 'ROLE';
    private $table      = 'roles';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        authorize($this->menuCode, 'INDEX');
        return view('Admin.roles.index', ['menucode' => $this->menuCode]);
    }
    function role_data(Request $request)
    {
        $records          = [];
        $records["data"]  = [];
        $filter           = [];
        $sortFields       = [];
        //sorting setup
        $sort             = $request->columns;
        if (is_array($sort) && count($sort) > 0) {
            foreach ($sort as $key => $value) :
                if ($value['orderable'] === 'true') {
                    $sortFields[$value['data']] = $value['name'];
                }
            endforeach;
        }
        $order_request['order'] = (isset($request->order)) ? $request->order : [];
        $sortvalue              = (isset($order_request['order'][0]['column'])) ? $order_request['order'][0]['column'] : '';
        $sort['field']          = (strlen(trim($sortvalue)) && count($sortFields) > 0) ? $sortFields[$sortvalue] : 'id';
        $sort['position']       = (isset($order_request['order'][0]['dir'])) ? $order_request['order'][0]['dir'] : 'DESC';
        //filter setup
        $filter['filter_search_text'] = (isset($request->filter_search_text)) ? $request->filter_search_text : '';
        $iTotalRecords    = Role::getTotal($filter);
        $iDisplayLength = isset($request->length) ? intval($request->length) : 100;
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart =  isset($request->start) ? intval($request->start) : 0;
        $sEcho = intval($request->draw);

        $end = $iDisplayStart + $iDisplayLength;
        $end = $end > $iTotalRecords ? $iTotalRecords : $end;

        $pagination['limit'] = $iDisplayLength;
        $pagination['offset'] = $iDisplayStart;

        $roles =  Role::getData($sort, $pagination, $filter);

        if ($roles != null) {
            foreach ($roles as $key => $role) :
                $action = '';
                $records["data"][$key][] = $role->name;
                $records["data"][$key][] = $role->role_code;

                $status = ($role->status == 'active') ? '<i class="fa fa-check-circle fa-2x text-success"></i>' : '<i class="fa fa-times-circle fa-2x text-danger"></i>';

                if (authorize($this->menuCode, 'UPDATE', false)) {
                    $records["data"][$key][] = '<a href="javascript:void(0);" class="record-status" data-id="' . $role->id . '"
                                            data-table="' . $this->table . '" data-status="' . $role->status . '">' . $status . '</a>';
                } else {
                    $records["data"][$key][] = '<a href="javascript:void(0);">' . $status . '</a>';
                }
                if (authorize($this->menuCode, 'UPDATE', false) || authorize($this->menuCode, 'DELETE', false)) {
                    if (authorize($this->menuCode, 'ASSIGN', false)) {
                        $action .= '<a href="' . route('roles.show', $role) . '"
                         class="btn btn-primary btn-sm" title="Assign">
                         <i class="fa fa-key"></i>
                         </a>';
                    }
                    if (authorize($this->menuCode, 'UPDATE', false)) {
                        $action .= ' <a href="' . route('roles.edit', $role) . '"
                                    class="btn btn-primary btn-sm" title="Edit">
                                    <i class="mdi mdi-square-edit-outline"></i>
                                </a>';
                    }
                    if (authorize($this->menuCode, 'DESTROY', false)) {
                        $action .= '<form class="d-inline swal-delete"
                                    action="' . route('roles.destroy', $role) . '" method="POST">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-danger btn-sm btn-submit" title="Delete"><i
                                            class="mdi mdi-delete"></i></button>
                                </form>';
                    }
                }
                $records["data"][$key][] = $action;
            endforeach;
        }
        $records["draw"]            = $sEcho;
        $records["recordsTotal"]    = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        echo json_encode($records);
        exit;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        authorize($this->menuCode, 'CREATE');
        return view('Admin.roles.create', array('menucode' => $this->menuCode));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRoleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleRequest $request)
    {
        authorize($this->menuCode, 'CREATE');
        $validated = $request->validated();
        Role::create($validated);
        Toastr::success('Role Created Successfully', 'Sucess');
        return redirect()->route('roles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        authorize($this->menuCode, 'SHOW');
        $role_id = $role->id;
        $menus = Menu::with('subMenus', 'permissions')->get();
        return view('Admin.roles.assign', compact('menus') + [
            'role' => $role->load('menuPermissionRoles'), 'role_id' => $role_id
        ]);
    }

    public function assign(Request $request, Role $role)
    {
        authorize($this->menuCode, 'SHOW');
        $validated = $request->validate([
            'permissions.*.*' => 'nullable|in:' . permissions()->pluck('id')->implode(',')
        ]);
        $role->menuPermissionRoles()->delete();
        if (isset($validated['permissions'])) {
            foreach ($validated['permissions'] as $menu => $permissions) {
                foreach ($permissions as $permission) {
                    $role->menuPermissionRoles()->create([
                        'menu_id' => $menu,
                        'permission_id' => $permission
                    ]);
                }
            }
        }
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        authorize($this->menuCode, 'UPDATE');
        $id = $role->id;
        $role = Role::where('id', $id)->where('status', '!=', 'deleted')->first();
        if ($role) {
            return view('Admin.roles.edit', compact('role') + array('menucode' => $this->menuCode));
        } else {
            return redirect()->route('roles.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRoleRequest  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        authorize($this->menuCode, 'UPDATE');
        $validated = $request->validated();
        $role->update($validated);
        Toastr::success('Role Updated Successfully', 'Sucess');
        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        if (authorize($this->menuCode, 'DESTROY', false)) {
            $role = Role::where('id', '=', $role->id);
            $role->update(['status' => 'deleted']);
            $data['type']       = 'success';
            $data['message']    = 'Record Deleted Sucessfully!!!';
        } else {
            $data['type']       = 'error';
            $data['message']    = 'Invalid Request!';
        }
        return $data;
    }
}
