<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Enquiry;
use App\Models\Subscriber;



use Yajra\Datatables\Datatables;


use DB;
class EnquiryController extends Controller
{

    public function enquiryindex() {

        $data['active_link'] = 'contactus';
        return view('admin.contact.list', $data);
    }
    
  
	public function ajaxenquiryList() {

    return Datatables::of( DB::table('enquiry')->orderBy('id', 'DESC')->get())
    ->addColumn('action', function($data) {
     
      
    })->rawColumns(['action'])
    ->make(true);
    
  }

	

}