<?php

namespace App\Http\Controllers\Admin;

use Toastr;
use Illuminate\Http\Request;
use App\Models\Admin\Category;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Admin\CategoryType;

class CategoriesController extends Controller
{
    //
    private $menuCode = 'CATEGORY';
    private $table    = 'categories';

    //index for categories
    function index()
    {
        authorize($this->menuCode, 'INDEX');
        return view('Admin.categories.index', ['menucode' => $this->menuCode]);
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
        $iTotalRecords    = Category::getTotal($filter);
        $iDisplayLength = isset($request->length) ? intval($request->length) : 100;
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart =  isset($request->start) ? intval($request->start) : 0;
        $sEcho = intval($request->draw);

        $end = $iDisplayStart + $iDisplayLength;
        $end = $end > $iTotalRecords ? $iTotalRecords : $end;

        $pagination['limit'] = $iDisplayLength;
        $pagination['offset'] = $iDisplayStart;

        $categories =  Category::getData($sort, $pagination, $filter);

        if ($categories != null) {
            foreach ($categories as $key => $category) :
                $action = '';
                $records["data"][$key][] = $category->title;
                $records["data"][$key][] = $category->category_type_title;

                $records["data"][$key][] = '<input data-table="' . $this->table . '" data-url="' . url('admin/dashboard/update_order/' . $category->id) . '" type="number" value="' . $category->order_by . '" class="text-right update_order">';

                $status = ($category->status == 'active') ? '<i class="fa fa-check-circle fa-2x text-success"></i>' : '<i class="fa fa-times-circle fa-2x text-danger"></i>';

                if (authorize($this->menuCode, 'UPDATE', false)) {
                    $records["data"][$key][] = '<a href="javascript:void(0);" class="record-status" data-id="' . $category->id . '"
                                            data-table="' . $this->table . '" data-status="' . $category->status . '">' . $status . '</a>';
                } else {
                    $records["data"][$key][] = '<a href="javascript:void(0);">' . $status . '</a>';
                }
                if (authorize($this->menuCode, 'UPDATE', false) || authorize($this->menuCode, 'DELETE', false)) {
                    if (authorize($this->menuCode, 'UPDATE', false)) {
                        $action .= '<a href="' . route('categories.edit', $category) . '"
                                    class="btn btn-primary btn-sm" title="Edit">
                                    <i class="mdi mdi-square-edit-outline"></i>
                                </a>';
                    }
                    if (authorize($this->menuCode, 'DESTROY', false)) {
                        $action .= '<form class="d-inline swal-delete"
                                    action="' . route('categories.destroy', $category) . '" method="POST">
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

    //function to open create categories
    public function create()
    {
        authorize($this->menuCode, 'CREATE');
        $category_types = CategoryType::get();
        return view('Admin.categories.create', compact('category_types') + array('menucode' => $this->menuCode));
    }
    //function to store newly created categories
    public function store(StoreCategoryRequest $request)
    {
        authorize($this->menuCode, 'CREATE');
        $validated = $request->validated();
        $data = Category::create($validated);
        set_order_by($data->id, $this->table);
        Toastr::success('Category Created Successfully', 'Sucess');
        return redirect()->route('categories.index');
    }
    //function to show update form
    public function edit(Category $category)
    {
        authorize($this->menuCode, 'UPDATE');
        $id = $category->id;
        $category = Category::where('status', '!=', 'deleted')->where('id', $id)->first(); //check status
        if ($category) {
            $category_types = CategoryType::get();
            return view('Admin.categories.edit', compact(['category',  'category_types']) + array('menucode' => $this->menuCode));
        } else {
            return redirect()->route('categories.index');
        }
    }

    public function show(Category $category)
    {
        authorize($this->menuCode, 'SHOW');
        abort(404);
    }


    //funtion to update the value
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        authorize($this->menuCode, 'UPDATE');
        $validated = $request->validated();
        $category->update($validated);
        $url = $request->redirects_to;
        Toastr::success('Category Updated Sucessfully', 'Sucess');
        return redirect($url);
    }

    //delete the category
    public function destroy(Category $category)
    {
        if (authorize($this->menuCode, 'DESTROY', false)) {
            $category = Category::where('id', '=', $category->id);
            $category->update(['status' => 'deleted']);
            $data['type']       = 'success';
            $data['message']    = 'Record Deleted Sucessfully!!!';
        } else {
            $data['type']       = 'error';
            $data['message']    = 'Invalid Request!';
        }
        return $data;
    }
}
