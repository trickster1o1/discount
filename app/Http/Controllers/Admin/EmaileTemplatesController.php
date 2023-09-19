<?php

namespace App\Http\Controllers\admin;

use Toastr;
use App\Http\Controllers\Admin\Controller;
use App\Http\Requests\Admin\StoreEmailTemplateRequest;
use App\Http\Requests\Admin\UpdateEmailTemplateRequest;
use App\Models\Admin\EmailTemplates;
use App\Models\Admin\User;
use Illuminate\Http\Request;

class EmaileTemplatesController extends Controller
{
    private $menuCode = 'EMAILTEMPLATE';

    private $table = 'email_templates';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        authorize($this->menuCode, 'INDEX');
        return view('Admin.emailtemplates.index', array('menucode' => $this->menuCode));
    }
    function email_data(Request $request)
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
        $iTotalRecords    = EmailTemplates::getTotal($filter);
        $iDisplayLength = isset($request->length) ? intval($request->length) : 100;
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart =  isset($request->start) ? intval($request->start) : 0;
        $sEcho = intval($request->draw);

        $end = $iDisplayStart + $iDisplayLength;
        $end = $end > $iTotalRecords ? $iTotalRecords : $end;

        $pagination['limit'] = $iDisplayLength;
        $pagination['offset'] = $iDisplayStart;

        $email_templates =  EmailTemplates::getData($sort, $pagination, $filter);

        if ($email_templates != null) {
            foreach ($email_templates as $key => $email_template) :
                $action = '';
                $records["data"][$key][] = $email_template->template_name;
                $records["data"][$key][] = $email_template->user_subject;
                $records["data"][$key][] = $email_template->admin_subject;
                $status = ($email_template->status == 'active') ? '<i class="fa fa-check-circle fa-2x text-success"></i>' : '<i class="fa fa-times-circle fa-2x text-danger"></i>';

                if (authorize($this->menuCode, 'UPDATE', false)) {
                    $records["data"][$key][] = '<a href="javascript:void(0);" class="record-status" data-id="' . $email_template->id . '"
                                            data-table="' . $this->table . '" data-status="' . $email_template->status . '">' . $status . '</a>';
                } else {
                    $records["data"][$key][] = '<a href="javascript:void(0);">' . $status . '</a>';
                }
                if (authorize($this->menuCode, 'UPDATE', false) || authorize($this->menuCode, 'DELETE', false)) {
                    if (authorize($this->menuCode, 'UPDATE', false)) {
                        $action .= '<a href="' . route('email_templates.edit', $email_template) . '"
                                    class="btn btn-primary btn-sm" title="Edit">
                                    <i class="mdi mdi-square-edit-outline"></i>
                                </a>';
                    }
                    if (authorize($this->menuCode, 'DESTROY', false)) {
                        $action .= '<form class="d-inline swal-delete"
                                    action="' . route('email_templates.destroy', $email_template) . '" method="POST">
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
        //
        authorize($this->menuCode, 'CREATE');
        $users = User::where('status', 'active')->where('id','!=',1)->get();
        return view('Admin.emailtemplates.create', compact(['users']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmailTemplateRequest $request)
    {
        //
        authorize($this->menuCode, 'CREATE');
        $admin_user = ($request->admin_user)?implode(",", $request->admin_user):'';
        $validated = $request->validated();
        $email_templates = EmailTemplates::create($validated);
        $email_templates->admin_user = $admin_user;
        $email_templates->save();
        $this->modified_by('create',$email_templates);
        Toastr::success('Email Template Created Successfully', 'Sucess');
        return redirect()->route('email_templates.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_if(true,403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(EmailTemplates $email_template)
    {
        //
        authorize($this->menuCode, 'UPDATE');
        //dd($email_template);
        $users = User::where('status', 'active')->get();
        return view('Admin.emailtemplates.edit', compact(['users', 'email_template']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmailTemplateRequest $request, EmailTemplates $email_template)
    {
        //
        authorize($this->menuCode, 'UPDATE');
        $validated = $request->validated();
        if ($request->admin_user != null) {
            $admin_user = implode(',', $request->admin_user);
        } else {
            $admin_user = null;
        }
        $email_template->admin_user = $admin_user;
        $email_template->update($validated);
        $this->modified_by('update',$email_template);

        Toastr::success('Email Template Updated Sucessfully', 'Sucess');
        return redirect()->route('email_templates.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmailTemplates $email_template)
    {
        //
        if (authorize($this->menuCode, 'DESTROY', false)) {
            $email_template = EmailTemplates::where('id', '=', $email_template->id);
            $email_template->update(['status' => 'deleted']);
            $data['type']       = 'success';
            $data['message']    = 'Record Deleted Sucessfully!!!';
        } else {
            $data['type']       = 'error';
            $data['message']    = 'Invalid Request!';
        }
        return $data;
    }
}
