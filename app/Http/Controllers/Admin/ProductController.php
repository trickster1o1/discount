<?php

namespace App\Http\Controllers\Admin;

use Toastr;
use App\Http\Controllers\Admin\Controller;
use App\Http\Requests\Admin\ProductAddRequest;
use App\Models\Admin\Category;
use App\Models\Admin\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $menuCode = 'PRODCT';
    private $category_type = 'product';
    private $table      = 'products';



    function product_data(Request $request)
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
        $iTotalRecords    = Product::getTotal($filter);
        $iDisplayLength = isset($request->length) ? intval($request->length) : 100;
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart =  isset($request->start) ? intval($request->start) : 0;
        $sEcho = intval($request->draw);

        $end = $iDisplayStart + $iDisplayLength;
        $end = $end > $iTotalRecords ? $iTotalRecords : $end;

        $pagination['limit'] = $iDisplayLength;
        $pagination['offset'] = $iDisplayStart;

        $products =  Product::getData($sort, $pagination, $filter);

        if ($products != null) {
            foreach ($products as $key => $product) :
                $action = '';
                $records["data"][$key][] = $product->title;
                $records["data"][$key][] = 'Rs. ' . $product->price;
                $records["data"][$key][] = $product->category_title;

                $records["data"][$key][] = '<input data-table="' . $this->table . '" data-url="' . url('admin/dashboard/update_order/' . $product->id) . '" type="number" value="' . $product->order_by . '" class="text-right update_order">';

                $status = ($product->status == 'active') ? '<i class="fa fa-check-circle fa-2x text-success"></i>' : '<i class="fa fa-times-circle fa-2x text-danger"></i>';

                $is_featured = (strtolower($product->is_featured) == 'yes') ? '<i class="fa fa-check-circle fa-2x text-success"></i>' : '<i class="fa fa-times-circle fa-2x text-danger"></i>';
                //Is featured
                if (authorize($this->menuCode, 'UPDATE', false)) {
                    $records["data"][$key][] = '<a href="javascript:void(0);" class="featured-record" data-id="' . $product->id . '"
                                            data-table="' . $this->table . '" data-status="' . $product->is_featured . '">' . $is_featured . '</a>';
                } else {
                    $records["data"][$key][] = '<a href="javascript:void(0);">' . $is_featured . '</a>';
                }

                //Status
                if (authorize($this->menuCode, 'UPDATE', false)) {
                    $records["data"][$key][] = '<a href="javascript:void(0);" class="record-status" data-id="' . $product->id . '"
                                            data-table="' . $this->table . '" data-status="' . $product->status . '">' . $status . '</a>';
                } else {
                    $records["data"][$key][] = '<a href="javascript:void(0);">' . $status . '</a>';
                }


                if (authorize($this->menuCode, 'UPDATE', false) || authorize($this->menuCode, 'DELETE', false)) {
                    if (authorize($this->menuCode, 'UPDATE', false)) {
                        $action .= '<a href="' . route('product.edit', $product) . '"
                                    class="btn btn-primary btn-sm" title="Edit">
                                    <i class="mdi mdi-square-edit-outline"></i>
                                </a>';
                    }
                    if (authorize($this->menuCode, 'DESTROY', false)) {
                        $action .= '<form class="d-inline swal-delete"
                                    action="' . route('product.destroy', $product) . '" method="POST">
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
        return view('Admin.product.index', ['menucode' => $this->menuCode]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Category::where('category_type', $this->category_type)->get();
        return view('Admin.product.create', compact('categories') + ['menucode' => $this->menuCode]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductAddRequest $req)
    {
        //
        authorize($this->menuCode, 'CREATE');
        $validated = $req->validated();
        $data = Product::create($validated);
        set_order_by($data->id, $this->table);
        set_created_by($data->id, $this->table, auth()->user()->id, 1);
        Toastr::success('Product Created Successfully', 'Sucess');
        return redirect()->route('product.index');
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
        $product = Product::where('status', '!=', 'deleted')->where('id', $id)->first();
        if (!$product) {
            Toastr::error('Product Not Available', 'Warning');
            return redirect()->route('product.index');
        }
        
        $categories = Category::where('status', '!=', 'deleted')->where('category_type', $this->category_type)->get();
        return view('Admin.product.edit', compact(['categories', 'product']) + array('menucode' => $this->menuCode));
   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductAddRequest $request, $id)
    {
        //
        authorize($this->menuCode, 'UPDATE');
        $validated = $request->validated();
        $product = Product::where('status', '!=', 'deleted')->where('id', $id)->first();
        $product->update($validated);
        Toastr::success('Product Updated Sucessfully', 'Sucess');
        return redirect()->route('product.index');
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
            $blog = Product::where('id', '=', $id);
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
