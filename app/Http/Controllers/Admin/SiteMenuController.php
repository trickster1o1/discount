<?php

namespace App\Http\Controllers\admin;

use Toastr;
use Illuminate\Http\Request;
use App\Models\Admin\SiteMenu;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Admin\Controller;
use App\Http\Requests\Admin\StoreSiteMenuRequest;
use App\Http\Requests\Admin\UpdateSiteMenuRequest;
use App\Models\Admin\Category;
use App\Models\Admin\Sub_Category;

class SiteMenuController extends Controller
{
    private $menuCode = 'SITEMENU';
    private $table = 'site_menus';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->data['link_types'] = array(
        // 'program'=>'Program',
        // 'page'=>'Page',
        // 'service'=>'Service',
        // 'blog'=>'Blog',
        'internal_link'=>'Internal Link',
        'external_url'=>'URL'
    );
        $this->data['SiteMenu'] = 'App\Models\Admin\SiteMenu';
    }
    public function index()
    {
        //
        authorize($this->menuCode, 'INDEX');
        $site_menus = SiteMenu::where('status', '!=', 'deleted')->sortable()->paginate(50);
        return view('Admin.site_menus.index', compact(['site_menus'])+['menucode'=>$this->menuCode]);
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
        $site_menu = SiteMenu::first(); 
        return view('Admin.site_menus.create', compact('site_menu') + ['menucode'=>$this->menuCode,'link_types'=>$this->data['link_types']]);
    }

    public function getcategory_new(Request $request)
    {
        $lid = $request->lid;
        $categories = DB::table('categories')
            ->where('status', '!=', 'deleted')
            ->where('category_type', $lid)
            ->orderBy('title','asc')
            ->get();
        $html = '<option value="">Select Category</option>';
        foreach ($categories as $category) {
            $html .= '<option value="' . $category->id . '">' . $category->title . '</option>';
        }
        echo $html;
    }
    public function getopic(Request $request)
    {
        if($request->lid && !empty(trim($request->lid)) && strtolower($request->lid) != 'none' && strtolower($request->lid) != 'external_url'){
            $subcategory = $request->sid;
            $lid = $request->lid.'s';
            $topic = DB::table($lid)
                ->where('status', '!=', 'deleted');
            if($request->lid != 'internal_link'){
                $topic->where('sub_category',$subcategory);
            }
            $topics = $topic->orderBy('title','ASC')->get();
            $html = '<option value="">Select Topic</option>';
            $old_topic = ($request->old_topic)?$request->old_topic:'';
            if($topics){
                foreach ($topics as $topic) {
                    $selected = ($old_topic == $topic->id)?'selected':'';
                    $html .= '<option '.$selected.' value="' . $topic->id . '">' . $topic->title . '</option>';
                }
            }
        }else{
            $html = '<option value="">Select Topic</option>';
        }
        return ['html'=>$html];
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSiteMenuRequest $request)
    {
        //
        authorize($this->menuCode, 'CREATE');
        $validated = $request->validated();
        $data = SiteMenu::create($validated);
        $this->modified_by('create',$data);

        Toastr::success('Site Menu Created Successfully', 'Sucess');
        return redirect()->route('site_menus.index');
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
    public function edit(SiteMenu $site_menu)
    {
        //
        authorize($this->menuCode, 'UPDATE');
        return view('Admin.site_menus.edit', compact(['site_menu'])+['menucode'=>$this->menuCode,'link_types'=>$this->data['link_types']]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSiteMenuRequest $request, SiteMenu $site_menu)
    {
        //
        authorize($this->menuCode, 'UPDATE');
        $validated = $request->validated();
        $site_menu->update($validated);
        $this->modified_by('update',$site_menu);

        Toastr::success('Site Menu Updated Sucessfully', 'Sucess');
        return redirect()->route('site_menus.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SiteMenu $site_menu)
    {
        //
        authorize($this->menuCode, 'DESTROY');
        $site_menu = SiteMenu::where('id', '=', $site_menu->id);
        $site_menu->update(['status' => 'deleted']);
        Toastr::success('Site Menu Deleted', 'Sucess');
        return redirect()->route('site_menus.index');
    }
}
