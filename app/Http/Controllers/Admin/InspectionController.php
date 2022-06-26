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
use App\Models\Usedcars;
use App\Models\Usedcarsimages;
use App\Models\Usedcardimweights;
use App\Models\Usedcarsenginetrans;
use App\Models\Usedcarsfuels;
use App\Models\Usedcarsbonus;
use App\Models\Usedcarsstatistic;
use App\Exports\UsersExport;
use DB;
use Hash;

class InspectionController extends Controller{ 
    public function index($eid) {
        $data['active_link'] = 'inspection';
		$data['eid'] = $eid;
		$data['inspectionname'] = DB::table('inspection_names')->where('id', $eid)->select('inspection')->first();
        return view('admin.inspection.list', $data);
    }
	
	public function addInspection($eid) {
		$data['active_link'] = 'inspection'; 
		$data['eid'] = $eid;
		$data['inspectionname'] = DB::table('inspection_names')->where('id', $eid)->select('inspection')->first();
		return view('admin.inspection.add', $data);
    }
	
	public function storeInspection(Request $request) {
		$name = $request->post('name');
		$inspection_id = $request->post('iid');
		$ar = [
			'name' => $name,
			'inspection_id' => $inspection_id,
		];
		DB::table('inspection_options')->insert($ar);
		return redirect()->route('admin.inspection', ['eid' => $inspection_id])->with('success','inspection added successfully.');
    }
	
	public function ajaxInspection($eid) {
        return Datatables::of(DB::table('inspection_options')->where('inspection_id',$eid)->get())
        ->addColumn('action', function($data) {
        	$data->deleteMsg = 'Are you sure want to delete ?';
        	$button = '<a href="'.route('admin.editInspection', [$data->id]).'" id="'.$data->id.'" class="btn btn-info btn-sm" title="Edit inspection"><i class="far fa-edit"></i></a>';
        	$button .='&nbsp;&nbsp;';
        	$button .='<a href="'.route('admin.deleteInspection', [$data->id]).'" id="'.$data->id.'" id="'.$data->id.'" class="btn btn-danger btn-sm" onclick="return confirm('."'".$data->deleteMsg."'".');" title="Delete inspection" ><i class="fas fa-trash-alt"></i></a>';
			$button .='&nbsp;&nbsp;';

        	return $button;  
        })
        ->rawColumns(['action'])
        ->make(true);
	}
	
	public function deleteInspection($id) {
		DB::table('inspection_options')->where('id', $id)->delete();
		return back()->with('success','inspection deleted successfully.');
    }
	
	public function editInspection($id) {
      $data['active_link'] = 'inspection';
      $data['inspection'] = DB::table('inspection_options')->where('id', $id)->first();
	  $data['eid'] = $data['inspection']->inspection_id;
	  $data['inspectionname'] = DB::table('inspection_names')->where('id', $data['eid'])->select('inspection')->first();
      return view('admin.inspection.edit', $data);
    }
	
	public function updateInspection(Request $request, $id) {
		$name = $request->post('name');
		$eid = $request->post('iid');
		$ar = [
			'name' => $name
		];
		DB::table('inspection_options')->where('id', $id)->update($ar);
		return redirect()->route('admin.inspection', ['eid' => $eid])->with('success','inspection updated successfully.');
    }
	
    public function exportExcel($type) {
        return \Excel::download(new UsersExport, 'users.'.$type);
    }
}