<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;


use App\Models\User;
use App\Models\Country;
use App\Models\State;
use App\Models\City;


use App\Exports\UsersExport;

use Hash;
use DB;


class CustomerController extends Controller
{
    public function index() {
        $data['active_link'] = 'student-list'; 
        return view('admin.customer.list', $data);
    }
	
    public function ajaxCustomerList() {
        return Datatables::of( User::where('user_type', 'student')->orderBy('id', 'DESC')->get())
        ->addColumn('action', function($data) {
        	$data->deleteMsg = 'Are you sure want to delete ?';
        	$button = '<a href="'.route('admin.editCustomer', [$data->id]).'" id="'.$data->id.'" class="btn btn-info btn-sm" title="Edit Student"><i class="far fa-edit"></i></a>';
        	$button .='&nbsp;&nbsp;';
        	$button .='<a href="'.route('admin.deleteCustomer', [$data->id]).'" id="'.$data->id.'" class="btn btn-danger btn-sm" onclick="return confirm('."'".$data->deleteMsg."'".');" title="Delete Student" ><i class="fas fa-trash-alt"></i></a>';
			$button .='&nbsp;&nbsp;';

          if($data->status == 'Active') {
            $iconClass = 'fas fa-lock';
            $statusClass = 'btn btn-success btn-sm';
            $statusTitle = 'Inactive Student';
            $data->statusMsg = 'Are you sure want to inactivate Student '.$data->name.' ?';

          } else {
            $iconClass = 'fas fa-lock-open';
            $statusClass = 'btn btn-danger btn-sm';
            $statusTitle = 'Active Student';
            $data->statusMsg = 'Are you sure want to change status ?';
            $data->statusMsg = 'Are you sure want to activate Student '.$data->name.' ?';
          }

        	$button .='<a href="'.route('admin.customerChangeStatus', [$data->id, $data->status]).'" id="'.$data->id.'" class="'.$statusClass.'" onclick="return confirm('."'".$data->statusMsg."'".');" title="'.$statusTitle.'" ><i class="'.$iconClass.'"></i></a>';
        	
        	return $button;  
        })->rawColumns(['action'])
        ->make(true);
	  }

	
    public function exportExcel($type) {
        return \Excel::download(new UsersExport, 'users.'.$type);
    }
    
	public function deleteCustomer($id) {
      
      User::where('id', $id)->delete();

      return back()->with('success','Student deleted successfully.');

    }

    public function customerChangeStatus($id, $status) {
      if($status == 'Inactive') {
        $updateField = 'Active';
      } else {
        $updateField = 'Inactive';
      }

      User::where('id', $id)->update([
        'status' => $updateField
      ]);

      return back()->with('success','Student status updated successfully.');

    }    
         
    public function addCustomer() {
      $data['active_link'] = 'student-list'; 


      return view('admin.customer.add',$data);
    }

    public function storeCustomer(Request $request) {
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
			'user_type'  => 'student',
			'role_id'  => 4,
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
  
      return redirect()->route('admin.customers')->with('success','Student added successfully.');

    }

    public function editCustomer($id) {
      $data['active_link'] = 'student-list';
      $data['customerInfo'] = User::where('id', $id)->first(); 
      return view('admin.customer.edit', $data);
    }
 
    public function updateCustomer(Request $request, $id) {

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
  
      return redirect()->route('admin.customers')->with('success','Student updated successfully.');
    }
}