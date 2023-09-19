<?php

namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\Controller;

use App\Models\Admin\SmtpSetting;
use Illuminate\Http\Request;

class SmtpController extends Controller
{
    private $menuCode = 'SMTPSETTING';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(authorize($this->menuCode, 'CREATE',false) || authorize($this->menuCode, 'UPDATE',false)){ 
            if (SmtpSetting::first()) {
                return redirect()->route('smtp.edit',SmtpSetting::first()->id);
            }
            return view('Admin.smtp.create',['menucode'=>$this->menuCode]);
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
            if (SmtpSetting::first()) {
                return redirect()->route('smtp.edit',SmtpSetting::first()->id);
            }
            return view('Admin.smtp.create',['menucode'=>$this->menuCode]);
        }else{
            abort_if(true,'403');
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
        $data = SmtpSetting::create($request->input());
        $this->modified_by('create',$data);

        return redirect()->route('smtp.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_if(true,'403');
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
        if(authorize($this->menuCode, 'CREATE',false) || authorize($this->menuCode, 'UPDATE',false)){
            if (SmtpSetting::first()) {
                return view('Admin.smtp.create', ['smtp'=>SmtpSetting::first(),'menucode'=>$this->menuCode]);
            }
            return redirect()->view('Admin.smtp.create',['menucode'=>$this->menuCode]);
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
        $data = SmtpSetting::first();
        $data->update($request->input());
        $this->modified_by('update',$data);        
        return redirect()->route('smtp.index');
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
