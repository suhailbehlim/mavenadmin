<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;


use App\Models\User;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Roles;


use App\Exports\UsersExport;
use DB;
use Hash;


class PostsController extends Controller
{ 
    public function index() {
        $data['active_link'] = 'posts_request'; 
        return view('admin.posts_request.list', $data);
    }
	
	public function posts_pending() {
        $data['active_link'] = 'posts_pending'; 
        return view('admin.posts_request.list-pending', $data);
    }

	public function ajaxRequestList() {
        return Datatables::of(DB::table('posts_request')->join('users', 'posts_request.user_id', '=', 'users.id')->join('cars_meta', 'posts_request.car_id', '=', 'cars_meta.car_id')->select('posts_request.id','posts_request.car_id','posts_request.car_type','posts_request.user_id','posts_request.post_type','posts_request.requested_price','posts_request.status','posts_request.submit_date','posts_request.created_at','users.first_name','users.last_name','cars_meta.price')->where('posts_request.status','success')->get())
        ->addColumn('action', function($data) {
        	$button ='<a href="'.route('admin.viewRequest', [$data->id]).'" id="'.$data->id.'" class="btn btn-success btn-sm" title="View" ><i class="fas fa-eye"></i></a>';
        	return $button;  
        })
		->addColumn('userName', function($row){
			  return $row->first_name.' '.$row->last_name;
		})
		->addColumn('price', function($row){
			if($row->post_type=='promotion'){
				return $row->price;
			}
		})
        ->rawColumns(['action'])
        ->make(true);
	}
	
	public function ajaxPendingRequestList() {
        return Datatables::of(DB::table('posts_request')->join('users', 'posts_request.user_id', '=', 'users.id')->join('cars_meta', 'posts_request.car_id', '=', 'cars_meta.car_id')->select('posts_request.id','posts_request.car_id','posts_request.car_type','posts_request.user_id','posts_request.post_type','posts_request.requested_price','posts_request.status','posts_request.submit_date','posts_request.created_at','users.first_name','users.last_name','cars_meta.price')->where('posts_request.status','pending')->get())
        ->addColumn('action', function($data) {
        	$button ='<a href="'.route('admin.viewRequest', [$data->id]).'" id="'.$data->id.'" class="btn btn-success btn-sm" title="View" ><i class="fas fa-eye"></i></a>';
        	return $button;  
        })
		->addColumn('userName', function($row){
			  return $row->first_name.' '.$row->last_name;
		})
		->addColumn('price', function($row){
			if($row->post_type=='promotion'){
				return $row->price;
			}
		})
        ->rawColumns(['action'])
        ->make(true);
	}

	public function viewRequest($id) {
		$data['active_link'] = 'posts_request';
		$data['detail'] = DB::table('posts_request')->where('id', $id)->first();
		return view('admin.posts_request.show', $data);
    }

	public function updateStatus(Request $request, $id) {
		$date = date("Y-m-d h:i:s", time());		
		$ar = [
			'status' => trim($request->post('status'))
		];
		DB::table('posts_request')->where('id', $id)->update($ar);
		return redirect()->route('admin.viewRequest', ['id' => $id])->with('success','Status Updated successfully.');
    }
	
    public function exportExcel($type) {
        return \Excel::download(new UsersExport, 'users.'.$type);
    }

}