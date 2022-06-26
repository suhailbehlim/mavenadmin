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
use App\Models\Category;
use App\Models\CarModel;
use App\Models\Company;
use DB;
use Hash;

class CarsController extends Controller{ 
    public function index() {
        $data['active_link'] = 'used_cars'; 
        return view('admin.used_cars.list', $data);
    }
	
	public function addUsedCar() {
		$data['active_link'] = 'used_cars'; 
		$data['dealers'] = User::where('user_type', 'Dealer')->orderBy('id', 'DESC')->get();
		return view('admin.used_cars.add', $data);
    }
	
	public function addCar(Request $request) {
		$dealer = $request->dealername;
		return redirect()->route('admin.addUsedCarWithDealer', ['id' => $dealer]);
    }
	
	public function addUsedCarWithDealer($id) {
		$data['active_link'] = 'used_cars'; 
		$data['dealerid'] = $id;
		$data['make'] = Company::get();
		$data['vehicle_type'] = DB::table('vehicle_types')->get();
		return view('admin.used_cars.addWithDealer', $data);
    }
	
	public function storeUsedCarStep1(Request $request, $id) {
		$date = date("Y-m-d h:i:s", time());		
		$ar = [
			'car_type' => 'used_car',
			'vehicle_type' => $request->post('vehicle_type'),
			'make' => $request->post('make'),
			'model' => $request->post('model'),
			'year' => $request->post('year'),
			'registration_number' => trim($request->post('registration_number')),
			'current_mileage' => trim($request->post('current_mileage')),
			'user_id' => $id,
			'user_type' => 'Dealer',
			'sold_notification' => 'no',
			'status' => trim($request->post('status')),
			'created_at' => $date,
			'updated_at' => $date
		];
		DB::table('cars')->insert($ar);
		$lastid = DB::getPdo()->lastInsertId();
		return redirect()->route('admin.addUsedCarWithDealerStep2', ['id' => $lastid])->with('success','Step 1 added successfully.');
    }
	 
	public function addUsedCarWithDealerStep2($id) {
		$data['active_link'] = 'used_cars'; 
		$data['car_id'] = $id;
		$data['car_models'] = DB::table('car_models')->get();
		$data['transmission'] = DB::table('transmission')->get();
		$data['body_type'] = DB::table('body_type')->get();
		$data['fuel_type'] = DB::table('fuel_types')->get();
		$dbwhere = DB::table('features')->get();
		$mainfeat=[];
		if($dbwhere){
			$i=0;
			$mainfeat=[];
			foreach($dbwhere as $key=>$val){
				$mainfeat[$i]['name'] = $val->feature;
				$child = DB::table('features_child')->where('feature_id',$val->id)->get();
				$mainfeat[$i]['child'] = $child;
				$i++;
			}
		}
		$data['features'] = $mainfeat;
		return view('admin.used_cars.addWithDealerStep2', $data);
    }
	 
	public function storeUsedCarStep2(Request $request, $id) {
		$date = date("Y-m-d h:i:s", time());		
		$trim = $request->post('trim');
		$transmission = $request->post('transmission');
		$no_of_doors = $request->post('no_of_doors');
		$seating_capacity = $request->post('seating_capacity');
		$body_type = $request->post('body_type');
		$color = $request->post('color');
		$price = $request->post('price');
		$features = $request->post('features');
		$impload = implode(',',$features);
		$previous_owners_number = $request->post('previous_owners_number');
		$driven_km = $request->post('driven_km');
		$seller_comment = $request->post('seller_comment');
		$history = $request->post('history');
		$insurance = $request->post('insurance');
		$mfwarranty = $request->post('mfwarranty');
		$mfwarrantydate = $request->post('mfwarrantydate');
		$drivetrain = $request->post('drivetrain');
		$ftc = $request->post('ftc');
		$mileage = $request->post('mileage');
		$steering_type = $request->post('steering_type');
		$suspension_front = $request->post('suspension_front');
		$reason_sell = $request->post('reason_sell');
		$condition = $request->post('condition');
		
		$fuel_type = $request->post('fuel_type');
		$transmission_type = $request->post('transmission_type');
		$vehicle_summery = $request->post('vehicle_summery');
		$engine_capacity = $request->post('engine_capacity');
		
		$multiple_images = $request->file('images');
		$image = '';
		if ($request->hasFile('images')) {
			$image = $request->file('images');
			$data = [];
			foreach ($image as $files) {
				$destinationPath = 'public/uploads/cars_images/';
				$file_name = time() . "." . $files->getClientOriginalExtension();
				$files->move($destinationPath, $file_name);
				$data[] = $file_name;
			}
			$image = implode(",", $data);
		}
		
		$ar = [
			'car_id' => $id,
			'trim' => $trim,
			'transmission' => $transmission,
			'no_of_doors' => $no_of_doors,
			'seating_capacity' => $seating_capacity,
			'body_type' => $body_type,
			'color' => $color,
			'fuel_type' => $fuel_type,
			'transmission_type' => $transmission_type,
			'vehicle_summery' => $vehicle_summery,
			'engine_capacity' => $engine_capacity,
			'price' => $price,
			'features' => $impload,
			'previous_owners_number' => $previous_owners_number,
			'driven_km' => $driven_km,
			'history' => $history,
			'insurance' => $insurance,
			'mfwarranty' => $mfwarranty,
			'mfwarrantydate' => $mfwarrantydate,
			'drivetrain' => $drivetrain,
			'ftc' => $ftc,
			'mileage' => $mileage,
			'steering_type' => $steering_type,
			'suspension_front' => $suspension_front,
			'seller_comment' => $seller_comment,
			'reason_sell' => $reason_sell,
			'condition' => $condition,
			'images' => $image,
			'date' => $date
		];
		DB::table('cars_meta')->insert($ar);
		return redirect()->route('admin.used_cars')->with('success','Successfully added car for dealer.');
    }
	
	public function addUsedCarWithDealerStep3($id) {
		$data['active_link'] = 'used_cars'; 
		$data['car_id'] = $id;
		$data['cars_plan'] = DB::table('cars_plan')->first();
		return view('admin.used_cars.addWithDealerStep3', $data);
    }
	
	public function storeUsedCarStep3(Request $request, $id) {
		$date = date("Y-m-d h:i:s", time());		
		$ar = [
			'car_id' => $id,
			'body_type' => $request->post('body_type'),
			'length' => trim($request->post('length')),
			'width' => trim($request->post('width')),
			'height' => trim($request->post('height')),
			'wheelbase' => trim($request->post('wheelbase')),
			'curb_weight' => trim($request->post('curb_weight')),
			'created_at' => $date,
			'upcated_at' => $date
		];
		DB::table('used_cars_dimweight')->insert($ar);
		return redirect()->route('admin.used_cars')->with('success','Successfully added car for dealer.');
    } ///////////
	
	public function ajaxUsedCarList() {
        return Datatables::of(DB::table('cars')->where('car_type','used_car')->join('vehicle_types', 'cars.vehicle_type', '=', 'vehicle_types.id')->join('companies', 'cars.make', '=', 'companies.id')->join('car_models', 'cars.model', '=', 'car_models.id')->select('cars.id','cars.make','cars.model','cars.year','cars.registration_number','cars.current_mileage','cars.sold_notification','cars.status','cars.created_at','companies.title','car_models.title as modelName','car_models.trim','vehicle_types.type')->orderBy('id','DESC')->get())
        ->addColumn('action', function($data) {
        	$data->deleteMsg = 'Are you sure want to delete ?';
        	$button = '<a href="'.route('admin.editUsedCar', [$data->id]).'" id="'.$data->id.'" class="btn btn-info btn-sm" title="Edit Used Car"><i class="far fa-edit"></i></a>';
        	$button .='&nbsp;&nbsp;';
        	$button .='<a href="'.route('admin.deleteUsedCar', [$data->id]).'" id="'.$data->id.'" id="'.$data->id.'" class="btn btn-danger btn-sm" onclick="return confirm('."'".$data->deleteMsg."'".');" title="Delete UsedCar" ><i class="fas fa-trash-alt"></i></a>';
			$button .='&nbsp;&nbsp;';

			if($data->status == 'Active') {
				$iconClass = 'fas fa-lock';
				$statusClass = 'btn btn-success btn-sm';
				$statusTitle = 'Inactive UsedCar';
				$data->statusMsg = 'Are you sure want to inactivate UsedCar ?';
			} else {
				$iconClass = 'fas fa-lock-open';
				$statusClass = 'btn btn-danger btn-sm';
				$statusTitle = 'Active UsedCar';
				$data->statusMsg = 'Are you sure want to change status ?';
				$data->statusMsg = 'Are you sure want to activate UsedCar ?';
			}
        	$button .='<a href="'.route('admin.UsedCarChangeStatus', [$data->id, $data->status]).'" id="'.$data->id.'" class="'.$statusClass.'" onclick="return confirm('."'".$data->statusMsg."'".');" title="'.$statusTitle.'" ><i class="'.$iconClass.'"></i></a>';
			$button .='&nbsp;&nbsp;';
			$button.= '<a href="'.route('admin.viewUsedCar', [$data->id]).'" id="'.$data->id.'" class="btn btn-info btn-sm" title="View Used Car"><i class="far fa-eye"></i></a>';
			$button .='&nbsp;&nbsp;';
			$button.= '<a href="'.route('admin.viewReports', [$data->id]).'" id="'.$data->id.'" class="btn btn-info btn-sm" title="View Reports"><i class="fas fa-flag"></i></a>';
			$button .='&nbsp;&nbsp;';
			$button.= '<a href="'.route('admin.comments', [$data->id]).'" id="'.$data->id.'" class="btn btn-dark btn-sm" title="View Comments"><i class="fas fa-comment"></i></a>';
        	return $button;  
        })
        ->rawColumns(['action'])
        ->make(true);
	}

	public function viewReports($id) {
		$data['active_link'] = 'used_cars';
		$data['detail'] = DB::table('reports')->where('car_id', $id)->first();
		return view('admin.used_cars.reports', $data);
    }
	
	public function ajaxReportList($id) {
        return Datatables::of(DB::table('reports')->where('car_id', $id)->get())
        ->addColumn('action', function($data) {
        	$button ='&nbsp;&nbsp;';
        	return $button;  
        })
        ->rawColumns(['action'])
        ->make(true);
	}
	
	public function deleteUsedCar($id) {
		DB::table('cars')->where('id', $id)->delete();
		DB::table('cars_meta')->where('car_id', $id)->delete();
		return back()->with('success','Used Car deleted successfully.');
    }
	
	public function editUsedCar($id) {
		$data['active_link'] = 'used_cars';
		$data['detail'] = DB::table('cars')->where('id', $id)->first();
		$data['cars_meta'] = DB::table('cars_meta')->where('car_id', $id)->first();
		$data['make'] = Company::get();
		$data['vehicle_type'] = DB::table('vehicle_types')->get();
		$data['model'] = DB::table('car_models')->get();
		$data['transmission'] = DB::table('transmission')->get();
		$data['body_type'] = DB::table('body_type')->get();
		$data['fuel_type'] = DB::table('fuel_types')->get();
		$dbwhere = DB::table('features')->get();
		$mainfeat=[];
		if($dbwhere){
			$i=0;
			$mainfeat=[];
			foreach($dbwhere as $key=>$val){
				$mainfeat[$i]['name'] = $val->feature;
				$child = DB::table('features_child')->where('feature_id',$val->id)->get();
				$mainfeat[$i]['child'] = $child;
				$i++;
			}
		}
		$data['features'] = $mainfeat;
		return view('admin.used_cars.edit', $data);
    }
	
	public function viewUsedCar($id) {
		$data['active_link'] = 'used_cars';
		$data['detail'] = DB::table('cars')->where('id', $id)->first();
		$data['vehicle_types'] = DB::table('vehicle_types')->where('id', $data['detail']->vehicle_type)->first();
		$data['make'] = DB::table('companies')->where('id', $data['detail']->make)->first();
		$data['car_models'] = DB::table('car_models')->where('id', $data['detail']->model)->first();
		$data['user'] = DB::table('users')->where('id', $data['detail']->user_id)->select('first_name','last_name')->first();
		$data['cars_meta'] = DB::table('cars_meta')->where('car_id', $data['detail']->id)->first();
		$data['trans'] = DB::table('transmission')->where('id', $data['cars_meta']->transmission)->first();
		$data['body_type'] = DB::table('body_type')->where('id', $data['cars_meta']->body_type)->first();
		$data['fuel_type'] = DB::table('fuel_types')->where('id', $data['cars_meta']->fuel_type)->first();
		return view('admin.used_cars.show', $data);
    }
	
	public function updateUsedCar(Request $request, $id) {
		$request->validate([
			'name' => 'required|min:2'
		]);
		$date = date("Y-m-d h:i:s", time());
		DB::table('cars')->where('id', $id)->update([
			'vehicle_type' => $request->post('vehicle_type'),
			'make' => $request->post('make'),
			'model' => $request->post('model'),
			'year' => $request->post('year'),
			'registration_number' => trim($request->post('registration_number')),
			'current_mileage' => trim($request->post('current_mileage')),
			'status' => trim($request->post('status')),
			'updated_at' => $date
		]);
		return redirect()->route('admin.editUsedCar', ['id' => $id])->with('success','Basic Information updated successfully.');
    }
	
	public function updateUsedCarMetas(Request $request, $id) {
		$date = date("Y-m-d h:i:s", time());
		$trim = $request->post('trim');
		$transmission = $request->post('transmission');
		$no_of_doors = $request->post('no_of_doors');
		$seating_capacity = $request->post('seating_capacity');
		$body_type = $request->post('body_type');
		$color = $request->post('color');
		$price = $request->post('price');
		$features = $request->post('features');
		
		$previous_owners_number = $request->post('previous_owners_number');
		$driven_km = $request->post('driven_km');
		$seller_comment = $request->post('seller_comment');
		
		$history = $request->post('history');
		$insurance = $request->post('insurance');
		$mfwarranty = $request->post('mfwarranty');
		$mfwarrantydate = $request->post('mfwarrantydate');
		$drivetrain = $request->post('drivetrain');
		$ftc = $request->post('ftc');
		$mileage = $request->post('mileage');
		$steering_type = $request->post('steering_type');
		$suspension_front = $request->post('suspension_front');
		
		$reason_sell = $request->post('reason_sell');
		$condition = $request->post('condition');
		
		$fuel_type = $request->post('fuel_type');
		$transmission_type = $request->post('transmission_type');
		$vehicle_summery = $request->post('vehicle_summery');
		$engine_capacity = $request->post('engine_capacity');
		
		$multiple_images = $request->file('images');
		if ($request->hasFile('images')) {
			$image = $request->file('images');
			$data = [];
			foreach ($image as $files) {
				$destinationPath = 'public/uploads/cars_images/';
				$file_name = time() . "." . $files->getClientOriginalExtension();
				$files->move($destinationPath, $file_name);
				$data[] = $file_name;
			}
			$image = implode(",", $data);
		}else{
			$mk = DB::table('cars_meta')->where('car_id', $id)->select('images')->first();
			$image = $mk->images;
		}
		
		if($features){
			$impload = implode(',',$features);
		}else{
			$mets = DB::table('cars_meta')->where('car_id', $id)->first();
			$impload = $mets->features;
		}
		
		
		$ar = [
			'trim' => $trim,
			'transmission' => $transmission,
			'no_of_doors' => $no_of_doors,
			'seating_capacity' => $seating_capacity,
			'body_type' => $body_type,
			'color' => $color,
			'price' => $price,
			'fuel_type' => $fuel_type,
			'transmission_type' => $transmission_type,
			'vehicle_summery' => $vehicle_summery,
			'engine_capacity' => $engine_capacity,
			'features' => $impload,
			'previous_owners_number' => $previous_owners_number,
			'driven_km' => $driven_km,
			'history' => $history,
			'insurance' => $insurance,
			'mfwarranty' => $mfwarranty,
			'mfwarrantydate' => $mfwarrantydate,
			'drivetrain' => $drivetrain,
			'ftc' => $ftc,
			'mileage' => $mileage,
			'steering_type' => $steering_type,
			'suspension_front' => $suspension_front,
			'seller_comment' => $seller_comment,
			'reason_sell' => $reason_sell,
			'condition' => $condition,
			'images' => $image,
			'date' => $date
		];
		DB::table('cars_meta')->where('car_id', $id)->update($ar);
		return redirect()->route('admin.editUsedCar', ['id' => $id])->with('success','Car Meta updated successfully.');
    }
	
	public function updateUsedCarEnTrans(Request $request, $id) {
		$date = date("Y-m-d h:i:s", time());
		Usedcarsenginetrans::where('car_id', $id)->update([
			'cylinders' => trim($request->post('cylinders')),
			'engine_size' => trim($request->post('engine_size')),
			'hp' => $request->post('hp'),
			'hp_rpm' => $request->post('hp_rpm'),
			'torque' => trim($request->post('torque')),
			'torque_rpm' => trim($request->post('torque_rpm')),
			'drive_type' => trim($request->post('drive_type')),
			'transmission' => trim($request->post('transmission')),
			'updated_at' => $date
		]);
		return redirect()->route('admin.editUsedCar', ['id' => $id])->with('success','Engine and transmission updated successfully.');
    }
	
	public function updateUsedCarFuelMile(Request $request, $id) {
		$date = date("Y-m-d h:i:s", time());
		Usedcarsfuels::where('car_id', $id)->update([
			'engine_type' => trim($request->post('engine_type')),
			'fuel_type' => trim($request->post('fuel_type')),
			'tank_capacity' => $request->post('tank_capacity'),
			'combine_mpg' => $request->post('combine_mpg'),
			'epa_mileage' => trim($request->post('epa_mileage')),
			'range' => trim($request->post('range')),
			'updated_at' => $date
		]);
		return redirect()->route('admin.editUsedCar', ['id' => $id])->with('success','Fuel and mileage updated successfully.');
    }
	
	public function updateUsedCarBolus(Request $request, $id) {
		$date = date("Y-m-d h:i:s", time());
		Usedcarsbonus::where('car_id', $id)->update([
			'domestic_import' => trim($request->post('domestic_import')),
			'origin_country' => trim($request->post('origin_country')),
			'car_classification' => $request->post('car_classification'),
			'platform_code' => $request->post('platform_code'),
			'date_added' => trim($request->post('date_added')),
			'updated_at' => $date
		]);
		return redirect()->route('admin.editUsedCar', ['id' => $id])->with('success','Bonus data updated successfully.');
    }
	
	public function updateUsedStats(Request $request, $id) {
		$date = date("Y-m-d h:i:s", time());
		Usedcarsstatistic::where('car_id', $id)->update([
			'new_make' => trim($request->post('new_make')),
			'new_model' => trim($request->post('new_model')),
			'new_year' => $request->post('new_year'),
			'updated_at' => $date
		]);
		return redirect()->route('admin.editUsedCar', ['id' => $id])->with('success','Statistics updated successfully.');
    }
	
	public function updateUsedCarImages(Request $request, $id) {
		$date = date("Y-m-d h:i:s", time());
		$main_image = $request->file('main_image');
		$multiple_images = $request->file('images');
		$select = DB::table('used_cars_images')->where('car_id',$id)->first();
		if ($request->hasFile('images')) {
			$image = $request->file('images');
			$data = [];
			foreach ($image as $files) {
				$destinationPath = 'public/uploads/used_cars/';
				$file_name = time() . "." . $files->getClientOriginalExtension();
				$files->move($destinationPath, $file_name);
				$data[] = $file_name;
			}
			$image = implode(",", $data);
		}else{
			$image = $select->multiple_images;
		}		
		
		if($main_image){
			$extension = $main_image->getClientOriginalExtension();
			$mainimgfn = time().'.'.$extension;
			$icon_type='img';
			$main_image->move('public/uploads/used_cars/', $mainimgfn);
		}else{
			$mainimgfn = $select->main_image;
		}
		$ar = [
			'main_image' => $mainimgfn,
			'multiple_images' => $image,
			'updated_at' => $date
		];
		DB::table('used_cars_images')->where('car_id',$id)->update($ar);
		return redirect()->route('admin.editUsedCar', ['id' => $id])->with('success','Images updated successfully.');
    }
	
	public function UsedCarChangeStatus($id, $status) {
		if($status == 'Inactive') {
			$updateField = 'Active';
		} else {
			$updateField = 'Inactive';
		}
		$getcheck = DB::table('cars')->where('id', $id)->select('user_id')->first();
		if($getcheck){
			$device = DB::table('users')->where('id', $getcheck->user_id)->select('device_id')->first();
			if($device){
				$deviceid = $device->device_id;
				if($deviceid){
					$fcmUrl = 'https://fcm.googleapis.com/fcm/send';
					$FIREBASE_API_KEY = env('FIREBASE_API_KEY');

					$notification = [
						'title' => 'Car Approved',
						'body' => 'Hi!, Your car has been approved.',
						'icon' =>'myIcon', 
						'sound' => 'mySound'
					];
					$otherdetails = [
						'notification_type' => 'caradmin',
						'relation_id' => $id
					];
					$extraNotificationData = ["message" => $notification,"otherdetails" =>$otherdetails];

					$fcmNotification = [
						'registration_ids' => array($deviceid),
						'notification' => $notification,
						 'data' => $extraNotificationData
					];

					$headers = [
						'Authorization: key=' . $FIREBASE_API_KEY,
						'Content-Type: application/json'
					];


					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL,$fcmUrl);
					curl_setopt($ch, CURLOPT_POST, true);
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
					$result = curl_exec($ch);
					if ($result === FALSE) {
						die('FCM Send Error: ' . curl_error($ch));
					}
					curl_close($ch);
				}
			}
			
		}
		DB::table('cars')->where('id', $id)->update([
			'status' => $updateField
		]);
		return back()->with('success','Used Car status updated successfully.');
    }
	
	public function getModel($id){
		$model = CarModel::where('make',$id)->get();
		$makename = Company::where('id',$id)->first();
		$option = '';
		if($model){
			$option = '';
			foreach($model as $val){
				$option.='<option value="'.$val['id'].'">'.$val['model_id'].'-'.$makename['title'].'-'.$val['title'].'</option>';
			}
		}
		$result=array('status'=>true,'data'=> $option);
		echo json_encode($result);
    }
	
    
    public function exportExcel($type) {
        return \Excel::download(new UsersExport, 'users.'.$type);
    }
}