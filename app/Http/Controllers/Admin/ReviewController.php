<?php

namespace App\Http\Controllers\Admin;

use Toastr;
use Illuminate\Http\Request;
use App\Models\Admin\Review;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Admin\Controller;
use App\Http\Requests\Admin\StoreReviewRequest;
use App\Http\Requests\Admin\UpdateReviewRequest;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    private $menuCode = 'REVIEW';
    private $table = 'reviews';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        authorize($this->menuCode, 'INDEX');
        return view('Admin.review.index', ['menucode' => $this->menuCode]);
    }

    function review_data(Request $request)
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
        $iTotalRecords    = Review::getTotal($filter);
        $iDisplayLength = isset($request->length) ? intval($request->length) : 100;
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart =  isset($request->start) ? intval($request->start) : 0;
        $sEcho = intval($request->draw);

        $end = $iDisplayStart + $iDisplayLength;
        $end = $end > $iTotalRecords ? $iTotalRecords : $end;

        $pagination['limit'] = $iDisplayLength;
        $pagination['offset'] = $iDisplayStart;

        $reviews =  Review::getData($sort, $pagination, $filter);

        if ($reviews != null) {
            foreach ($reviews as $key => $review) :
                $action = '';
                $records["data"][$key][] = $review->user_name;
                $records["data"][$key][] = $review->review;
                $records["data"][$key][] = $review->rating;


                $status = ($review->status == 'active') ? '<i class="fa fa-check-circle fa-2x text-success"></i>' : '<i class="fa fa-times-circle fa-2x text-danger"></i>';

                if (authorize($this->menuCode, 'UPDATE', false)) {
                    $records["data"][$key][] = '<a href="javascript:void(0);" class="record-status" data-id="' . $review->id . '"
                                            data-table="' . $this->table . '" data-status="' . $review->status . '">' . $status . '</a>';
                } else {
                    $records["data"][$key][] = '<a href="javascript:void(0);">' . $status . '</a>';
                }
                if (authorize($this->menuCode, 'DESTROY', false)) {
                    $action .= '<form class="d-inline swal-delete"
                                action="' . route('review.destroy', $review) . '" method="POST">
                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger btn-sm btn-submit" title="Delete"><i
                                        class="mdi mdi-delete"></i></button>
                            </form>';
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
        return ['msg' => 'working'];
        //
        // authorize($this->menuCode, 'CREATE');
        // return view('Admin.reviews.create');
    }

    // public function getreviewfor(Request $request)
    // {
    //     $table = $request->review_category;
    //     $reviews_for = DB::table($table)
    //         ->where('status', '!=', 'deleted')
    //         ->get();
    //     $html = '<option value="">Select Review For</option>';
    //     foreach ($reviews_for as $review_for) {
    //         $html .= '<option value="' . $review_for->id . '">' . $review_for->id . '</option>';
    //     }
    //     echo $html;
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        try {

            $validator = Validator::make($request->all(), [
                'rating' => 'nullable',
                'review' => 'required',
            ]);
            if ($validator->fails()) {
                return ['msg' => 'error', 'errors' => $validator->errors()->messages()];
            }

            Review::create($request->input());
            return ['msg' => 'success'];
        } catch (\Throwable $th) {
            return ['msg' => 'error', 'errors' => $th];
        }
        // authorize($this->menuCode, 'CREATE');
        // $validated = $request->validated();
        // Review::create($validated);
        // Toastr::success('Review Created Successfully', 'Sucess');
        // return redirect()->route('reviews.index');
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
    public function edit(Review $review)
    {
        //
        // authorize($this->menuCode, 'UPDATE');
        // return view('Admin.reviews.edit', compact(['review']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReviewRequest $request, Review $review)
    {
        //
        // authorize($this->menuCode, 'UPDATE');
        // $validated = $request->validated();
        // $review->update($validated);
        // Toastr::success('Review Updated Sucessfully', 'Sucess');
        // return redirect()->route('reviews.index');
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
            $blog = Review::where('id', '=', $id);
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
