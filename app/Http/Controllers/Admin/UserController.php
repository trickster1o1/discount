<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Admin\User;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use Toastr;
use App\Rules\UniqueSlug;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $menuCode = 'USER';
    private $table = 'users';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        authorize($this->menuCode, 'INDEX');
        return view('Admin.users.index', ['menucode' => $this->menuCode]);
    }
    public function editProfile($id) {
        if(Auth() && Auth()->user()->id != $id) {
            abort('404');
        }
        $user = User::where('id',$id)->where('status','active')->first();
        if(!$user) {
            abort('404');
        }   

        return view('Admin/users/profile', compact('user'));
    }

    public function updProfile($id, Request $req) {
        $req->validate([
            'name'=>'required',
            'email'=>'required|email',
            'phone' => ['required','numeric','digits:10', new UniqueSlug()],
            'username' => ['required','min:6','max:255', new UniqueSlug()],
        ]);
        if(Auth() && Auth()->user()->id != $id) {
            abort('404');
        }
        $user = User::where('id',$id)->where('status','active')->first();
        $user->updateProfile($req);
        Toastr::success('Profile Updated', 'Sucess');
        
        return redirect('/admin/users/'.$user->id.'/profile/edit');

    }

    public function editPwd($id) {
        if(Auth() && Auth()->user()->id != $id) {
            abort('404');
        }
        $user = User::where('id',$id)->where('status','active')->first();
        if(!$user) {
            abort('404');
        }   

        return view('Admin/users/password', compact('user'));
    }

    public function updPwd($id, Request $req) {
        if(Auth() && Auth()->user()->id != $id) {
            abort('404');
        }
        $user = User::where('id',$id)->where('status','active')->first();

        if (!Hash::check($req->oldPwd, $user->password)) {
            Toastr::error('Old Password Is Invalid', 'Error');
            return redirect('/admin/users/'.$user->id.'/password/change');  
        }
        if($req->password != $req->repwd) {
            Toastr::error('Password Doesnt Match', 'Error');
            return redirect('/admin/users/'.$user->id.'/password/change');
        }
        $user->update(['password'=>$req->password]);
        Toastr::success('Password Updated Successfully', 'Success');
        return redirect('/admin/users/'.$user->id.'/profile/edit');



    }
    function user_data(Request $request)
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
        $iTotalRecords    = User::getTotal($filter);
        $iDisplayLength = isset($request->length) ? intval($request->length) : 100;
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart =  isset($request->start) ? intval($request->start) : 0;
        $sEcho = intval($request->draw);

        $end = $iDisplayStart + $iDisplayLength;
        $end = $end > $iTotalRecords ? $iTotalRecords : $end;

        $pagination['limit'] = $iDisplayLength;
        $pagination['offset'] = $iDisplayStart;

        $users =  User::getData($sort, $pagination, $filter);

        if ($users != null) {
            foreach ($users as $key => $user) :
                if($user->id != Auth()->user()->id){
                    $action = '';
                    $records["data"][$key][] = $user->name;
                    $records["data"][$key][] = $user->user_roles;
                    $records["data"][$key][] = $user->phone;
                    $records["data"][$key][] = $user->email;
                    $records["data"][$key][] = $user->username;

                    $status = ($user->status == 'active') ? '<i class="fa fa-check-circle fa-2x text-success"></i>' : '<i class="fa fa-times-circle fa-2x text-danger"></i>';

                    if (authorize($this->menuCode, 'UPDATE', false)) {
                        $records["data"][$key][] = '<a href="javascript:void(0);" class="record-status" data-id="' . $user->id . '"
                                                data-table="' . $this->table . '" data-status="' . $user->status . '">' . $status . '</a>';
                    } else {
                        $records["data"][$key][] = '<a href="javascript:void(0);">' . $status . '</a>';
                    }
                    if (authorize($this->menuCode, 'UPDATE', false) || authorize($this->menuCode, 'DELETE', false)) {
                        if (authorize($this->menuCode, 'UPDATE', false)) {
                            $action .= '<a href="' . route('users.edit', $user) . '"
                                        class="btn btn-primary btn-sm" title="Edit">
                                        <i class="mdi mdi-square-edit-outline"></i>
                                    </a>';
                        }
                        if (authorize($this->menuCode, 'DESTROY', false)) {
                            $action .= '<form class="d-inline swal-delete"
                                        action="' . route('users.destroy', $user) . '" method="POST">
                                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-danger btn-sm btn-submit" title="Delete"><i
                                                class="mdi mdi-delete"></i></button>
                                    </form>';
                        }
                    }
                    $records["data"][$key][] = $action;
                }
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
        return view('Admin.users.create', array('menucode' => $this->menuCode));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        authorize($this->menuCode, 'CREATE');
        $validated = $request->validated();
        User::create($validated);
        Toastr::success('User Creates', 'Sucess');
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        authorize($this->menuCode, 'SHOW');
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        authorize($this->menuCode, 'UPDATE');
        $id = $user->id;
        $user = User::where('id', $id)->where('status', '!=', 'deleted')->first();
        if ($user) {
            return view('Admin.users.edit', compact('user') + array('menucode' => $this->menuCode));
        } else {
            return redirect()->route('users.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        authorize($this->menuCode, 'UPDATE');
        $validated = $request->validated();
        $user->update($validated);
        Toastr::success('User Updated', 'Sucess');
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (authorize($this->menuCode, 'DESTROY', false)) {
            if ($user->id == auth()->user()->id) {
                $data['type']       = 'warning';
                $data['message']    = 'You Cannot Delete Yourself!';
            } else {
                $user = User::where('id', '=', $user->id);
                $user->update(['status' => 'deleted']);
                $data['type']       = 'success';
                $data['message']    = 'Record Deleted Sucessfully!!!';
            }
        } else {
            $data['type']       = 'error';
            $data['message']    = 'Invalid Request!';
        }
        return $data;
    }
}
