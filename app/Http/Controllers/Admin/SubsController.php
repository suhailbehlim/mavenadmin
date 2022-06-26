<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscriber;

use Yajra\Datatables\Datatables;
use DB;


class SubsController extends Controller
{



	public function subsindex() {

        $data['active_link'] = 'subscriber';
        return view('admin.contact.subslist', $data);
    }
    
  
	public function ajaxsubsList() {

    return Datatables::of( DB::table('subscribers')->orderBy('id', 'DESC')->get())
    ->addColumn('action', function($data) {
     
      
    })->rawColumns(['action'])
    ->make(true);
    
  }
  
  public function addsubscribers() {
		
        $data['active_link'] = 'subscriber';
        return view('admin.contact.addsubs', $data);
    }
    public function sendsubsdata(Request $req)
	{
		$name = $req->name;
		$email = $req->email;
		$subsdata = ['name'=>$name,'email'=>$email];
		$send = DB::table('subscribers')->insert($subsdata);
	/*	   if($send>0)
	   {
		    $data['active_link'] = 'subscriber';
		   return view('admin.contact.subslist' , $data);
	   }
	   else{
		   echo mysqli_error();
	   }
	   
    $addquestion =DB::table('faq')->insert($data);
  */
    return redirect()->route('admin.subsindex')->with('success','Subscriber Added successfully.'); 
	
	}

}