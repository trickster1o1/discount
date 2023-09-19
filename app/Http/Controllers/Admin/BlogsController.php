<?php

namespace App\Http\Controllers\Admin;

use Toastr;
use App\Models\Admin\Blog;
use App\Models\Admin\Category;
use App\Models\Admin\CategoryType;
use App\Models\Admin\Sub_Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Admin\StoreBlogRequest;
use App\Http\Requests\Admin\UpdateBlogRequest;
use Mockery\Matcher\Subset;

class BlogsController extends Controller
{
    //
    private $menuCode = 'BLOG';
    private $category_type = 'blog';
    private $table      = 'blogs';

    //index for Blogs
    function index()
    {
        authorize($this->menuCode, 'INDEX');
        return view('Admin.blogs.index', ['menucode' => $this->menuCode]);
    }
    function blog_data(Request $request)
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
        $iTotalRecords    = Blog::getTotal($filter);
        $iDisplayLength = isset($request->length) ? intval($request->length) : 100;
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart =  isset($request->start) ? intval($request->start) : 0;
        $sEcho = intval($request->draw);

        $end = $iDisplayStart + $iDisplayLength;
        $end = $end > $iTotalRecords ? $iTotalRecords : $end;

        $pagination['limit'] = $iDisplayLength;
        $pagination['offset'] = $iDisplayStart;

        $blogs =  Blog::getData($sort, $pagination, $filter);

        if ($blogs != null) {
            foreach ($blogs as $key => $blog) :
                $action = '';
                $records["data"][$key][] = $blog->title;
                $records["data"][$key][] = $blog->category_title;
                $records["data"][$key][] = $blog->sub_category_title;

                $records["data"][$key][] = '<input data-table="' . $this->table . '" data-url="' . url('admin/dashboard/update_order/' . $blog->id) . '" type="number" value="' . $blog->order_by . '" class="text-right update_order">';

                $status = ($blog->status == 'active') ? '<i class="fa fa-check-circle fa-2x text-success"></i>' : '<i class="fa fa-times-circle fa-2x text-danger"></i>';

                $is_featured = (strtolower($blog->is_featured) == 'yes') ? '<i class="fa fa-check-circle fa-2x text-success"></i>' : '<i class="fa fa-times-circle fa-2x text-danger"></i>';
                //Is featured
                if (authorize($this->menuCode, 'UPDATE', false)) {
                    $records["data"][$key][] = '<a href="javascript:void(0);" class="featured-record" data-id="' . $blog->id . '"
                                            data-table="' . $this->table . '" data-status="' . $blog->is_featured . '">' . $is_featured . '</a>';
                } else {
                    $records["data"][$key][] = '<a href="javascript:void(0);">' . $is_featured . '</a>';
                }

                //Status
                if (authorize($this->menuCode, 'UPDATE', false)) {
                    $records["data"][$key][] = '<a href="javascript:void(0);" class="record-status" data-id="' . $blog->id . '"
                                            data-table="' . $this->table . '" data-status="' . $blog->status . '">' . $status . '</a>';
                } else {
                    $records["data"][$key][] = '<a href="javascript:void(0);">' . $status . '</a>';
                }


                if (authorize($this->menuCode, 'UPDATE', false) || authorize($this->menuCode, 'DELETE', false)) {
                    if (authorize($this->menuCode, 'UPDATE', false)) {
                        $action .= '<a href="' . route('blogs.edit', $blog) . '"
                                    class="btn btn-primary btn-sm" title="Edit">
                                    <i class="mdi mdi-square-edit-outline"></i>
                                </a>';
                    }
                    if (authorize($this->menuCode, 'DESTROY', false)) {
                        $action .= '<form class="d-inline swal-delete"
                                    action="' . route('blogs.destroy', $blog) . '" method="POST">
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
    //function to open create blogs
    public function create()
    {
        authorize($this->menuCode, 'CREATE');
        $categories = Category::where('status', '!=', 'deleted')->where('category_type', $this->category_type)->get();
        return view('Admin.blogs.create', compact('categories') + array('menucode' => $this->menuCode));
    }

    //function for dynamic view
    public function getsub_category(Request  $request)
    {
        $sub_categories = DB::table("sub_categories")
            ->where("category", $request->cid)
            ->where('status', '!=', 'deleted')
            ->get();
        $html = '<option value="">Select Sub Category</option>';
        foreach ($sub_categories as $sub_category) {
            $html .= '<option value="' . $sub_category->id . '">' . $sub_category->title . '</option>';
        }
        echo $html;
    }

    //function to store newly created categories
    public function store(StoreBlogRequest $request)
    {
        authorize($this->menuCode, 'CREATE');
        $validated = $request->validated();
        $data = Blog::create($validated);
        set_order_by($data->id, $this->table);
        Toastr::success('Blog Created Successfully', 'Sucess');
        return redirect()->route('blogs.index');
    }
    public function show(Blog $blog)
    {
        authorize($this->menuCode, 'SHOW');
        abort(404);
    }
    //function to show update form
    public function edit(Blog $blog)
    {
        authorize($this->menuCode, 'UPDATE');
        $id = $blog->id;
        $blog = Blog::where('status', '!=', 'deleted')->where('id', $id)->first(); //check status
        if ($blog) {
            $categories = Category::where('status', '!=', 'deleted')->where('category_type', $this->category_type)->get();
            return view('Admin.blogs.edit', compact(['categories', 'blog']) + array('menucode' => $this->menuCode));
        } else {
            return redirect()->route('blogs.index');
        }
    }
    //funtion to update the value
    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        authorize($this->menuCode, 'UPDATE');
        $validated = $request->validated();
        $blog->update($validated);
        Toastr::success('Blog Updated Sucessfully', 'Sucess');
        return redirect()->route('blogs.index');
    }
    //delete the category
    public function destroy(Blog $blog)
    {
        if (authorize($this->menuCode, 'DESTROY', false)) {
            $blog = Blog::where('id', '=', $blog->id);
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
