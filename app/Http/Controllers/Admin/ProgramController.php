<?php

namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\Controller;

use App\Http\Requests\ProgramRequest;
use App\Models\Admin\Album;
use Illuminate\Http\Request;
use App\Models\Admin\Category;
use App\Models\Admin\Program;
use Toastr;

class ProgramController extends Controller
{
    
    private $menuCode = 'PROGRAMS';
    public $model = 'App\Models\Admin\Program';
    private $table    = 'programs';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('Admin.program.index', ['menucode'=>$this->menuCode]);

    }

    
        
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
               $records["data"][$key][] = $category->title;
               $records["data"][$key][] = $category->start_date;
               $records["data"][$key][] = (!empty(trim($category->target_amount)))?'Rs'.$category->target_amount:'';
               $records["data"][$key][] = (!empty(trim($category->target_amount)))?'Rs.'.$category->donation_amount:'';
               // $records["data"][$key][] = $category->order_by;

               $records["data"][$key][] = '<input data-table="'.$this->table.'" data-url="' . url('admin/dashboard/update_order/' . $category->id) . '" type="number" value="' . $category->order_by . '" class="text-right update_order">';

               //Is featured
               $is_featured = (strtolower($category->is_featured) == 'yes') ? '<i class="fa fa-check-circle fa-2x text-success"></i>' : '<i class="fa fa-times-circle fa-2x text-danger"></i>';                
                if (authorize($this->menuCode, 'UPDATE', false)) {
                    $records["data"][$key][] = '<a href="javascript:void(0);" class="featured-record" data-id="' . $category->id . '"
                                            data-table="' . $this->table . '" data-status="' . $category->is_featured . '">' . $is_featured . '</a>';
                } else {
                    $records["data"][$key][] = '<a href="javascript:void(0);">' . $is_featured . '</a>';
                }

               $status = ($category->status == 'active') ? '<i class="fa fa-check-circle fa-2x text-success"></i>' : '<i class="fa fa-times-circle fa-2x text-danger"></i>';

               if (authorize($this->menuCode, 'UPDATE', false)) {
                   $records["data"][$key][] = '<a href="javascript:void(0);" class="record-status" data-id="' . $category->id . '"data-table="'.$this->table.'" data-status="' . $category->status . '">' . $status . '</a>';
               } else {
                   $records["data"][$key][] = '<a href="javascript:void(0);">' . $status . '</a>';
               }
               if (authorize($this->menuCode, 'UPDATE', false) || authorize($this->menuCode, 'DELETE', false)) {
                   if (authorize($this->menuCode, 'UPDATE', false)) {
                       $action .= '<a href="' . route('program.edit', $category) . '"
                                   class="btn btn-primary btn-sm" title="Edit">
                                   <i class="mdi mdi-square-edit-outline"></i>
                               </a>';
                   }
                   if (authorize($this->menuCode, 'DESTROY', false)) {
                       $action .= '<form class="d-inline swal-delete"
                                   action="' . route('program.destroy', $category) . '" method="POST">
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
        $categories = Category::where('status', '!=', 'deleted')->
        where('category_type','program')->get();
        $galleries = Album::get(['id','title as name']);
        return view('Admin.program.create',compact('categories','galleries') + ['menucode'=>$this->menuCode]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProgramRequest $request)
    {
        //
        
        authorize($this->menuCode, 'CREATE');
        $data = $this->model::create($request->input());
        set_order_by($data->id, $this->table);
        $this->modified_by('create',$data);

        \Toastr::success('Program Created Successfully', 'Sucess');
        return redirect()->route('program.index');
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
        $event = $this->model::where('id',$id)->where('status','!=','deleted')->first();
        if(!$event) {
            return redirect()->route('program.index');
        }
        $categories = Category::where('status', '!=', 'deleted')->
        where('category_type','program')->get();
        $galleries = Album::get(['id','title as name']);
        return view('Admin.program.edit', compact('event','categories','galleries') + ['menucode'=>$this->menuCode]);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProgramRequest $request, Program $program)
    {
        //
        
        authorize($this->menuCode, 'UPDATE');
        $program->update($request->input());
        $url = $request->redirects_to;
        $this->modified_by('update',$program);

        Toastr::success('Program Updated Sucessfully', 'Sucess');
        return redirect($url);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Program $program)
    {
        //
        if (authorize($this->menuCode, 'DESTROY', false)) {
            // $donner = $this->model::where('id', '=', $donner->id);
            $program->update(['status' => 'deleted']);
            $data['type']       = 'success';
            $data['message']    = 'Record Deleted Sucessfully!!!';
        } else {
            $data['type']       = 'error';
            $data['message']    = 'Invalid Request!';
        }
        return $data;
    }
}
