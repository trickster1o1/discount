<?php

namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\Controller;

use App\Models\Admin\PaymentSettings;
use Illuminate\Http\Request;
use \Toastr;
class PaymentSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $menuCode = 'PAYMENTSETTING';
    public function index()
    {
        if(authorize($this->menuCode, 'CREATE',false) || authorize($this->menuCode, 'UPDATE',false)){  
            if(PaymentSettings::first()) {
                return redirect()->route('paymentsetting.edit',PaymentSettings::first()->id);
            }
            return redirect()->route('paymentsetting.create');
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
            if(PaymentSettings::first()) {
                return redirect()->route('paymentsetting.edit',PaymentSettings::first()->id);
            }
            return view('Admin.payment_setting.create'+['menucode'=>$this->menuCode]);
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
            'merchant_id'=>'nullable',
            'esewa_id'=>'nullable',
            'paypal_form'=>'nullable',
        ]);

        $data = PaymentSettings::create($request->input());
        $this->modified_by('create',$data);
        Toastr::success('Settings Created Sucessfully', 'Sucess');

        return redirect()->route('paymentsetting.index');
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
        //
        
        $payment = PaymentSettings::first();
        if($payment) {
            return view('Admin.payment_setting.edit',compact('payment')+['menucode'=>$this->menuCode]);
        }
        return view('Admin.payment_setting.create',['menucode'=>$this->menuCode]);
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
        if(authorize($this->menuCode, 'CREATE',false) || authorize($this->menuCode, 'UPDATE',false)){  
            $request->validate([
                'merchant_id'=>'nullable',
                'esewa_id'=>'nullable',
                'paypal_form'=>'nullable',
            ]);

         $data =   PaymentSettings::first();
         $data->update($request->input());
            $this->modified_by('update',$data);

            Toastr::success('Settings Updated Sucessfully', 'Sucess');

            return redirect()->route('paymentsetting.index');
        }else{
            abort_if(true,403);
        }

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
