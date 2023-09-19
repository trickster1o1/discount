<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function modified_by($status, $data) {
        if($status == 'create') {
            $data->update([
                'created_by'=>Auth()->user()->id
            ]);
        } else if($status == 'update') {
            $data->update([
                'updated_by'=>Auth()->user()->id
            ]);
        }
    }
}
