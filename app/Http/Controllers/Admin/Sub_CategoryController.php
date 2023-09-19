<?php

namespace App\Http\Controllers\Admin;

use Toastr;
use Illuminate\Http\Request;
use App\Models\Admin\Category;
use App\Models\Admin\CategoryType;
use App\Models\Admin\Sub_Category;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Admin\StoreSubCategoryRequest;
use App\Http\Requests\Admin\UpdateSubCategoryRequest;


class Sub_CategoryController extends Controller
{
    //
    private $menuCode   = 'SUBCATEGORY';
    private $table      = 'sub_categories';

    // dispaly the list of sub categories
    public function index()
    {
        authorize($this->menuCode, 'INDEX');
        return view('Admin.sub_categories.index', ['menucode' => $this->menuCode]);
    }

    public function sub_cat_data(Request $request)
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
        $iTotalRecords    = Sub_Category::getTotal($filter);
        $iDisplayLength = isset($request->length) ? intval($request->length) : 100;
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart =  isset($request->start) ? intval($request->start) : 0;
        $sEcho = intval($request->draw);

        $end = $iDisplayStart + $iDisplayLength;
        $end = $end > $iTotalRecords ? $iTotalRecords : $end;

        $pagination['limit'] = $iDisplayLength;
        $pagination['offset'] = $iDisplayStart;

        $sub_categories =  Sub_Category::getData($sort, $pagination, $filter);

        if ($sub_categories != null) {
            foreach ($sub_categories as $key => $sub_category) :
                $action = '';
                $records["data"][$key][] = $sub_category->title;
                $records["data"][$key][] = $sub_category->category_type_title;
                $records["data"][$key][] = $sub_category->category_title;

                $records["data"][$key][] = '<input data-table="' . $this->table . '" data-url="' . url('admin/dashboard/update_order/' . $sub_category->id) . '" type="number" value="' . $sub_category->order_by . '" class="text-right update_order">';

                $status = ($sub_category->status == 'active') ? '<i class="fa fa-check-circle fa-2x text-success"></i>' : '<i class="fa fa-times-circle fa-2x text-danger"></i>';

                if (authorize($this->menuCode, 'UPDATE', false)) {
                    $records["data"][$key][] = '<a href="javascript:void(0);" class="record-status" data-id="' . $sub_category->id . '"
                                            data-table="' . $this->table . '" data-status="' . $sub_category->status . '">' . $status . '</a>';
                } else {
                    $records["data"][$key][] = '<a href="javascript:void(0);">' . $status . '</a>';
                }
                if (authorize($this->menuCode, 'UPDATE', false) || authorize($this->menuCode, 'DELETE', false)) {
                    if (authorize($this->menuCode, 'UPDATE', false)) {
                        $action .= '<a href="' . route('sub_categories.edit', $sub_category) . '"
                                    class="btn btn-primary btn-sm" title="Edit">
                                    <i class="mdi mdi-square-edit-outline"></i>
                                </a>';
                    }
                    if (authorize($this->menuCode, 'DESTROY', false)) {
                        $action .= '<form class="d-inline swal-delete"
                                    action="' . route('sub_categories.destroy', $sub_category) . '" method="POST">
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

    //displat the create new subcategor form
    public function create()
    {
        authorize($this->menuCode, 'CREATE');
        $category_types = CategoryType::where('status', '!=', 'deleted')->get();
        $categories = Category::where('status', '!=', 'deleted')->get();
        return view('Admin.sub_categories.create', compact(['category_types', 'categories']) + array('menucode' => $this->menuCode));
    }

    //store the new subcategories
    public function store(StoreSubCategoryRequest $request)
    {
        authorize($this->menuCode, 'CREATE');
        $validated = $request->validated();
        $data = Sub_Category::create($validated);
        set_order_by($data->id, $this->table);
        Toastr::success('Sub-Category Created Successfully', 'Sucess');
        return redirect()->route('sub_categories.index');
    }

    //function to show error message
    public function show(Sub_Category $sub_category)
    {
        authorize($this->menuCode, 'SHOW');
        abort(404);
    }

    //function to show update form
    public function edit(Sub_Category $sub_category)
    {
        authorize($this->menuCode, 'UPDATE');
        $id = $sub_category->id;
        $sub_category = Sub_Category::where('status', '!=', 'deleted')->where('id', $id)->first(); //check status
        if ($sub_category) {
            $category_types = CategoryType::where('status', '!=', 'deleted')->get();
            $categories = Category::where('status', '!=', 'deleted')->get();
            return view('Admin.sub_categories.edit', compact(['sub_category', 'categories', 'category_types']) + array('menucode' => $this->menuCode));
        } else {
            return redirect()->route('sub_categories.index');
        }
    }

    //funtion to update the value
    public function update(UpdateSubCategoryRequest $request, Sub_Category $sub_category)
    {
        authorize($this->menuCode, 'UPDATE');
        //dd($request->post());
        $validated = $request->validated();
        $sub_category->update($validated);
        Toastr::success('Sub-Category Updated Sucessfully', 'Sucess');
        return redirect()->route('sub_categories.index');
    }

    //function to delete the sub-category
    public function destroy(Sub_Category $sub_category)
    {

        if (authorize($this->menuCode, 'DESTROY', false)) {
            $sub_category = Sub_Category::where('id', '=', $sub_category->id);
            $sub_category->update(['status' => 'deleted']);
            $data['type']       = 'success';
            $data['message']    = 'Record Deleted Sucessfully!!!';
        } else {
            $data['type']       = 'error';
            $data['message']    = 'Invalid Request!';
        }
        return $data;
    }
}
