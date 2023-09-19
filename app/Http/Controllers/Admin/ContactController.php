<?php

namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    
    private $menuCode = 'CONTACT';
    public $model = 'App\Models\Admin\Contact';
    private $table    = 'contacts';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        authorize($this->menuCode,'INDEX');
        return view('Admin.contact.index', ['menucode'=>$this->menuCode]);

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
           foreach ($categories as $key => $category) :
               $action = '';

               if(strlen($category->message) > 105){
                $short_message = substr($category->message, 0,105).'<br/><a href="javascript:void(0);" class="read-full-message text-right">...Show More</a>';
                $full_message  = $category->message;

                $message = '<div class="text-wrap max-width-350">
                                <span class="show-message short-message">'.$short_message.'</span>
                                <span class="hide-message full-message">'.$full_message.'<br/><a href="javascript:void(0);" class="hide-full-message text-right">...Show Less</a></span>
                            </div>';
               }else{
                $message = '<div class="text-wrap max-width-350">'.$category->message.'</div>';
               }

               $records["data"][$key][] = $category->fullName;
               $records["data"][$key][] = '<a href="tel:'.$category->number.'">'.$category->number.'</a>';
               $records["data"][$key][] = '<a href="mailto:'.$category->email.'">'.$category->email.'</a>';
               $records["data"][$key][] = $category->subject;
               $records["data"][$key][] = $message;
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
        abort_if(true,403);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(true,403);
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
    public function edit($id)
    {
        abort_if(true,403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort_if(true,403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(true,403);
    }
}
