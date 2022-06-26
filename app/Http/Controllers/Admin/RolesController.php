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

use Hash;


class RolesController extends Controller
{ 
    public function index() {
        $data['active_link'] = 'roles'; 
        return view('admin.roles.list', $data);
    }
	
	public function addRole() {
		$data['active_link'] = 'roles'; 
		return view('admin.roles.add', $data);
    }
	
	public function storeRole(Request $request) {
		$request->validate([
			'name' => 'required|min:2'
		]);
		$date = date("Y-m-d h:i:s", time());
		Roles::create([
			'name' => trim( ucfirst($request->post('name'))),
			'add' => trim($request->post('add')),
			'edit' => trim($request->post('edit')),
			'delete' => trim($request->post('delete')),
			'view' => trim($request->post('view')),
			'status' => trim($request->post('status')),
			'created_at' => $date,
		]);
		return redirect()->route('admin.roles')->with('success','Role added successfully.');
    }
	
	public function ajaxRolesList() {
        return Datatables::of(Roles::get())
        ->addColumn('action', function($data) {
        	$data->deleteMsg = 'Are you sure want to delete ?';
        	$button = '<a href="'.route('admin.editRole', [$data->id]).'" id="'.$data->id.'" class="btn btn-info btn-sm" title="Edit Role"><i class="far fa-edit"></i></a>';
        	$button .='&nbsp;&nbsp;';
        	$button .='<a href="'.route('admin.deleteRole', [$data->id]).'" id="'.$data->id.'" id="'.$data->id.'" class="btn btn-danger btn-sm" onclick="return confirm('."'".$data->deleteMsg."'".');" title="Delete Role" ><i class="fas fa-trash-alt"></i></a>';
			$button .='&nbsp;&nbsp;';

          if($data->status == 'Active') {
            $iconClass = 'fas fa-lock';
            $statusClass = 'btn btn-success btn-sm';
            $statusTitle = 'Inactive Role';
            $data->statusMsg = 'Are you sure want to inactivate Role '.$data->name.' ?';

          } else {
            $iconClass = 'fas fa-lock-open';
            $statusClass = 'btn btn-danger btn-sm';
            $statusTitle = 'Active Role';
            $data->statusMsg = 'Are you sure want to change status ?';
            $data->statusMsg = 'Are you sure want to activate Role '.$data->name.' ?';
          }
        	$button .='<a href="'.route('admin.RoleChangeStatus', [$data->id, $data->status]).'" id="'.$data->id.'" class="'.$statusClass.'" onclick="return confirm('."'".$data->statusMsg."'".');" title="'.$statusTitle.'" ><i class="'.$iconClass.'"></i></a>';
        	return $button;  
        })
        ->rawColumns(['action'])

        ->make(true);
	}
	public function deleteRole($id) {
		Roles::where('id', $id)->delete();
		return back()->with('success','Role deleted successfully.');
    }
	
	public function editRole($id) {
      $data['active_link'] = 'roles';
      $data['detail'] = Roles::where('id', $id)->first(); 
      return view('admin.roles.edit', $data);
    }
	
	public function updateRole(Request $request, $id) {
      $request->validate([
        'name' => 'required|min:2'
      ]);
  
      Roles::where('id', $id)->update([
        'name' => trim( ucfirst($request->post('name'))),
		'add' => trim($request->post('add')),
		'edit' => trim($request->post('edit')),
		'delete' => trim($request->post('delete')),
		'view' => trim($request->post('view')),
		'status' => trim($request->post('status')),
      ]);
  
      return redirect()->route('admin.roles')->with('success','Role updated successfully.');
    }
	
	public function RoleChangeStatus($id, $status) {
      if($status == 'Inactive') {
        $updateField = 'Active';
      } else {
        $updateField = 'Inactive';
      }
      Roles::where('id', $id)->update([
        'status' => $updateField
      ]);
      return back()->with('success','Role status updated successfully.');

    }

  /**
   * Function name : ajaxCustomerList
   * Parameter : null
   * task : show customer list with ajax 
   * auther : Manish Silawat
   */      
    

  /**
   * Function name : exportExcel
   * Parameter : type { type is used for download file type.. it may be csv, xlsx .. etc}
   * task : download customer information in csv format.. 
   * auther : Manish Silawat
   */     
    public function exportExcel($type) {
        return \Excel::download(new UsersExport, 'users.'.$type);
    }

  /**
   * Function name : deleteCustomer
   * Parameter : id
   * task : delete customer information from database table.. 
   * auther : Manish Silawat
   */    
  

  /**
   * Function name : customerChangeStatus
   * Parameter : id, status
   * task : change customer status {status may be Active or Inactive}. 
   * auther : Manish Silawat
   */ 
        
    
  /**
   * Function name : addCustomer
   * Parameter : null
   * task : load view for add customer information. 
   * auther : Manish Silawat
   */      
    

  /**
   * Function name : storeCustomer
   * Parameter : request { this is form request with the help of this we can get all http request }
   * task : store customer information. 
   * auther : Manish Silawat
   */  
    

  /**
   * Function name : editCustomer
   * Parameter : id { this is user unique id and primary key }
   * task : show customer information on view. 
   * auther : Manish Silawat
   */
    

  /**
   * Function name : updateCustomer
   * Parameter : id { this is user unique id and primary key }, request { this is form request with the help of this we can get all http request }
   * task : update customer information. 
   * auther : Manish Silawat
   */   
    


    function getStates( $countryId ) {
      // get all states according to country id 
      $data['allStates'] = State::where('country_id', $countryId)->get();
      // load ajax view..
      return view('admin.ajaxStates', $data);
  
    }
  
    function getCities( $stateId ) {
      // get all cities according to state id 
      $data['allCities'] = City::where('state_id', $stateId)->get();
      // load ajax view..
      return view('admin.ajaxCities', $data);
  
    }
	
	/////////// by Pawan
	function userRoles() {
      //$data['allCities'] = City::where('state_id', $stateId)->get();
      return view('admin.roles.list');
  
    }
}