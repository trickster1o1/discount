<?php

namespace App\Http\Controllers\admin;

use Toastr;
use Illuminate\Http\Request;
use App\Models\Admin\SiteSetting;
use App\Http\Controllers\Admin\Controller;
use App\Http\Requests\Admin\StoreSiteSettingRequest;
use App\Http\Requests\Admin\UpdateSiteSettingRequest;

class SiteSettingController extends Controller
{
    private $menuCode = 'SITESETTING';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(authorize($this->menuCode, 'CREATE',false) || authorize($this->menuCode, 'UPDATE',false)){
            $site_setting = SiteSetting::first();
            if ($site_setting) {
                return view('Admin.sitesettings.index', compact('site_setting')+['menucode'=>$this->menuCode]);
            } else {
                return redirect('admin/site_settings/create');
            }
        }else{
            abort_if(true, 403); 
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if(authorize($this->menuCode, 'CREATE',false) || authorize($this->menuCode, 'UPDATE',false)){
            $site_setting = SiteSetting::first();
            if ($site_setting) {
                return redirect('admin/site_settings');
            }
            return view('Admin.sitesettings.create',['menucode'=>$this->menuCode]);
        }else{
            abort_if(true, 403); 
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSiteSettingRequest $request)
    {
        //
        $validated = $request->validated();
        SiteSetting::TRUNCATE();
        $data = SiteSetting::create($validated);
        $this->modified_by('create',$data);

        Toastr::success('Site Settings Created', 'Sucess');
        return redirect('admin/site_settings');
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
    public function update(UpdateSiteSettingRequest $request, SiteSetting $site_setting)
    {
        //
        authorize($this->menuCode, 'UPDATE');
        $validated = $request->validated();
        $site_setting->update($validated);
        $this->modified_by('update',$site_setting);

        Toastr::success('Site Settings Updated', 'Sucess');
        return redirect('admin/site_settings');
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
