<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

use App\Models\User;
use App\Models\DealerOtherInfo;

use App\Exports\DealersExport;
use Hash;

use DB;


use File;
use Intervention\Image\ImageManagerStatic as Image;


class DealerController extends Controller
{
    public function index() {

        $data['active_link'] = 'educator-list'; 
        return view('admin.dealer.list', $data);
    }

    public function ajaxDealerList(Request $request) {

       $data = User::where(['user_type' => 'educator']);
       return Datatables::of( $data )

       ->addIndexColumn()

        ->addColumn('action', function($data) {

        	$data->deleteMsg = 'Are you sure want to delete ?';

        	$button = '<a href="'.route('admin.editDealer', [$data->id]).'" id="'.$data->id.'" class="btn btn-info btn-sm" title="Edit Educator"><i class="far fa-edit"></i></a>';
        	$button .='&nbsp;&nbsp;';
        	$button .='<a href="'.route('admin.deleteDealer', [$data->id]).'" id="'.$data->id.'" class="btn btn-danger btn-sm" onclick="return confirm('."'".$data->deleteMsg."'".');" title="Delete Educator" ><i class="fas fa-trash-alt"></i></a>';

          $button .='&nbsp;&nbsp;';
          if($data->status == 'Active') {
            $iconClass = 'fas fa-lock';
            $statusClass = 'btn btn-success btn-sm';
            $statusTitle = 'Inactive Educator';
            $data->statusMsg = 'Are you sure want to inactivate Educator '.$data->name.' ?';

          } else {
            $iconClass = 'fas fa-lock-open';
            $statusClass = 'btn btn-danger btn-sm';
            $statusTitle = 'Active Educator';
            $data->statusMsg = 'Are you sure want to change status ?';
            $data->statusMsg = 'Are you sure want to activate Educator '.$data->name.' ?';

          }
        	$button .='<a href="'.route('admin.changeStatus', [$data->id, $data->status]).'" id="'.$data->id.'" class="'.$statusClass.'" onclick="return confirm('."'".$data->statusMsg."'".');" title="'.$statusTitle.'" ><i class="'.$iconClass.'"></i></a>';
        	
        	return $button;  
        })
        ->filter(function ($instance) use ($request) {
          if ($request->get('status') == 'Active' || $request->get('status') == 'Inactive') {
            $instance->where('status', $request->get('status'));
          }

          if (!empty($request->get('search'))) {
              $instance->where(function($w) use($request){
               $search = $request->get('search');
               $w->orWhere('name', 'LIKE', "%$search%")
               ->orWhere('email', 'LIKE', "%$search%");
           });
          }


        })->rawColumns(['action'])
        ->make(true);

	  }

    public function dealerExportExcel($type) {
        return \Excel::download(new DealersExport, 'users.'.$type);
    }
  
    public function deleteDealer($id) {
      User::where('id', $id)->delete();
      return back()->with('success','Educator deleted successfully.');
    }


    public function changeStatus($id, $status) {
      
      if($status == 'Inactive') {
        $updateField = 'Active';
      } else {
        $updateField = 'Inactive';
      }

      User::where('id', $id)->update([
        'status' => $updateField
      ]);

      return back()->with('success','Educator status updated successfully.');

    }    
 
    public function addDealer() {
      $data['active_link'] = 'educator-list'; 
      return view('admin.dealer.add', $data);
    }

  
    public function storeDealer(Request $request) {

      $request->validate([
        'name'        => 'required|min:2',
        'email'             => 'required|string|email|max:255|unique:users',
        'password'          => 'required|min:8',
        'phone'          => 'required'

      ]);
		$name=$request->post('name');
		$phone=$request->post('phone');
		$email=$request->post('email');
		$password=$request->post('password');
        $address=$request->post('address');
        $income=$request->post('income');
		$age=$request->post('age');
		$status=$request->post('status');
		$education_history=$request->post('education_history');
		$date = date("Y-m-d H:i:s", time());
		$data = [
			'user_type'  => 'educator',
			'role_id'  => 5,
			'username' => trim($email),
			'password'   => Hash::make($password), 
			'name'  => trim($name),
			'email'      => trim($email),
			'phone'   => trim($phone),
			'age'   => trim($age),
			'education_history'    => trim($education_history),
			'address'    => trim($address),
			'income'   => $income,
			'device_id' => '',
			'status'  => $status,
			'created_at'  => $date,
			'updated_at'  => $date,
		];
		$adduser =DB::table('users')->insert($data);
  
      return redirect()->route('admin.dealers')->with('success','Educator added successfully.');
    }

    public function editDealer($id) {
      $data['active_link'] = 'educator-list'; 
      $data['customerInfo'] = User::where('id', $id)->first(); 
      return view('admin.dealer.edit', $data);
    }
 
    public function updateDealer(Request $request, $id) {
      $request->validate([
		'name' => 'required|min:2',
		'email' => 'required|string|email|max:255|unique:users',
		'phone' => 'required'
      ]);
		$name=$request->post('name');
		$phone=$request->post('phone');
		$email=$request->post('email');
        $address=$request->post('address');
        $income=$request->post('income');
		$age=$request->post('age');
		$status=$request->post('status');
		$education_history=$request->post('education_history');
		$date = date("Y-m-d H:i:s", time());
      User::where('id', $id)->update([
			'name'  => trim($name),
			'username' => trim($email),
			'email' => trim($email),
			'phone' => trim($phone),
			'age' => trim($age),
			'education_history' => trim($education_history),
			'address' => trim($address),
			'income' => $income,
			'status' => $status,
			'updated_at' => $date,

      ]);
  
      return redirect()->route('admin.dealers')->with('success','Educator updated successfully.');
    }

}