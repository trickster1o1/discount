<?php

namespace App\Http\Controllers\Admin;

use Toastr;
use App\Models\Admin\Album;
use App\Models\Admin\Gallary;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\StoreAlbumRequest;
use App\Http\Requests\Admin\UpdateAlbumRequest;

class AlbumController extends Controller
{
    //
    private $menuCode = 'ALBUM';
    
    public $model = 'App\Models\Admin\Album';
    private $table    = 'albums';

    //index for albums
    function index()
    {
        authorize($this->menuCode, 'INDEX');
        $albums = Album::select('albums.*', \DB::raw("(SELECT count(*) from galleries where album_id = albums.id ) as total_image"))
            ->where('status', '!=', 'deleted')->sortable(['id' => 'desc'])->paginate(50);
        return view('Admin.albums.index', compact('albums') + array('menucode' => $this->menuCode));
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
               $records["data"][$key][] = $category->slug;
               $records["data"][$key][] = count($category->gallary);
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
                       $action .= '<a href="' . route('albums.edit', $category) . '"
                                   class="btn btn-primary btn-sm" title="Edit">
                                   <i class="mdi mdi-square-edit-outline"></i>
                               </a>';
                   }
                   if (authorize($this->menuCode, 'DESTROY', false)) {
                       $action .= '<form class="d-inline swal-delete"
                                   action="' . route('albums.destroy', $category) . '" method="POST">
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

    //function to open create album

    public function create()
    {
        authorize($this->menuCode, 'CREATE');
        $data['post_image_url']     = old('image_url');
        $data['post_image_title']   = old('image_title');
        $data['post_description']   = old('description');
        $data['post_video_url']     = old('video_url');
        $data['post_order_by']      = old('order_by');
        $data['menucode']           = $this->menuCode;
        return view('Admin.albums.create', $data);
    }

    //function to store the data
    public function store(StoreAlbumRequest $request)
    {
        authorize($this->menuCode, 'CREATE');
        $validated = $request->validated();
        // dd($validated);
        $album = Album::create($validated);
        set_order_by($album->id, $this->table);
        $this->modified_by('create',$album);

        $this->create_image_gallary($request, $album->id);
        Toastr::success('Album Created Successfully', 'Sucess');
        return redirect()->route('albums.index');
    }

    private function create_image_gallary($request = null, $album_id = 0)
    {
        Gallary::where('album_id', $album_id)->delete();
        foreach ($request->image_url as $k => $value) {
            if (strlen(trim($value))) {
                $order_by = (strlen(trim($request->order_by[$k])) > 0) ? $request->order_by[$k] : $k;
                $gallary = array([
                    'image_url'     => $request->image_url[$k],
                    'title'         => $request->image_title[$k],
                    'album_id'      => $album_id,
                    'description'   => $request->description[$k],
                    'video_url'   => $request->video_url[$k],
                    'order_by'      => $order_by,
                ]);
                Gallary::insert($gallary);
            }
        }
    }

    //function to show update form
    public function edit(Album $album)
    {
        authorize($this->menuCode, 'UPDATE');
        $id = $album->id;
        $album = Album::where('id', $id)->where('status', '!=', 'deleted')->first();
        if ($album) {
            $data['post_image_url']     = old('image_url');
            $data['post_image_title']   = old('image_title');
            $data['post_description']   = old('description');
            $data['post_video_url']     = old('video_url');
            $data['post_order_by']      = old('order_by');
            $gallaries          = Gallary::where('album_id', '=', $album->id)->orderBy('order_by', 'asc')->get();
            $data['album']      = $album;
            $data['gallaries']  = $gallaries;
            $data['menucode']   = $this->menuCode;
            return view('Admin.albums.edit', $data);
        } else {
            return redirect()->route('albums.index');
        }
    }
    public function update(UpdateAlbumRequest $request, Album $album)
    {
        authorize($this->menuCode, 'UPDATE');
        $validated = $request->validated();
        $album->update($validated);
        $this->create_image_gallary($request, $album->id);
        $this->modified_by('update',$album);

        $url = $request->redirects_to;
        Toastr::success('Album Updated Sucessfully', 'Sucess');
        return redirect($url);
    }
    //delete the album
    public function destroy(Album $album)
    {
        if (authorize($this->menuCode, 'DESTROY', false)) {
            // $donner = $this->model::where('id', '=', $donner->id);
            $album->update(['status' => 'deleted']);
            $data['type']       = 'success';
            $data['message']    = 'Record Deleted Sucessfully!!!';
        } else {
            $data['type']       = 'error';
            $data['message']    = 'Invalid Request!';
        }
        return $data;
    }
}
