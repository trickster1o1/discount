<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    
    private $menuCode = 'ORDER';
    private $table      = 'orders';
    function order_data(Request $request)
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
        $iTotalRecords    = Order::getTotal($filter);
        $iDisplayLength = isset($request->length) ? intval($request->length) : 100;
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart =  isset($request->start) ? intval($request->start) : 0;
        $sEcho = intval($request->draw);

        $end = $iDisplayStart + $iDisplayLength;
        $end = $end > $iTotalRecords ? $iTotalRecords : $end;

        $pagination['limit'] = $iDisplayLength;
        $pagination['offset'] = $iDisplayStart;

        $orders =  Order::getData($sort, $pagination, $filter);

        if ($orders != null) {
            foreach ($orders as $key => $order) :
                $action = '';
                $records["data"][$key][] = $order->user_name;
                $records["data"][$key][] = $order->oid;
                $records["data"][$key][] = $order->getMethod($order->payment_method);
                $records["data"][$key][] = 'Rs. ' . $order->amount;
                $records["data"][$key][] = $order->ref_id;

                $status = ($order->status == 'active') ? '<i class="fa fa-check-circle fa-2x text-success" title="active"></i>' : '<i class="fa fa-times-circle fa-2x text-danger" title="inactive"></i>';
                //Status
                
                    $records["data"][$key][] = '<a href="javascript:void(0);">' . $status . '</a>';

            endforeach;
        }
        $records["draw"]            = $sEcho;
        $records["recordsTotal"]    = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        echo json_encode($records);
        exit;
    }

    public function index()
    {
        //
        authorize($this->menuCode, 'INDEX');
        return view('Admin.orders.index', ['menucode' => $this->menuCode]);
    }

    public function destroy($id)
    {
        //
        if (authorize($this->menuCode, 'DESTROY', false)) {
            $blog = Order::where('id', '=', $id);
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
