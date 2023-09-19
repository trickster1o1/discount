<?php

namespace App\Http\Controllers\Admin;

use Toastr;
use App\Http\Controllers\Admin\Controller;
use App\Http\Requests\Admin\StoreCounterInfoRequest;
use App\Http\Requests\Admin\UpdateCounterInfoRequest;
use App\Models\Admin\CounterInformation;
use Illuminate\Http\Request;

class CounterInfoController extends Controller
{
    private $menuCode = 'COUNTERINFOS';

    private $table = 'counter_information';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        authorize($this->menuCode, 'INDEX');
        return view('Admin.counter_informations.index', ['menucode' => $this->menuCode]);
    }

    function counter_data(Request $request)
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
        $iTotalRecords    = CounterInformation::getTotal($filter);
        $iDisplayLength = isset($request->length) ? intval($request->length) : 100;
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart =  isset($request->start) ? intval($request->start) : 0;
        $sEcho = intval($request->draw);

        $end = $iDisplayStart + $iDisplayLength;
        $end = $end > $iTotalRecords ? $iTotalRecords : $end;

        $pagination['limit'] = $iDisplayLength;
        $pagination['offset'] = $iDisplayStart;

        $counter_informations =  CounterInformation::getData($sort, $pagination, $filter);

        if ($counter_informations != null) {
            foreach ($counter_informations as $key => $counter_info) :
                $action = '';
                $records["data"][$key][] = $counter_info->title;
                $records["data"][$key][] = $counter_info->counter_number;
                $records["data"][$key][] = '<input data-table="' . $this->table . '" data-url="' . url('admin/dashboard/update_order/' . $counter_info->id) . '" type="number" value="' . $counter_info->order_by . '" class="text-right update_order">';
                $status = ($counter_info->status == 'active') ? '<i class="fa fa-check-circle fa-2x text-success"></i>' : '<i class="fa fa-times-circle fa-2x text-danger"></i>';

                if (authorize($this->menuCode, 'UPDATE', false)) {
                    $records["data"][$key][] = '<a href="javascript:void(0);" class="record-status" data-id="' . $counter_info->id . '"
                                        data-table="' . $this->table . '" data-status="' . $counter_info->status . '">' . $status . '</a>';
                } else {
                    $records["data"][$key][] = '<a href="javascript:void(0);">' . $status . '</a>';
                }
                if (authorize($this->menuCode, 'UPDATE', false) || authorize($this->menuCode, 'DELETE', false)) {
                    if (authorize($this->menuCode, 'UPDATE', false)) {
                        $action .= '<a href="' . route('counter_infos.edit', $counter_info) . '"
                                class="btn btn-primary btn-sm" title="Edit">
                                <i class="mdi mdi-square-edit-outline"></i>
                            </a>';
                    }
                    if (authorize($this->menuCode, 'DESTROY', false)) {
                        $action .= '<form class="d-inline swal-delete"
                                action="' . route('counter_infos.destroy', $counter_info) . '" method="POST">
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
        return view('Admin.counter_informations.create',  ['menucode' => $this->menuCode]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCounterInfoRequest $request)
    {
        //
        authorize($this->menuCode, 'CREATE');
        $validated = $request->validated();
        $counter_information = CounterInformation::create($validated);
        $counter_information->order_by = count(CounterInformation::get());
        $counter_information->save();
        $this->modified_by('create',$counter_information);

        Toastr::success('Counter Information Added Successfully', 'Sucess');
        return redirect()->route('counter_infos.index');
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
    public function edit(CounterInformation $counter_info)
    {
        //
        authorize($this->menuCode, 'UPDATE');
        return view('Admin.counter_informations.edit', compact(['counter_info']) + array('menucode' => $this->menuCode));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCounterInfoRequest $request, CounterInformation $counter_info)
    {
        //
        //dd($request->input());
        authorize($this->menuCode, 'UPDATE');
        $validated = $request->validated();
        $counter_info->update($validated);
        $this->modified_by('update',$counter_info);

        Toastr::success('Counter Information Updated Sucessfully', 'Sucess');
        return redirect()->route('counter_infos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CounterInformation $counter_info)
    {
        //
        if (authorize($this->menuCode, 'DESTROY', false)) {
            $counter_info = CounterInformation::where('id', '=', $counter_info->id);
            $counter_info->update(['status' => 'deleted']);
            $data['type']       = 'success';
            $data['message']    = 'Record Updated Sucessfully!!!';
        } else {
            $data['type']       = 'error';
            $data['message']    = 'Invalid Request!';
        }
        return $data;
    }
}
