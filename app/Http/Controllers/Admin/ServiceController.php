<?php

namespace App\Http\Controllers\Admin;

use Toastr;
use App\Models\Admin\Album;
use Illuminate\Http\Request;
use App\Models\Admin\Service;
use App\Http\Controllers\Admin\Controller;
use App\Http\Requests\Admin\StoreServiceRequest;
use App\Http\Requests\Admin\UpdateServiceRequest;

class ServiceController extends Controller
{
    private $menuCode = 'SERVICE';
    private $table = 'services';

    /**
     * Display a listing of the resource.`
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        authorize($this->menuCode, 'INDEX');
        return view('Admin.servicess.index', ['menucode' => $this->menuCode]);
    }

    function service_data(Request $request)
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
        $iTotalRecords    = Service::getTotal($filter);
        $iDisplayLength = isset($request->length) ? intval($request->length) : 100;
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart =  isset($request->start) ? intval($request->start) : 0;
        $sEcho = intval($request->draw);

        $end = $iDisplayStart + $iDisplayLength;
        $end = $end > $iTotalRecords ? $iTotalRecords : $end;

        $pagination['limit'] = $iDisplayLength;
        $pagination['offset'] = $iDisplayStart;

        $services =  Service::getData($sort, $pagination, $filter);

        if ($services != null) {
            foreach ($services as $key => $service) :
                $action = '';
                $records["data"][$key][] = $service->title;
                $records["data"][$key][] = '<input data-table="' . $this->table . '" data-url="' . url('admin/dashboard/update_order/' . $service->id) . '" type="number" value="' . $service->order_by . '" class="text-right update_order">';
                $status = ($service->status == 'active') ? '<i class="fa fa-check-circle fa-2x text-success"></i>' : '<i class="fa fa-times-circle fa-2x text-danger"></i>';

                //Is featured
                $is_featured = (strtolower($service->is_featured) == 'yes') ? '<i class="fa fa-check-circle fa-2x text-success"></i>' : '<i class="fa fa-times-circle fa-2x text-danger"></i>';
                if (authorize($this->menuCode, 'UPDATE', false)) {
                    $records["data"][$key][] = '<a href="javascript:void(0);" class="featured-record" data-id="' . $service->id . '"
                                            data-table="' . $this->table . '" data-status="' . $service->is_featured . '">' . $is_featured . '</a>';
                } else {
                    $records["data"][$key][] = '<a href="javascript:void(0);">' . $is_featured . '</a>';
                }

                if (authorize($this->menuCode, 'UPDATE', false)) {
                    $records["data"][$key][] = '<a href="javascript:void(0);" class="record-status" data-id="' . $service->id . '"
                                            data-table="' . $this->table . '" data-status="' . $service->status . '">' . $status . '</a>';
                } else {
                    $records["data"][$key][] = '<a href="javascript:void(0);">' . $status . '</a>';
                }
                if (authorize($this->menuCode, 'UPDATE', false) || authorize($this->menuCode, 'DELETE', false)) {
                    if (authorize($this->menuCode, 'UPDATE', false)) {
                        $action .= '<a href="' . route('services.edit', $service) . '"
                                    class="btn btn-primary btn-sm" title="Edit">
                                    <i class="mdi mdi-square-edit-outline"></i>
                                </a>';
                    }
                    if (authorize($this->menuCode, 'DESTROY', false)) {
                        $action .= '<form class="d-inline swal-delete"
                                    action="' . route('services.destroy', $service) . '" method="POST">
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
        $albums = Album::where('status', '!=', 'deleted')->get();
        $services = Service::where('status', '!=', 'deleted')->get();
        return view('Admin.servicess.create', compact(['albums', 'services']) + array('menucode' => $this->menuCode));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServiceRequest $request)
    {
        //
        authorize($this->menuCode, 'CREATE');
        $validated = $request->validated();
        if (isset($request->related_services)) {
            $r_service = implode(',', $request->related_services);
        } else {
            $r_service = null;
        }
        $service = Service::create($validated);
        $service->related_services = $r_service;
        $service->order_by = count(Service::get());
        $service->save();

        $this->modified_by('create',$service);

        Toastr::success('Service Created Successfully', 'Sucess');
        return redirect()->route('services.index');
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
    public function edit(Service $service)
    {
        //
        authorize($this->menuCode, 'UPDATE');
        $albums = Album::where('status', '!=', 'deleted')->get();
        $services = Service::where('status', '!=', 'deleted')->get();
        return view('Admin.servicess.edit', compact(['albums', 'services', 'service']) + array('menucode' => $this->menuCode));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        //
        authorize($this->menuCode, 'UPDATE');
        $validated = $request->validated();
        if ($request->related_services != null) {
            $r_service = implode(',', $request->related_services);
        } else {
            $r_service = null;
        }
        $service->update($validated);
        $service->related_services = $r_service;
        $service->update();
        $this->modified_by('update',$service);

        Toastr::success('Service Updated Sucessfully', 'Sucess');
        return redirect()->route('services.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        //
        if (authorize($this->menuCode, 'DESTROY', false)) {
            $service = Service::where('id', '=', $service->id);
            $service->update(['status' => 'deleted']);
            $data['type']       = 'success';
            $data['message']    = 'Record Updated Sucessfully!!!';
        } else {
            $data['type']       = 'error';
            $data['message']    = 'Invalid Request!';
        }
        return $data;
    }
}
