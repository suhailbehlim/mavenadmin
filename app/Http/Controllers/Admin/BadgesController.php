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

use App\Exports\UsersExport;
use DB;
use Hash;

class BadgesController extends Controller{ 
    public function index() {
        $data['active_link'] = 'badges'; 
        return view('admin.badges.list', $data);
    }
	
	public function ajaxBadgesList() {
		//print_r(DB::table('badges')->join('users', 'badges.user_id', '=', 'users.id')->join('cars', 'badges.car_id', '=', 'cars.id')->select('badges.id','badges.user_id','badges.car_id','users.first_name','users.last_name','badges.created_at')->get());
        return Datatables::of(DB::table('badges')->join('users', 'badges.user_id', '=', 'users.id')->join('cars', 'badges.car_id', '=', 'cars.id')->select('badges.id','badges.user_id','badges.car_id','users.first_name','users.last_name','badges.created_at','cars.registration_number')->get())
        ->addColumn('action', function($data) {
        	$data->deleteMsg = 'Are you sure want to delete ?';
        	$button = '<a href="'.route('admin.editBadge', [$data->id]).'" id="'.$data->id.'" class="btn btn-info btn-sm" title="Edit Banner"><i class="far fa-edit"></i></a>';
        	return $button;  
        })
		->addColumn('userName', function($row){
			  return $row->first_name.' '.$row->last_name;
		})
        ->rawColumns(['action'])
        ->make(true);
	}
	
	public function editBadge($id) {
		$var = DB::table('badges')->where('id', $id)->first();
		$userid = $var->user_id;
		$car_id = $var->car_id;
		$users = DB::table('users')->where('id', $userid)->select('first_name','last_name')->first();
		$cars = DB::table('cars')->where('id', $car_id)->select('registration_number')->first();
		$data['active_link'] = 'badges';
		$data['user'] = $users;
		$data['car'] = $cars;
		$data['badges'] = DB::table('badges')->where('id', $id)->first();
		$data['badge_request'] = DB::table('badge_request')->where('badge_id', $id)->get();
		$data['degreePhoto'] = DB::table('badge_request')->where('request_for', '360photo')->where('badge_id', $id)->first();
		$data['inspectionDt'] = DB::table('badge_request')->where('request_for', 'inspection')->where('badge_id', $id)->first();
		$data['badge_360'] = DB::table('badge_360')->where('badge_id', $id)->first();
		$data['inspection_report'] = DB::table('badge_inspection_report')->where('badge_id', $id)->get();
		
		$varname = DB::table('inspection_names')->get();
		$dataArray = [];
		if($varname){
			$i=0;
			foreach($varname as $fkey){
				$keyid = $fkey->id;
				$child = DB::table('inspection_options')->where('inspection_id',$keyid)->get();
				$parray = [];
				if($child){
					$p=0;
					foreach($child as $opr){
						$report = DB::table('badge_inspection_report')->where('badge_id',$id)->where('request_id',$id)->where('inspection_option_id',$opr->id)->first();
						if($report){
							$rtd = $report->value;
						}else{
							$rtd = '';
						}
						$parray[$p]['id']=$opr->id;
						$parray[$p]['name']=$opr->name;
						$parray[$p]['report']=$rtd;
						++$p;
					}
				}
				$dataArray[$i]['inspection_id'] = $keyid;
				$dataArray[$i]['inspection_name'] = $fkey->inspection;
				$dataArray[$i]['inspection_options'] = $parray;
				++$i;
			}
		}
		
		$data['inspection_options'] = $dataArray;
		return view('admin.badges.edit', $data);
    }
	
	public function update360Request(Request $request, $id) {
		$date = date("Y-m-d h:i:s", time());
		$resid = $request->post('resid');
		$title = $request->post('title');
		$meta = $request->post('meta');
		$status = $request->post('status');
		$panel = $request->file('panel');
		if(isset($resid)){
			$select = DB::table('badge_360')->where('id', $resid)->first();
			$desktopfn = '';
			if($panel){
				$extension = $panel->getClientOriginalExtension();
				$desktopfn = time().'.'.$extension;
				$icon_type='img';
				$panel->move('public/uploads/360photography/', $desktopfn);
			}else{
				$desktopfn = $select->panel;
			}
		}else{
			$desktopfn = '';
			if($panel){
				$extension = $panel->getClientOriginalExtension();
				$desktopfn = time().'.'.$extension;
				$icon_type='img';
				$panel->move('public/uploads/360photography/', $desktopfn);
			}
		}
		
		$ar = [
			'badge_id' => $id,
			'request_id' => $id,
			'title' => $title,
			'meta' => $meta,
			'panel' => $desktopfn,
			'status' => $status,
			'uploaded_time' => $date
		];
		if(isset($resid)){
			DB::table('badge_360')->where('id',$resid)->update($ar);
		}else{
			DB::table('badge_360')->insert($ar);
		}
		DB::table('badge_request')->where('request_for', '360photo')->where('badge_id', $id)->update(['status'=>'success']);
		return redirect()->route('admin.editBadge', ['id' => $id])->with('success','360 photography updated successfully.');
    }
	
	public function updateInspectionRequest(Request $request, $id) {
		$date = date("Y-m-d h:i:s", time());	
		$all = $request->all();
		$resid = $request->post('resid');
		$varname = DB::table('inspection_names')->get();
		$dataArray = [];
		if($varname){
			$i=0;
			foreach($varname as $fkey){
				$keyid = $fkey->id;
				$child = DB::table('inspection_options')->where('inspection_id',$keyid)->get();
				$parray = [];
				if($child){
					$p=0;
					foreach($child as $opr){
						$oprid = $opr->id;
						$postinner = $request->post($oprid.'_'.$oprid);
						$exploadx = explode('_',$postinner);
						$optionid = $exploadx[0];
						$optionvalues = isset($exploadx[1]) ? $exploadx[1] : 'false';
						$ar = [
							'badge_id' => $id,
							'request_id' => $id,
							'inspection_option_id' => isset($optionid) ? $optionid : $oprid,
							'value' => isset($optionvalues) ? $optionvalues : 'false',
							'date' => $date
						];
						if(isset($resid)){
							$ar2 = [
								'value' => isset($optionvalues) ? $optionvalues : 'false',
								'date' => $date
							];
							DB::table('badge_inspection_report')->where('inspection_option_id',$optionid)->update($ar2);
						}else{
							DB::table('badge_inspection_report')->insert($ar);
						}
					}
				}
			}
		}
		DB::table('badge_request')->where('request_for', 'inspection')->where('badge_id', $id)->update(['status'=>'success']);
		return redirect()->route('admin.editBadge', ['id' => $id])->with('success','Inspection updated successfully.');
    }
	
    public function exportExcel($type) {
        return \Excel::download(new UsersExport, 'users.'.$type);
    }
}
