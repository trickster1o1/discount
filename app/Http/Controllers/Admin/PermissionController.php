<?php

namespace App\Http\Controllers\Admin;

use Toastr;
use Illuminate\Http\Request;
use App\Models\Admin\Permission;
use App\Http\Requests\Admin\StorePermissionRequest;
use App\Http\Requests\Admin\UpdatePermissionRequest;

class PermissionController extends Controller
{
    private $menuCode = 'PERMISSION';
    private $table = 'permissions';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        authorize($this->menuCode, 'INDEX');
        return view('Admin.permissions.index', ['menucode' => $this->menuCode]);
    }
    function permission_data(Request $request)
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
        $iTotalRecords    = Permission::getTotal($filter);
        $iDisplayLength = isset($request->length) ? intval($request->length) : 100;
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart =  isset($request->start) ? intval($request->start) : 0;
        $sEcho = intval($request->draw);

        $end = $iDisplayStart + $iDisplayLength;
        $end = $end > $iTotalRecords ? $iTotalRecords : $end;

        $pagination['limit'] = $iDisplayLength;
        $pagination['offset'] = $iDisplayStart;

        $permissions =  Permission::getData($sort, $pagination, $filter);

        if ($permissions != null) {
            foreach ($permissions as $key => $permission) :
                $action = '';
                $records["data"][$key][] = $permission->name;
                $records["data"][$key][] = $permission->permission_code;
                $status = ($permission->status == 'active') ? '<i class="fa fa-check-circle fa-2x text-success"></i>' : '<i class="fa fa-times-circle fa-2x text-danger"></i>';

                if (authorize($this->menuCode, 'UPDATE', false)) {
                    $records["data"][$key][] = '<a href="javascript:void(0);" class="record-status" data-id="' . $permission->id . '"
                                            data-table="' . $this->table . '" data-status="' . $permission->status . '">' . $status . '</a>';
                } else {
                    $records["data"][$key][] = '<a href="javascript:void(0);">' . $status . '</a>';
                }
                if (authorize($this->menuCode, 'UPDATE', false) || authorize($this->menuCode, 'DELETE', false)) {
                    if (authorize($this->menuCode, 'UPDATE', false)) {
                        $action .= '<a href="' . route('permissions.edit', $permission) . '"
                                    class="btn btn-primary btn-sm" title="Edit">
                                    <i class="mdi mdi-square-edit-outline"></i>
                                </a>';
                    }
                    if (authorize($this->menuCode, 'DESTROY', false)) {
                        $action .= '<form class="d-inline swal-delete"
                                    action="' . route('permissions.destroy', $permission) . '" method="POST">
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
        return view('Admin.permissions.create', ['menucode' => $this->menuCode]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePermissionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePermissionRequest $request)
    {
        authorize($this->menuCode, 'CREATE');
        $validated = $request->validated();
        Permission::create($validated);
        Toastr::success('Permission Added Successfully', 'Sucess');
        return redirect()->route('permissions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        authorize($this->menuCode, 'SHOW');
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        authorize($this->menuCode, 'UPDATE');
        $id = $permission->id;
        $permission = Permission::where('id', $id)->where('status', '!=', 'deleted')->first();
        if ($permission) {
            return view('Admin.permissions.edit', compact('permission') + ['menucode' => $this->menuCode]);
        } else {
            return redirect()->route('permissions.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePermissionRequest  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        authorize($this->menuCode, 'UPDATE');
        $validated = $request->validated();
        $permission->update($validated);
        Toastr::success('Permission Uodated Successfully', 'Sucess');
        return redirect()->route('permissions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        if (authorize($this->menuCode, 'DESTROY', false)) {
            $permission = Permission::where('id', '=', $permission->id);
            $permission->update(['status' => 'deleted']);
            $data['type']       = 'success';
            $data['message']    = 'Record Deleted Sucessfully!!!';
        } else {
            $data['type']       = 'error';
            $data['message']    = 'Invalid Request!';
        }
        return $data;
    }
}
