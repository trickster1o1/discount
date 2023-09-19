<?php

namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\Controller;
use Toastr;
use Illuminate\Http\Request;
use App\Models\Admin\Donner;
use App\Http\Requests\DonnerRequest;


class DonnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $menuCode = 'DONNER';
    public $model = 'App\Models\Admin\Donner';
    private $table    = 'donners';

    public function index()
    {
        @authorize($this->menuCode,'INDEX');
        return view('Admin.donner.index', ['menucode'=>$this->menuCode]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


     // Ajax function --------
    
     function data_ajax(Request $request)
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
         
         // change here
         $iTotalRecords    = $this->model::getTotal($filter);
         //-------
         $iDisplayLength = isset($request->length) ? intval($request->length) : 100;
         $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
         $iDisplayStart =  isset($request->start) ? intval($request->start) : 0;
         $sEcho = intval($request->draw);
 
         $end = $iDisplayStart + $iDisplayLength;
         $end = $end > $iTotalRecords ? $iTotalRecords : $end;
 
         $pagination['limit'] = $iDisplayLength;
         $pagination['offset'] = $iDisplayStart;
         // change here
         $categories =  $this->model::getData($sort, $pagination, $filter);
         // --------
         if ($categories != null) {

            // Yo foreach ma error aaoy........
            foreach ($categories as $key => $category) :
                $action = '';
                $records["data"][$key][] = $category->fullName;
                $records["data"][$key][] = $category->email;
                $records["data"][$key][] = $category->number;
                $records["data"][$key][] = $category->position;
                $records["data"][$key][] = $category->getPayment()->method;
                $records["data"][$key][] =  trim($category->amount) ? 'Rs.'.$category->amount : '';
                // $records["data"][$key][] = $category->order_by;

                $records["data"][$key][] = '<input data-table="'.$this->table.'" data-url="' . url('admin/dashboard/update_order/' . $category->id) . '" type="number" value="' . $category->order_by . '" class="text-right update_order">';

                $status = ($category->status == 'active') ? '<i class="fa fa-check-circle fa-2x text-success"></i>' : '<i class="fa fa-times-circle fa-2x text-danger"></i>';

                // thakkai yeta error aayooooo ---------------


                if (authorize($this->menuCode, 'UPDATE', false)) {
                    $records["data"][$key][] = '<a href="javascript:void(0);" class="record-status" data-id="' . $category->id . '"data-table="'.$this->table.'" data-status="' . $category->status . '">' . $status . '</a>';
                } else {
                    $records["data"][$key][] = '<a href="javascript:void(0);">' . $status . '</a>';
                }
                if (authorize($this->menuCode, 'UPDATE', false) || authorize($this->menuCode, 'DELETE', false)) {
                    if (authorize($this->menuCode, 'UPDATE', false)) {
                        $action .= '<a href="' . route('donner.edit', $category) . '"
                                    class="btn btn-primary btn-sm" title="Edit">
                                    <i class="mdi mdi-square-edit-outline"></i>
                                </a>';
                    }
                    if (authorize($this->menuCode, 'DESTROY', false)) {
                        $action .= '<form class="d-inline swal-delete"
                                    action="' . route('donner.destroy', $category) . '" method="POST">
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

     //

    public function create()
    {
        //
        authorize($this->menuCode, 'CREATE');
        $payments = \App\Models\PaymentMethod::get(['method as name', 'code as id']);
        return view('Admin.donner.create', compact('payments') + ['menucode'=>$this->menuCode]);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DonnerRequest $request)
    {
        //
        authorize($this->menuCode, 'CREATE');
        $data = $this->model::create($request->input());
        set_order_by($data->id, $this->table);
        $this->modified_by('create',$data);
        Toastr::success('Doner Created Successfully', 'Sucess');
        return redirect()->route('donner.index');
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
    public function edit($id)
    {
        //
        authorize($this->menuCode, 'UPDATE');
        $donner = $this->model::where('id',$id)->where('status','!=','deleted')->first();
        if(!$donner) {
            return redirect()->route('donner.index');
        }
        $payments = \App\Models\PaymentMethod::get(['method as name', 'id']);

        return view('Admin.donner.edit', compact('payments','donner') + ['menucode'=>$this->menuCode]);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DonnerRequest $request, Donner $donner)
    {
        //
        authorize($this->menuCode, 'UPDATE');
        $donner->update($request->input());
        $this->modified_by('update',$donner);

        $url = $request->redirects_to;
        Toastr::success('Donner Updated Sucessfully', 'Sucess');
        return redirect($url);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Donner $donner)
    {
        //
        if (authorize($this->menuCode, 'DESTROY', false)) {
            // $donner = $this->model::where('id', '=', $donner->id);
            $donner->update(['status' => 'deleted']);
            $data['type']       = 'success';
            $data['message']    = 'Record Deleted Sucessfully!!!';
        } else {
            $data['type']       = 'error';
            $data['message']    = 'Invalid Request!';
        }
        return $data;
    }
}
