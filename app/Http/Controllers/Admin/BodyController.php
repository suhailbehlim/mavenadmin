<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Exports\UsersExport;
use DB;
use Hash;


class BodyController extends Controller
{ 
    public function index() {
        $data['active_link'] = 'body_type'; 
        return view('admin.body_type.list', $data);
    }
	
	public function addBody() {
		$data['active_link'] = 'body_type'; 
		return view('admin.body_type.add', $data);
    }
	
	public function storeBody(Request $request) {
		$date = date("Y-m-d h:i:s", time());		
		$ar = [
			'id' => $request->post('id'),
			'body_type' => $request->post('body_type'),
			'model_id' => $request->post('model_id'),
			'created_at' => $date
		];
		DB::table('body_type')->insert($ar);
		return redirect()->route('admin.body_list')->with('success','Body type added successfully.');
    }
	
	public function editBody($id) {
		$data['active_link'] = 'body_type';
		$data['body_type'] = DB::table('body_type')->where('id', $id)->first();
		return view('admin.body_type.edit', $data);
    }
	
	public function updateBody(Request $request) {
		$date = date("Y-m-d h:i:s", time());
		DB::table('body_type')->where('id', $request->post('id'))->update([
			'body_type' => trim($request->post('body_type')),
			'model_id' => $request->post('model_id')
		]);
		return redirect()->route('admin.body_list')->with('success','Body Type updated successfully.');
    }

	public function ajaxBodyTypeList() {
        return Datatables::of(DB::table('body_type')->get())
        ->addColumn('action', function($data) {
        	$data->deleteMsg = 'Are you sure want to delete ?';
			$button = '<a href="'.route('admin.editBody', [$data->id]).'" id="'.$data->id.'" class="btn btn-info btn-sm" title="Edit Type"><i class="far fa-edit"></i></a>';
        	$button .='&nbsp;&nbsp;';
        	$button .='<a href="'.route('admin.deleteType', [$data->id]).'" id="'.$data->id.'" id="'.$data->id.'" class="btn btn-danger btn-sm" onclick="return confirm('."'".$data->deleteMsg."'".');" title="Delete Body" ><i class="fas fa-trash-alt"></i></a>';
			$button .='&nbsp;&nbsp;';
        	return $button;  
        })
        ->rawColumns(['action'])
        ->make(true);
	}
	
	public function deleteType($id) {
		DB::table('body_type')->where('id', $id)->delete();
		return back()->with('success','Body Type deleted successfully.');
    }

}