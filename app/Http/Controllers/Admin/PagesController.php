<?php

namespace App\Http\Controllers\Admin;

use Toastr;
use App\Models\Admin\Page;
use App\Models\Admin\Category;
use App\Models\Admin\Sub_Category;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\StorePageRequest;
use App\Http\Requests\Admin\UpdatePageRequest;

class PagesController extends Controller
{
    private $menuCode       = 'PAGES';
    private $category_type  = 'pages';
    private $table = 'pages';

    //index for Pages
    function index()
    {
        authorize($this->menuCode, 'INDEX');
        return view('Admin.pag_es.index', ['menucode' => $this->menuCode]);
    }

    function page_data(Request $request)
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
        $iTotalRecords    = Page::getTotal($filter);
        $iDisplayLength = isset($request->length) ? intval($request->length) : 100;
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart =  isset($request->start) ? intval($request->start) : 0;
        $sEcho = intval($request->draw);

        $end = $iDisplayStart + $iDisplayLength;
        $end = $end > $iTotalRecords ? $iTotalRecords : $end;

        $pagination['limit'] = $iDisplayLength;
        $pagination['offset'] = $iDisplayStart;

        $pages =  Page::getData($sort, $pagination, $filter);

        if ($pages != null) {
            foreach ($pages as $key => $page) :
                $action = '';
                $records["data"][$key][] = $page->title;
                $records["data"][$key][] = $page->category_title;
                $records["data"][$key][] = $page->sub_category_title;

                $records["data"][$key][] = '<input data-table="' . $this->table . '" data-url="' . url('admin/dashboard/update_order/' . $page->id) . '" type="number" value="' . $page->order_by . '" class="text-right update_order">';

                $status = ($page->status == 'active') ? '<i class="fa fa-check-circle fa-2x text-success"></i>' : '<i class="fa fa-times-circle fa-2x text-danger"></i>';

                if (authorize($this->menuCode, 'UPDATE', false)) {
                    $records["data"][$key][] = '<a href="javascript:void(0);" class="record-status" data-id="' . $page->id . '"
                                            data-table="' . $this->table . '" data-status="' . $page->status . '">' . $status . '</a>';
                } else {
                    $records["data"][$key][] = '<a href="javascript:void(0);">' . $status . '</a>';
                }
                if (authorize($this->menuCode, 'UPDATE', false) || authorize($this->menuCode, 'DELETE', false)) {
                    if (authorize($this->menuCode, 'UPDATE', false)) {
                        $action .= '<a href="' . route('pages.edit', $page) . '"
                                    class="btn btn-primary btn-sm" title="Edit">
                                    <i class="mdi mdi-square-edit-outline"></i>
                                </a>';
                    }
                    if (authorize($this->menuCode, 'DESTROY', false)) {
                        $action .= '<form class="d-inline swal-delete"
                                    action="' . route('pages.destroy', $page) . '" method="POST">
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

    public function create()
    {
        authorize($this->menuCode, 'CREATE');
        $categories     = Category::where('status', '!=', 'deleted')->where('category_type', $this->category_type)->get();
        return view('Admin.pag_es.create', compact(['categories']) + array('menucode' => $this->menuCode));
    }
    //function to store newly created categories
    public function store(StorePageRequest $request)
    {
        authorize($this->menuCode, 'CREATE');
        $validated = $request->validated();
        $data = Page::create($validated);
        set_order_by($data->id, $this->table);
        Toastr::success('Page Created Successfully', 'Sucess');
        return redirect()->route('pages.index');
    }

    public function show(Page $page)
    {
        authorize($this->menuCode, 'SHOW');
        abort(404);
    }
    //function to show update form
    public function edit(Page $page)
    {
        authorize($this->menuCode, 'UPDATE');
        $id = $page->id;
        $page = Page::where('status', '!=', 'deleted')->where('id', $id)->first(); //check status
        if ($page) {
            $categories = Category::where('status', '!=', 'deleted')->get();
            return view('Admin.pag_es.edit', compact(['categories', 'page']) + array('menucode' => $this->menuCode));
        } else {
            return redirect()->route('pages.index');
        }
    }
    //funtion to update the value
    public function update(UpdatePageRequest $request, Page $page)
    {
        authorize($this->menuCode, 'UPDATE');
        $validated = $request->validated();
        $page->update($validated);
        Toastr::success('Page Updated Sucessfully', 'Sucess');
        return redirect()->route('pages.index');
    }

    //delete the category
    public function destroy(Page $page)
    {
        if (authorize($this->menuCode, 'DESTROY', false)) {
            $page = Page::where('id', '=', $page->id);
            $page->update(['status' => 'deleted']);
            $data['type']       = 'success';
            $data['message']    = 'Record Updated Sucessfully!!!';
        } else {
            $data['type']       = 'error';
            $data['message']    = 'Invalid Request!';
        }
        return $data;
    }
}
