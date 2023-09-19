<?php

namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\Controller;

use App\Models\Admin\IntroductionSetting;
use App\Models\Admin\Page;
use Illuminate\Http\Request;

class IntroductionController extends Controller
{
    private $menuCode = 'INTRODUCTION';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(authorize($this->menuCode, 'CREATE',false) || authorize($this->menuCode, 'UPDATE',false)){
            if(IntroductionSetting::first()) {
                return redirect()->route('introductionsetting.edit',IntroductionSetting::first()->id);
            }

            return redirect()->route('introductionsetting.create');
        }else{
            abort_if(true,403);
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
            if(IntroductionSetting::first()) {
                return redirect()->route('introductionsetting.edit', IntroductionSetting::first()->id);
            }
            $page = Page::where('status','active')->get(['id','title as name']);
            return view('Admin.introduction.create', compact('page')+['menucode'=>$this->menuCode]);
        }else{
            abort_if(true,403);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        
        $request->validate([
            'title'=>'required',
            'description'=>'required'
        ]);
        $data = IntroductionSetting::create($request->input());
        $this->modified_by('create',$data);
        
        return redirect()->route('introductionsetting.index');
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
        if(authorize($this->menuCode, 'CREATE',false) || authorize($this->menuCode, 'UPDATE',false)){
            $page = Page::where('status','active')->get(['id','title as name']);
            $introduction = IntroductionSetting::first();
            if($introduction) {
                return view('Admin.introduction.edit', compact('page','introduction')+['menucode'=>$this->menuCode]);        
            }
            return view('Admin.introduction.create', compact('page')+['menucode'=>$this->menuCode]);
        }else{
            abort_if(true,403);
        }
 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'title'=>'required',
            'description'=>'required'
        ]);
        $introduction = IntroductionSetting::first();
        $introduction->update($request->input());
        $introduction->update([
            'supporter'=>$request->supporter ? 'on' : null, 
            'testimonials'=>$request->testimonials ? 'on' : null, 
            'volunteer'=>$request->volunteer ? 'on' : null 
        ]);
        $this->modified_by('update',$introduction);

        
        return redirect()->route('introductionsetting.index');
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
