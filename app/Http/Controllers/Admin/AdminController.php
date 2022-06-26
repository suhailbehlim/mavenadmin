<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;


use App\Models\order;
use App\Models\transition;
use App\Models\User;


use App\Exports\UsersExport;

use Hash;
use DB;
class AdminController extends Controller
{


    public function view($id, $type)
    {
        if ($type == "order") {
            $info = transition::where('id',$id)
                ->with('order','package')->first();

//dd($info);
            return view('admin.custom.order.orderInfo', ['item' => $info]);
        }

    }

    public function getList($type)
    {
        if ($type == "order") {
            $info = [];
            $info = \App\Models\transition::all();
            return view('admin.order.list', ['info' => $info]);
        } 

    }

  
    


    
}
