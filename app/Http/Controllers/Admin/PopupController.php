<?php

namespace App\Http\Controllers\Admin;

use Toastr;
use App\Models\Admin\Popup;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Controller;
use App\Http\Requests\Admin\StorePopupRequest;
use App\Http\Requests\Admin\UpdatePopupRequest;

class PopupController extends Controller
{

    private $menuCode   = 'POPUP';
    private $table      = 'popups';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        authorize($this->menuCode, 'INDEX');
        return view('Admin.popups.index', ['menucode' => $this->menuCode]);
    }

    function popup_data(Request $request)
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
        $iTotalRecords    = Popup::getTotal($filter);
        $iDisplayLength = isset($request->length) ? intval($request->length) : 100;
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart =  isset($request->start) ? intval($request->start) : 0;
        $sEcho = intval($request->draw);

        $end = $iDisplayStart + $iDisplayLength;
        $end = $end > $iTotalRecords ? $iTotalRecords : $end;

        $pagination['limit'] = $iDisplayLength;
        $pagination['offset'] = $iDisplayStart;

        $popups =  Popup::getData($sort, $pagination, $filter);

        if ($popups != null) {
            foreach ($popups as $key => $popup) :
                $action = '';
                $records["data"][$key][] = $popup->title;
                //$records["data"][$key][] = $popup->popup_description;
                $records["data"][$key][] = $popup->start_date;
                $records["data"][$key][] = $popup->start_time;
                $records["data"][$key][] = $popup->end_date;
                $records["data"][$key][] = $popup->end_time;
                $records["data"][$key][] = '<input data-table="' . $this->table . '" data-url="' . url('admin/dashboard/update_order/' . $popup->id) . '" type="number" value="' . $popup->order_by . '" class="text-right update_order">';
                $status = ($popup->status == 'active') ? '<i class="fa fa-check-circle fa-2x text-success"></i>' : '<i class="fa fa-times-circle fa-2x text-danger"></i>';

                if (authorize($this->menuCode, 'UPDATE', false)) {
                    $records["data"][$key][] = '<a href="javascript:void(0);" class="record-status" data-id="' . $popup->id . '"
                                            data-table="' . $this->table . '" data-status="' . $popup->status . '">' . $status . '</a>';
                } else {
                    $records["data"][$key][] = '<a href="javascript:void(0);">' . $status . '</a>';
                }
                if (authorize($this->menuCode, 'UPDATE', false) || authorize($this->menuCode, 'DELETE', false)) {
                    if (authorize($this->menuCode, 'UPDATE', false)) {
                        $action .= '<a href="' . route('popups.edit', $popup) . '"
                                    class="btn btn-primary btn-sm" title="Edit">
                                    <i class="mdi mdi-square-edit-outline"></i>
                                </a>';
                    }
                    if (authorize($this->menuCode, 'DESTROY', false)) {
                        $action .= '<form class="d-inline swal-delete"
                                    action="' . route('popups.destroy', $popup) . '" method="POST">
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
        return view('Admin.popups.create', ['menucode' => $this->menuCode]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePopupRequest $request)
    {
        //
        authorize($this->menuCode, 'CREATE');
        $validated = $request->validated();
        $data = Popup::create($validated);
        set_order_by($data->id, $this->table);
        $this->modified_by('create',$data);

        Toastr::success('Popup Added Successfully', 'Sucess');
        return redirect()->route('popups.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Popup $popup)
    {
        //
        authorize($this->menuCode, 'UPDATE');
        $id = $popup->id;
        $popup = Popup::where('status', '!=', 'deleted')->where('id', $id)->first(); //check status
        if ($popup) {
            return view('Admin.popups.edit', compact(['popup']) + array('menucode' => $this->menuCode));
        } else {
            return redirect()->route('poppus.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePopupRequest $request, Popup $popup)
    {
        //
        authorize($this->menuCode, 'UPDATE');
        $validated = $request->validated();
        $popup->update($validated);
        $this->modified_by('update',$popup);

        Toastr::success('Popup Uodated Successfully', 'Sucess');
        return redirect()->route('popups.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Popup $popup)
    {
        if (authorize($this->menuCode, 'DESTROY', false)) {
            $popup = Popup::where('id', '=', $popup->id);
            $popup->update(['status' => 'deleted']);
            $data['type']       = 'success';
            $data['message']    = 'Record Deleted Sucessfully!!!';
        } else {
            $data['type']       = 'error';
            $data['message']    = 'Invalid Request!';
        }
        return $data;
    }
}
