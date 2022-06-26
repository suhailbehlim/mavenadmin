<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Exports\UsersExport;
use DB;
use Hash;


class FuelController extends Controller
{ 
    public function index() {
        $data['active_link'] = 'fuel_types'; 
        return view('admin.fuel_types.list', $data);
    }
	
	public function addFuel() {
		$data['active_link'] = 'fuel_types'; 
		return view('admin.fuel_types.add', $data);
    }
	
	public function storeFuelType(Request $request) {
		$date = date("Y-m-d h:i:s", time());		
		$ar = [
			'type' => $request->post('type'),
			'date' => $date
		];
		DB::table('fuel_types')->insert($ar);
		return redirect()->route('admin.fuel_types')->with('success','Fuel type added successfully.');
    }
	
	public function editFuel($id) {
		$data['active_link'] = 'fuel_types';
		$data['body_type'] = DB::table('fuel_types')->where('id', $id)->first();
		return view('admin.fuel_types.edit', $data);
    }
	
	public function updateFuelType(Request $request) {
		$date = date("Y-m-d h:i:s", time());
		DB::table('fuel_types')->where('id', $request->post('id'))->update([
			'type' => trim($request->post('type'))
		]);
		return redirect()->route('admin.fuel_types')->with('success','Fuel Type updated successfully.');
    }

	public function ajaxFuelTypeList() {
        return Datatables::of(DB::table('fuel_types')->get())
        ->addColumn('action', function($data) {
        	$data->deleteMsg = 'Are you sure want to delete ?';
			$button = '<a href="'.route('admin.editFuel', [$data->id]).'" id="'.$data->id.'" class="btn btn-info btn-sm" title="Edit Type"><i class="far fa-edit"></i></a>';
        	$button .='&nbsp;&nbsp;';
        	$button .='<a href="'.route('admin.deleteFuelType', [$data->id]).'" id="'.$data->id.'" id="'.$data->id.'" class="btn btn-danger btn-sm" onclick="return confirm('."'".$data->deleteMsg."'".');" title="Delete Fuel Type" ><i class="fas fa-trash-alt"></i></a>';
			$button .='&nbsp;&nbsp;';
        	return $button;  
        })
        ->rawColumns(['action'])
        ->make(true);
	}
	
	public function deleteFuelType($id) {
		DB::table('fuel_types')->where('id', $id)->delete();
		return back()->with('success','Fuel Type deleted successfully.');
    }

}