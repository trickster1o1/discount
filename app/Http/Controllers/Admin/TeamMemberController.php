<?php

namespace App\Http\Controllers\Admin;

use Toastr;
use Illuminate\Http\Request;
use App\Models\Admin\TeamMember;
use App\Http\Controllers\Admin\Controller;
use App\Http\Requests\Admin\StoreTeamMemberRequest;
use App\Http\Requests\Admin\UpdateTeamMemberRequest;

class TeamMemberController extends Controller
{
    private $menuCode = 'TEAMMEMBER';

    private $table = 'team_members';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        authorize($this->menuCode, 'INDEX');
        return view('Admin.team-members.index', ['menucode' => $this->menuCode]);
    }

    function team_data(Request $request)
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
        $iTotalRecords    = TeamMember::getTotal($filter);
        $iDisplayLength = isset($request->length) ? intval($request->length) : 100;
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart =  isset($request->start) ? intval($request->start) : 0;
        $sEcho = intval($request->draw);

        $end = $iDisplayStart + $iDisplayLength;
        $end = $end > $iTotalRecords ? $iTotalRecords : $end;

        $pagination['limit'] = $iDisplayLength;
        $pagination['offset'] = $iDisplayStart;

        $team_members =  TeamMember::getData($sort, $pagination, $filter);

        if ($team_members != null) {
            foreach ($team_members as $key => $team_member) :
                $action = '';
                $records["data"][$key][] = $team_member->name;
                $records["data"][$key][] = $team_member->position;
                $records["data"][$key][] = '<input data-table="' . $this->table . '" data-url="' . url('admin/dashboard/update_order/' . $team_member->id) . '" type="number" value="' . $team_member->order_by . '" class="text-right update_order">';
                $status = ($team_member->status == 'active') ? '<i class="fa fa-check-circle fa-2x text-success"></i>' : '<i class="fa fa-times-circle fa-2x text-danger"></i>';

                if (authorize($this->menuCode, 'UPDATE', false)) {
                    $records["data"][$key][] = '<a href="javascript:void(0);" class="record-status" data-id="' . $team_member->id . '"
                                        data-table="' . $this->table . '" data-status="' . $team_member->status . '">' . $status . '</a>';
                } else {
                    $records["data"][$key][] = '<a href="javascript:void(0);">' . $status . '</a>';
                }
                if (authorize($this->menuCode, 'UPDATE', false) || authorize($this->menuCode, 'DELETE', false)) {
                    if (authorize($this->menuCode, 'UPDATE', false)) {
                        $action .= '<a href="' . route('team-members.edit', $team_member) . '"
                                class="btn btn-primary btn-sm" title="Edit">
                                <i class="mdi mdi-square-edit-outline"></i>
                            </a>';
                    }
                    if (authorize($this->menuCode, 'DESTROY', false)) {
                        $action .= '<form class="d-inline swal-delete"
                                action="' . route('team-members.destroy', $team_member) . '" method="POST">
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
        return view('Admin.team-members.create',  ['menucode' => $this->menuCode]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTeamMemberRequest $request)
    {
        //
        authorize($this->menuCode, 'CREATE');
        $validated = $request->validated();
        $team_member = TeamMember::create($validated);
        $team_member->order_by = count(TeamMember::get());
        $team_member->save();
        Toastr::success('Team Member Added Successfully', 'Sucess');
        return redirect()->route('team-members.index');
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
    public function edit(TeamMember $team_member)
    {
        //
        authorize($this->menuCode, 'UPDATE');
        return view('Admin.team-members.edit', compact(['team_member']) + array('menucode' => $this->menuCode));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTeamMemberRequest $request, TeamMember $team_member)
    {
        //
        authorize($this->menuCode, 'UPDATE');
        $validated = $request->validated();
        $team_member->update($validated);
        Toastr::success('Team Member Updated Sucessfully', 'Sucess');
        return redirect()->route('team-members.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TeamMember $team_member)
    {
        //
        if (authorize($this->menuCode, 'DESTROY', false)) {
            $team_member = TeamMember::where('id', '=', $team_member->id);
            $team_member->update(['status' => 'deleted']);
            $data['type']       = 'success';
            $data['message']    = 'Record Updated Sucessfully!!!';
        } else {
            $data['type']       = 'error';
            $data['message']    = 'Invalid Request!';
        }
        return $data;
    }
}
