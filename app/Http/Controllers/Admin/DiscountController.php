<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use App\Http\Requests\Admin\DiscountRequest;
use App\Models\Admin\Discount;
use App\Models\Admin\Product;
use Illuminate\Http\Request;
use Toastr;
class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
     private $menuCode = 'DISCOUNT';
     private $table      = 'discounts';

    

     function discount_data(Request $request)
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
         $iTotalRecords    = Discount::getTotal($filter);
         $iDisplayLength = isset($request->length) ? intval($request->length) : 100;
         $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
         $iDisplayStart =  isset($request->start) ? intval($request->start) : 0;
         $sEcho = intval($request->draw);
 
         $end = $iDisplayStart + $iDisplayLength;
         $end = $end > $iTotalRecords ? $iTotalRecords : $end;
 
         $pagination['limit'] = $iDisplayLength;
         $pagination['offset'] = $iDisplayStart;
 
         $discounts =  Discount::getData($sort, $pagination, $filter);
 
         if ($discounts != null) {
             foreach ($discounts as $key => $discount) :
                 $action = '';
                 $records["data"][$key][] = $discount->product_title;
                 $records["data"][$key][] = 'Rs. '. $discount->product->price;
                 $records["data"][$key][] = ($discount->type == 'fixed' ? 'Rs. ' : null) . $discount->value . ($discount->type == 'percent' ? '%' : null);
  
                 $status = ($discount->status == 'active') ? '<i class="fa fa-check-circle fa-2x text-success"></i>' : '<i class="fa fa-times-circle fa-2x text-danger"></i>';
 
                 //Status
                 if (authorize($this->menuCode, 'UPDATE', false)) {
                     $records["data"][$key][] = '<a href="javascript:void(0);" class="record-status" data-id="' . $discount->id . '"
                                             data-table="' . $this->table . '" data-status="' . $discount->status . '">' . $status . '</a>';
                 } else {
                     $records["data"][$key][] = '<a href="javascript:void(0);">' . $status . '</a>';
                 }
 
 
                 if (authorize($this->menuCode, 'UPDATE', false) || authorize($this->menuCode, 'DELETE', false)) {
                     if (authorize($this->menuCode, 'UPDATE', false)) {
                         $action .= '<a href="' . route('discount.edit', $discount) . '"
                                     class="btn btn-primary btn-sm" title="Edit">
                                     <i class="mdi mdi-square-edit-outline"></i>
                                 </a>';
                     }
                     if (authorize($this->menuCode, 'DESTROY', false)) {
                         $action .= '<form class="d-inline swal-delete"
                                     action="' . route('discount.destroy', $discount) . '" method="POST">
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


    public function index()
    {
        //
        authorize($this->menuCode, 'INDEX');
        return view('Admin.discount.index', ['menucode' => $this->menuCode]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        
        $products = Product::where('status','active')->get();
        return view('Admin.discount.create', compact('products') + ['menucode' => $this->menuCode]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DiscountRequest $req)
    {
        //
        authorize($this->menuCode, 'CREATE');
        $validated = $req->validated();
        $product = Product::where('status','active')
        ->where('id',$req->product_id)->first();
        if(!$product) {
            return redirect()->route('discount.create');
        }
        $data = $product->discount()->create($validated);
        // set_order_by($data->id, $this->table);
        set_created_by($data->id, $this->table, auth()->user()->id, 1);
        Toastr::success('Product Created Successfully', 'Sucess');
        return redirect()->route('discount.index');
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
        $discount = Discount::where('id',$id)->where('status','!=','deleted')->first();
        if (!$discount) {
            Toastr::error('Discount Not Available', 'Warning');
            return redirect()->route('discount.index');
        }
        $products = Product::where('status', 'active')->get();
        return view('Admin.discount.edit', compact(['products', 'discount']) + array('menucode' => $this->menuCode));
   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DiscountRequest $request, $id)
    {
        //
        authorize($this->menuCode, 'UPDATE');
        $validated = $request->validated();
        $discount = Discount::where('status','!=','deleted')->where('id',$id)->first();
        $discount->update($validated);
        set_created_by($discount->id, $this->table, auth()->user()->id, 2);
        Toastr::success('Discount Updated Sucessfully', 'Sucess');
        return redirect()->route('discount.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if (authorize($this->menuCode, 'DESTROY', false)) {
            $blog = Discount::where('id', '=', $id);
            $blog->update(['status' => 'deleted']);
            $data['type']       = 'success';
            $data['message']    = 'Record Deleted Sucessfully!!!';
        } else {
            $data['type']       = 'error';
            $data['message']    = 'Invalid Request!';
        }
        return $data;
    }
}
