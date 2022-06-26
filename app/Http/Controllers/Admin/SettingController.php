<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Category;
use App\Models\CarModel;
use App\Models\Company;
use App\Models\Faq;

use App\Models\Notification;


use Yajra\Datatables\Datatables;

use App\Exports\CountryExport;
use App\Exports\StateExport;
use App\Exports\CityExport;
use App\Models\Charge;
use DB;
class SettingController extends Controller
{
    /**
     * Function name : index
     * Parameter : null
     * task : show all country list
     * auther : Manish Silawat
     */   
    public function index() {

        $data['active_link'] = 'country_list'; 
        return view('admin.country.list', $data);
    }

    /**
     * Function name : ajaxCountryList
     * Parameter : null
     * task : show Country list with ajax 
     * auther : Manish Silawat
     */      
    public function ajaxCountryList() {

        return Datatables::of( Country::get())
        ->addColumn('action', function($data) {
            $data->deleteMsg = 'Are you sure want to delete ?';
            
            $button = '<a href="'.route('admin.states', [$data->id]).'" id="'.$data->id.'" class="btn btn-success btn-sm" title="States in Country '.$data->name.'"><i class="fa fa-list"></i></a>';
            $button .='&nbsp;&nbsp;';


            $button .= '<a href="'.route('admin.editCountry', [$data->id]).'" id="'.$data->id.'" class="btn btn-info btn-sm" title="Edit Country"><i class="far fa-edit"></i></a>';
            $button .='&nbsp;&nbsp;';

            $button .='<a href="'.route('admin.deleteCountry', [$data->id]).'" id="'.$data->id.'" class="btn btn-danger btn-sm" onclick="return confirm('."'".$data->deleteMsg."'".');" title="Delete Country" ><i class="fas fa-trash-alt"></i></a>';
            $button .='&nbsp;&nbsp;';
            
            return $button;  
        })
        ->rawColumns(['action'])

        ->make(true);
    }    

  /**
   * Function name : addCountry
   * Parameter : null
   * task : load view for add country information. 
   * auther : Manish Silawat
   */      
    public function addCountry() {
        $data['active_link'] = 'country_list'; 

      $data['allCountries'] = getAllCountries();

      return view('admin.country.add', $data);
    }

  /**
   * Function name : storeCountry
   * Parameter : request { this is form request with the help of this we can get all http request }
   * task : store country information. 
   * auther : Manish Silawat
   */  
    public function storeCountry(Request $request) {

      $request->validate([
        'name'        => 'required|min:2|unique:countries',
      ]);
  
      Country::create([
        'name'        => trim( ucfirst($request->post('name'))),
      ]);
  
      return redirect()->route('admin.countries')->with('success','Country added successfully.');

    }

  /**
   * Function name : editCountry
   * Parameter : id { this is user unique id and primary key }
   * task : show country information on view. 
   * auther : Manish Silawat
   */
  public function editCountry($id) {
    $data['active_link'] = 'country_list'; 
    // get country info..
    $data['countryInfo'] = Country::where('id', $id)->first(); 
    
    return view('admin.country.edit', $data);
  }
    

  /**
   * Function name : updateCountry
   * Parameter : id { this is user unique id and primary key }, request { this is form request with the help of this we can get all http request }
   * task : update country information. 
   * auther : Manish Silawat
   */   
  public function updateCountry(Request $request, $id) {

    $request->validate([
      'name'        => 'required|min:2|'.\Illuminate\Validation\Rule::unique('countries')->ignore($id),
    ]);

    Country::where('id', $id)->update([
      'name'        => trim( ucfirst($request->post('name'))),
    ]);

    return redirect()->route('admin.countries')->with('success','country updated successfully.');
  }


  

  /**
   * Function name : deleteCountry
   * Parameter : id
   * task : delete country information from database table.. 
   * auther : Manish Silawat
   */    
  public function deleteCountry($id) {
      
    Country::where('id', $id)->delete();

    return back()->with('success','Country deleted successfully.');

  }

  /**
   * Function name : exportCountry
   * Parameter : type { type is used for download file type.. it may be csv, xlsx .. etc}
   * task : download country information in csv format.. 
   * auther : Manish Silawat
   */ 
  public function exportCountry($type) {
    return \Excel::download(new CountryExport, 'countries.'.$type);
}


    /**
     * Function name : stateList
     * Parameter : null
     * task : show all state list
     * auther : Manish Silawat
     */   
    public function stateList($countryId) {
      
      $data['active_link'] = 'country_list'; 
      $data['countryId'] = $countryId;
       
      // echo "<pre>";
      // print_r($data['allStatesInCountry']);die;
        return view('admin.state.list', $data);
    }
    
    /**
     * Function name : ajaxStateList
     * Parameter : null
     * task : show state list with ajax 
     * auther : Manish Silawat
     */      
    public function ajaxStateList($countryId) {

        return Datatables::of( State::where('country_id', $countryId)->get())
        ->addColumn('action', function($data) {
            $data->deleteMsg = 'Are you sure want to delete ?';
            
            $button = '<a href="'.route('admin.cities', [$data->country_id,  $data->id] ).'" id="'.$data->id.'" class="btn btn-success btn-sm" title="Cities in State '.$data->name.'"><i class="fa fa-list"></i></a>';
            $button .='&nbsp;&nbsp;';            
            
            $button .= '<a href="'.route('admin.editState', [$data->id, $data->country_id]).'" id="'.$data->id.'" class="btn btn-info btn-sm" title="Edit State"><i class="far fa-edit"></i></a>';
            $button .='&nbsp;&nbsp;';
            $button .='<a href="'.route('admin.deleteState', [$data->id]).'" id="'.$data->id.'" class="btn btn-danger btn-sm" onclick="return confirm('."'".$data->deleteMsg."'".');" title="Delete State" ><i class="fas fa-trash-alt"></i></a>';
            $button .='&nbsp;&nbsp;';
            
            return $button;  
        })
        ->rawColumns(['action'])

        ->make(true);
    }
    

    public function addState($countryId) {

      $data['active_link'] = 'country_list'; 
      $data['countryId'] = $countryId;

      return view('admin.state.add', $data);      
    }


  /**
   * Function name : storeState
   * Parameter : request { this is form request with the help of this we can get all http request }
   * task : store state information. 
   * auther : Manish Silawat
   */  
  public function storeState(Request $request, $countryId) {

    $request->validate([
      'name'        => 'required|min:2|unique:states',
    ]);

    State::create([
      'name'        => trim( ucfirst($request->post('name'))),
      'country_id' => $countryId
    ]);

    return redirect()->route('admin.states', $countryId)->with('success','State added successfully.');

  }    

  /**
   * Function name : exportState
   * Parameter : countryId , type { type is used for download file type.. it may be csv, xlsx .. etc}
   * task : download state information in csv format.. 
   * auther : Manish Silawat
   */ 
  public function exportState( $type) {
    return \Excel::download(new StateExport, 'states.'.$type);
}


  /**
   * Function name : deleteState
   * Parameter : id
   * task : delete state information from database table.. 
   * auther : Manish Silawat
   */    
  public function deleteState($id) {
      
    State::where('id', $id)->delete();

    return back()->with('success','State deleted successfully.');

  }

  
  /**
   * Function name : editState
   * Parameter : id { this is user unique id and primary key }
   * task : show state information on view. 
   * auther : Manish Silawat
   */
  public function editState($stateId, $countryId) {
    $data['active_link'] = 'country_list'; 
    $data['stateId'] = $stateId;
    $data['countryId'] = $countryId;
    // get country info..
    $data['stateInfo'] = State::where('id', $stateId)->first(); 
    
    return view('admin.state.edit', $data);
  }
  



  /**
   * Function name : updateState
   * Parameter : id { this is user unique id and primary key }, request { this is form request with the help of this we can get all http request }
   * task : update country information. 
   * auther : Manish Silawat
   */   
  public function updateState(Request $request, $stateId, $countryId) {

    $request->validate([
      'name'        => 'required|min:2|'.\Illuminate\Validation\Rule::unique('states')->ignore($stateId),
    ]);

    State::where('id', $stateId)->update([
      'name'        => trim( ucfirst($request->post('name'))),
      'country_id'  =>$countryId
    ]);

    return redirect()->route('admin.states', $countryId)->with('success','State updated successfully.');
  }

  /**
   * Function name : cityList
   * Parameter : countryId, stateId
   * task : show all city list
   * auther : Manish Silawat
   */   
  public function cityList($countryId, $stateId) {

    $data['active_link'] = 'country_list'; 
      $data['countryId'] = $countryId; 
      $data['stateId'] = $stateId; 

      return view('admin.city.list', $data);
  }

  /**
   * Function name : ajaxCityList
   * Parameter : stateId
   * task : show city list with ajax 
   * auther : Manish Silawat
   */      
  public function ajaxCityList($stateId) {

      return Datatables::of( City::select(['cities.*', 'states.name as statename', 'country_id'])
      ->where('state_id', $stateId)
      ->leftjoin('states', 'states.id', '=', 'cities.state_id')
      ->get())
      ->addColumn('action', function($data) {
       
          $data->deleteMsg = 'Are you sure want to delete ?';
          $button = '<a href="'.route('admin.editCity', [$data->country_id, $data->state_id, $data->id]).'" id="'.$data->id.'" class="btn btn-info btn-sm" title="Edit City"><i class="far fa-edit"></i></a>';
          $button .='&nbsp;&nbsp;';
          $button .='<a href="'.route('admin.deleteCity', [$data->id]).'" id="'.$data->id.'" class="btn btn-danger btn-sm" onclick="return confirm('."'".$data->deleteMsg."'".');" title="Delete City" ><i class="fas fa-trash-alt"></i></a>';
          $button .='&nbsp;&nbsp;';
          
          return $button;  
      })
      ->rawColumns(['action'])

      ->make(true);
  }



  public function addCity($countryId, $stateId) {

    $data['active_link'] = 'country_list'; 
    $data['countryId'] = $countryId;
    $data['stateId'] = $stateId;

    return view('admin.city.add', $data);      
  }


/**
 * Function name : storeCity
 * Parameter : request { this is form request with the help of this we can get all http request }, countryId, stateId
 * task : store city information. 
 * auther : Manish Silawat
 */  
public function storeCity(Request $request, $countryId, $stateId) {

  $request->validate([
    'name'        => 'required|min:2|unique:cities',
  ]);

  City::create([
    'name'        => trim( ucfirst($request->post('name'))),
    'state_id' => $stateId
  ]);

  return redirect()->route('admin.cities', [$countryId, $stateId])->with('success','City added successfully.');

}  

  /**
   * Function name : editCity
   * Parameter : cityId, stateId , countryId
   * task : show state information on view. 
   * auther : Manish Silawat
   */
  public function editCity($countryId, $stateId, $cityId) {
    $data['active_link'] = 'country_list'; 
    $data['cityId'] = $cityId;
    $data['stateId'] = $stateId;
    $data['countryId'] = $countryId;
    // get country info..
    $data['cityInfo'] = City::where('id', $cityId)->first(); 
    
    return view('admin.city.edit', $data);
  }
  
  /**
   * Function name : updateCity
   * Parameter : cityId, stateId, countryId
   * task : update city information. 
   * auther : Manish Silawat
   */   
  public function updateCity(Request $request,$countryId, $stateId, $cityId ) {

    $request->validate([
      'name'        => 'required|min:2|'.\Illuminate\Validation\Rule::unique('cities')->ignore($cityId),
    ]);

    City::where('id', $cityId)->update([
      'name'        => trim( ucfirst($request->post('name'))),
      'state_id'  =>$stateId
    ]);

    return redirect()->route('admin.cities',[$countryId, $stateId] )->with('success','City updated successfully.');
  }


  /**
   * Function name : exportCity
   * Parameter :  type { type is used for download file type.. it may be csv, xlsx .. etc}
   * task : download state information in csv format.. 
   * auther : Manish Silawat
   */ 
  public function exportCity( $type, $stateId) {
    $where = ['state_id' => $stateId];
  return \Excel::download(new CityExport, 'states.'.$type);
  
}

  /**
   * Function name : deleteCity
   * Parameter : id
   * task : delete city information from database table.. 
   * auther : Manish Silawat
   */    
  public function deleteCity($id) {
      
    City::where('id', $id)->delete();

    return back()->with('success','City deleted successfully.');

  }



    /**
     * Function name : categoryList
     * Parameter : null
     * task : show all category list
     * auther : Manish Silawat
     */   
  

    /**
     * Function name : companyList
     * Parameter : null
     * task : show all company list
     * auther : Manish Silawat
     */   
    public function companyList() {

      $data['active_link'] = 'company_list'; 
      return view('admin.company.list', $data);
  }

  /**
   * Function name : ajaxCompanyList
   * Parameter : null
   * task : show Company list with ajax 
   * auther : Manish Silawat
   */      
  public function ajaxCompanyList() {

      return Datatables::of( Company::get())
      ->addColumn('action', function($data) {
          $data->deleteMsg = 'Are you sure want to delete ?';
          
          $button = '<a href="'.route('admin.editCompany', [$data->id]).'" id="'.$data->id.'" class="btn btn-info btn-sm" title="Edit Company"><i class="far fa-edit"></i></a>';
          $button .='&nbsp;&nbsp;';

          $button .='<a href="'.route('admin.deleteCompany', [$data->id]).'" id="'.$data->id.'" class="btn btn-danger btn-sm" onclick="return confirm('."'".$data->deleteMsg."'".');" title="Delete Company" ><i class="fas fa-trash-alt"></i></a>';
          $button .='&nbsp;&nbsp;';
          
          return $button;  
      })
      ->rawColumns(['action'])

      ->make(true);
  }
  
  

  /**
   * Function name : addCompany
   * Parameter : null
   * task : load view for addCompany information. 
   * auther : Manish Silawat
   */      
  public function addCompany() {
    $data['active_link'] = 'company_list'; 

  return view('admin.company.add', $data);
}

/**
* Function name : storeCompany
* Parameter : request { this is form request with the help of this we can get all http request }
* task : store company information. 
* auther : Manish Silawat
*/  
public function storeCompany(Request $request) {

  $request->validate([
    'title'        => 'required|min:2|unique:companies',
  ]);

  Company::create([
    'title'        => trim( ucfirst($request->post('title'))),
  ]);

  return redirect()->route('admin.companies')->with('success','Company added successfully.');

}


  /**
   * Function name : editCompany
   * Parameter : id { this is user unique id and primary key }
   * task : show Company information on view. 
   * auther : Manish Silawat
   */
  public function editCompany($id) {
    $data['active_link'] = 'company_list'; 
    $data['companyId'] = $id; 
    // get country info..
    $data['companyInfo'] = Company::where('id', $id)->first(); 
    
    return view('admin.company.edit', $data);
  }
    
  /**
   * Function name : updateCompany
   * Parameter : id { this is user unique id and primary key }, request { this is form request with the help of this we can get all http request }
   * task : update Company information. 
   * auther : Manish Silawat
   */   

  public function updateCompany(Request $request, $id) {

    $request->validate([
      'title'        => 'required|min:2|'.\Illuminate\Validation\Rule::unique('companies')->ignore($id),
    ]);

    Company::where('id', $id)->update([
      'title'        => trim( ucfirst($request->post('title'))),
    ]);

    return redirect()->route('admin.companies')->with('success','Company updated successfully.');
  }


  

  /**
   * Function name : deleteCompany
   * Parameter : id
   * task : delete Company information from database table.. 
   * auther : Manish Silawat
   */    
  public function deleteCompany($id) {
      
    Company::where('id', $id)->delete();

    return back()->with('success','Company deleted successfully.');

  }



/************************************************* */

    /**
     * Function name : modelList
     * Parameter : null
     * task : show all model list
     * auther : Manish Silawat
     */   
    public function modelList() {

      $data['active_link'] = 'model_list'; 
      return view('admin.car_model.list', $data);
  }

  /**
   * Function name : ajaxModelList
   * Parameter : null
   * task : show Model list with ajax 
   * auther : Manish Silawat
   */      
  public function ajaxModelList() {

      return Datatables::of( CarModel::get())
      ->addColumn('action', function($data) {
          $data->deleteMsg = 'Are you sure want to delete ?';
          
          $button = '<a href="'.route('admin.editModel', [$data->id]).'" id="'.$data->id.'" class="btn btn-info btn-sm" title="Edit Model"><i class="far fa-edit"></i></a>';
          $button .='&nbsp;&nbsp;';

          $button .='<a href="'.route('admin.deleteModel', [$data->id]).'" id="'.$data->id.'" class="btn btn-danger btn-sm" onclick="return confirm('."'".$data->deleteMsg."'".');" title="Delete Model" ><i class="fas fa-trash-alt"></i></a>';
          $button .='&nbsp;&nbsp;';
          
          return $button;  
      })
      ->rawColumns(['action'])

      ->make(true);
  }
  
  

  /**
   * Function name : addModel
   * Parameter : null
   * task : load view for addModel information. 
   * auther : Manish Silawat
   */      
  public function addModel() {
    $data['active_link'] = 'model_list'; 
	$data['make'] = Company::get(); 
  return view('admin.car_model.add', $data);
}

/**
* Function name : storeModel
* Parameter : request { this is form request with the help of this we can get all http request }
* task : store car model information. 
* auther : Manish Silawat
*/  
public function storeModel(Request $request) {

  $request->validate([
    'make'        => 'required',
	'title'        => 'required|min:2',
	'trim'        => 'required|min:2',
  ]);

  CarModel::create([
    'model_id' => $request->post('model_id'),
	'make' => $request->post('make'),
	'title' => trim($request->post('title')),
	'trim' => trim($request->post('trim')),
  ]);

  return redirect()->route('admin.car_models')->with('success','Car Model added successfully.');

}


  /**
   * Function name : editModel
   * Parameter : id { this is user unique id and primary key }
   * task : show Model information on view. 
   * auther : Manish Silawat
   */
  public function editModel($id) {
    $data['active_link'] = 'model_list'; 
    $data['modelId'] = $id; 
    $data['modelInfo'] = CarModel::where('id', $id)->first(); 
    $data['make'] = Company::get(); 
    return view('admin.car_model.edit', $data);
  }
    

  /**
   * Function name : updateModel
   * Parameter : id { this is user unique id and primary key }, request { this is form request with the help of this we can get all http request }
   * task : update car Model information. 
   * auther : Manish Silawat
   */   
  public function updateModel(Request $request, $id) {

    $request->validate([
      'title'        => 'required|min:2',
    ]);

    CarModel::where('id', $id)->update([
		'model_id' => $request->post('model_id'),
		'make' => $request->post('make'),
		'title' => trim($request->post('title')),
		'trim' => trim($request->post('trim')),
    ]);

    return redirect()->route('admin.car_models')->with('success','Car model updated successfully.');
  }

  /**
   * Function name : deleteModel
   * Parameter : id
   * task : delete Model information from database table.. 
   * auther : Manish Silawat
   */    
  public function deleteModel($id) {
      
    CarModel::where('id', $id)->delete();

    return back()->with('success','Car model deleted successfully.');

  }


  public function updateCharges() {
	$data['active_link'] = 'update_charges';
    $data['chargesInfo'] = Charge::where('id', 1)->first();
	$data['mix'] = DB::table('cars_plan')->first();    
	return view('admin.charges', $data);    
  }

  public function saveCharges(Request $request) {
    $request->validate([
      'boost_charge_for_customer'   => 'required|numeric',
      'sponser_charge_for_customer' => 'required|numeric',
      'boost_charge_for_dealer'     => 'required|numeric',
      'sponser_charge_for_dealer'   => 'required|numeric',
    ]);
  
    Charge::where('id', 1)->update([
      'boost_charge_for_customer' => $request->post('boost_charge_for_customer'),
      'sponser_charge_for_customer' => $request->post('sponser_charge_for_customer'),
      'boost_charge_for_dealer' => $request->post('boost_charge_for_dealer'),
      'sponser_charge_for_dealer' => $request->post('sponser_charge_for_dealer'),
    ]);
	DB::table('cars_plan')->where('id', 1)->update([
      'photography_price' => $request->post('photocharge'),
      'inspection_price' => $request->post('inspcharge')
    ]);
  
    return back()->with('success','Charges updated successfully.');


  }
  
	public function calculator() {
		$data['active_link'] = 'calculator';
		$data['calculator'] = DB::table('calculator_percent')->where('id', 1)->first();
		$data['calculator_time'] = DB::table('calculator_time')->get();
		return view('admin.calculator', $data);    
	}

	public function saveCalculator(Request $request) {
		$request->validate([
		  'percent'   => 'required|numeric',
		]);
	  
		DB::table('calculator_percent')->where('id', 1)->update([
		  'percent' => $request->post('percent')
		]);
		if($request->post('month')){
			$value = explode(' ',$request->post('month'));
			$vls = $value[0];
			$date = date("Y-m-d h:i:s", time());		
			$ar = [
				'type' => $request->post('month'),
				'value' => $vls,
				'date' => $date
			];
			DB::table('calculator_time')->insert($ar);
		}
	  
		return back()->with('success','Charges updated successfully.');


	}


  


    /**
     * Function name : notificationList
     * Parameter : null
     * task : show all notification list
     * auther : Manish Silawat
     */   
    public function notificationList() {

      $data['active_link'] = 'notification_list'; 
      return view('admin.notification.list', $data);
  }

  /**
   * Function name : ajaxNotificationList
   * Parameter : null
   * task : show ajax notification list with ajax 
   * auther : Manish Silawat
   */      
  public function ajaxNotificationList() {

      return Datatables::of( Notification::get())
      ->addColumn('action', function($data) {
          $data->deleteMsg = 'Are you sure want to delete ?';
          
        
          $button ='<a href="'.route('admin.deleteNotification', [$data->id]).'" id="'.$data->id.'" class="btn btn-danger btn-sm" onclick="return confirm('."'".$data->deleteMsg."'".');" title="Delete Notification" ><i class="fas fa-trash-alt"></i></a>';
          $button .='&nbsp;&nbsp;';
          
          return $button;  
      })
      ->rawColumns(['action'])

      ->editColumn('created_at', function ($data) {
		    return $data->created_at->format('d-m-Y'); // human readable format
		  })

      ->make(true);
  }

  /**
   * Function name : deleteNotification
   * Parameter : id
   * task : delete notification from database table.. 
   * auther : Manish Silawat
   */    
  public function deleteNotification($id) {
      
    Notification::where('id', $id)->delete();

    return back()->with('success','Notification deleted successfully.');

  } 
  


}

