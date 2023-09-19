<?php

namespace App\Http\Controllers\Admin;

use Toastr;
use Illuminate\Http\Request;
use App\Models\Admin\Category;
use App\Http\Controllers\Admin\Controller;
use App\Http\Requests\Admin\StoreNoticeRequest;
use App\Http\Requests\Admin\UpdateNoticeRequest;
use App\Models\Admin\Notice;

class NoticeController extends Controller
{
    private $menuCode = 'NOTICE';

    private $table = 'notices';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        authorize($this->menuCode, 'INDEX');
        return view('Admin.notice.index', ['menucode' => $this->menuCode]);
    }
    function notice_data(Request $request)
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
        $iTotalRecords    = Notice::getTotal($filter);
        $iDisplayLength = isset($request->length) ? intval($request->length) : 100;
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart =  isset($request->start) ? intval($request->start) : 0;
        $sEcho = intval($request->draw);

        $end = $iDisplayStart + $iDisplayLength;
        $end = $end > $iTotalRecords ? $iTotalRecords : $end;

        $pagination['limit'] = $iDisplayLength;
        $pagination['offset'] = $iDisplayStart;

        $notices =  Notice::getData($sort, $pagination, $filter);

        if ($notices != null) {
            foreach ($notices as $key => $notice) :
                $action = '';
                $records["data"][$key][] = $notice->title;
                $records["data"][$key][] = $notice->category_title;
                $records["data"][$key][] = $notice->sub_category_title;
                $records["data"][$key][] = $notice->published_date;
                $records["data"][$key][] = '<input data-table="' . $this->table . '" data-url="' . url('admin/dashboard/update_order/' . $notice->id) . '" type="number" value="' . $notice->order_by . '" class="text-right update_order">';
                $status = ($notice->status == 'active') ? '<i class="fa fa-check-circle fa-2x text-success"></i>' : '<i class="fa fa-times-circle fa-2x text-danger"></i>';

                if (authorize($this->menuCode, 'UPDATE', false)) {
                    $records["data"][$key][] = '<a href="javascript:void(0);" class="record-status" data-id="' . $notice->id . '"
                                            data-table="' . $this->table . '" data-status="' . $notice->status . '">' . $status . '</a>';
                } else {
                    $records["data"][$key][] = '<a href="javascript:void(0);">' . $status . '</a>';
                }
                if (authorize($this->menuCode, 'UPDATE', false) || authorize($this->menuCode, 'DELETE', false)) {
                    if (authorize($this->menuCode, 'UPDATE', false)) {
                        $action .= '<a href="' . route('notices.edit', $notice) . '"
                                    class="btn btn-primary btn-sm" title="Edit">
                                    <i class="mdi mdi-square-edit-outline"></i>
                                </a>';
                    }
                    if (authorize($this->menuCode, 'DESTROY', false)) {
                        $action .= '<form class="d-inline swal-delete"
                                    action="' . route('notices.destroy', $notice) . '" method="POST">
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
        $categories = Category::where('status', '!=', 'deleted')->where('category_type','notice')->get();
        return view('Admin.notice.create', compact(['categories']) + array('menucode' => $this->menuCode));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNoticeRequest $request)
    {
        //
        authorize($this->menuCode, 'CREATE');
        $validated = $request->validated();
        $notice = Notice::create($validated);
        $notice->order_by = count(Notice::get());
        $notice->save();
        $this->modified_by('create',$notice);

        Toastr::success('Notice Created Successfully', 'Sucess');
        return redirect()->route('notices.index');
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
    public function edit(Notice $notice)
    {
        //
        authorize($this->menuCode, 'UPDATE');
        $id = $notice->id;
        $notice = Notice::where('status', '!=', 'deleted')->where('id', $id)->first(); //check status
        if ($notice) {
            $categories = Category::where('status', '!=', 'deleted')->get();
            return view('Admin.notice.edit', compact(['categories', 'notice']) + array('menucode' => $this->menuCode));
        } else {
            return redirect()->route('notices.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNoticeRequest $request, Notice $notice)
    {
        //
        authorize($this->menuCode, 'UPDATE');
        $validated = $request->validated();
        $notice->update($validated);
        $this->modified_by('update',$notice);

        Toastr::success('Notice Updated Sucessfully', 'Sucess');
        return redirect()->route('notices.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notice $notice)
    {
        //
        if (authorize($this->menuCode, 'DESTROY', false)) {
            $notice = Notice::where('id', '=', $notice->id);
            $notice->update(['status' => 'deleted']);
            $data['type']       = 'success';
            $data['message']    = 'Record Updated Sucessfully!!!';
        } else {
            $data['type']       = 'error';
            $data['message']    = 'Invalid Request!';
        }
        return $data;
    }
}
