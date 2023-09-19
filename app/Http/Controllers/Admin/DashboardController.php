<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use DB;

class DashboardController extends Controller
{
    //
    public function change(Request $request)
    {
        $table = $request->table;
        $id = $request->id;
        $status = $request->status;
        $returndata = '';
        if (strtolower($status) == 'active') {
            DB::table($table)->where('id', $id)->update(['status' => 'inactive']);
            $returndata = '<a href="javascript:void(0);" class="record-status text-danger" data-id="' . $id . '"
            data-table="'.$table.'" data-status="inactive">
            <i class="fa fa-times-circle fa-2x"></i></a>';
        } else {
            DB::table($table)->where('id', $id)->update(['status' => 'active']);
            $returndata = '<a href="javascript:void(0);" class="record-status text-success" data-id="' . $id . '"
            data-table="'.$table.'" data-status="active">
            <i class="fa fa-check-circle fa-2x"></i></a>';
        }
        $data = array('msg' => $returndata);
        echo json_encode($data);
    }

    public function change_is_featured(Request $request)
    {
        $table = $request->table;
        $id = $request->id;
        $status = $request->status;
        $returndata = '';
        $check_status = (strtolower($status) == 'yes')?'No':'Yes';
        if($table == 'volunteers'){
            $update = ['accepted'=>$check_status,'accepted_by'=>Auth()->user()->id,'accepted_at'=>date('Y-m-d H:i:s')];
        }else{
            $update = ['is_featured'=>$check_status];
        }

        if (strtolower($status) == 'yes') {
            DB::table($table)->where('id', $id)->update($update);
            $returndata = '<a href="javascript:void(0);" class="record-status text-danger" data-id="' . $id . '"
            data-table="'.$table.'" data-status="No">
            <i class="fa fa-times-circle fa-2x"></i></a>';
        } else {
            DB::table($table)->where('id', $id)->update($update);
            $returndata = '<a href="javascript:void(0);" class="record-status text-success" data-id="' . $id . '"
            data-table="'.$table.'" data-status="Yes">
            <i class="fa fa-check-circle fa-2x"></i></a>';
        }
        $data = array('msg' => $returndata);
        echo json_encode($data);
    }

    //get category by its type for ajax request
    public function getcategorybytype(Request  $request)
    {
        $selected_category = ($request->selected_category)?$request->selected_category:'';
        $categories = DB::table("categories")
            ->where("category_type", $request->ctslug)
            ->where('status', '!=', 'deleted')
            ->orderBy('title','ASC')
            ->get();
        $html = '<option value="">Select Category</option>';
        foreach ($categories as $category) {
            $selected = ($selected_category == $category->id)?'selected':'';
            $html .= '<option value="' . $category->id . '" '.$selected.'>' . $category->title . '</option>';
        }
      return ['html'=>$html];
    }

    public function getsubcategorybycategory(Request  $request){
        $sub_categories = DB::table("sub_categories")
            ->where("category", $request->cid)->where('status','!=','deleted')
            ->get();
            $html = '';
        if(isset($request->selectoption) && $request->selectoption == 1){
            $html .= '<option value="">Select Sub-category</option>';
        }
        $html .= '<option value="0">None</option>';
        $selected_value = $request->selected;
        foreach ($sub_categories as $sub_category) {
            $selected = ($selected_value == $sub_category->id)?'selected':'';
            $html .= '<option value="' . $sub_category->id . '" '.$selected.'>' . $sub_category->title . '</option>';
        }
        return ['html'=>$html];
    }

    public function update_order(Request $request){
        $id = $request->id;
        $table = $request->datatable;
        $order_number = $request->order_number;
        $update = DB::table($table)->where('id',$id)->update(['order_by'=>$order_number]);
        $data['type'] = 'success';
        $data['message'] = 'Sequence changed successfully!!!';
        return $data;
    }
}
