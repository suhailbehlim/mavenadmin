<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;




use Yajra\Datatables\Datatables;


use DB;
class AboutController extends Controller
{
    // public function careerlist(){
    //     $data['active_link'] = 'career_list'; 
    //     return view('admin.career.list', $data);
    // }


    // public function addCareer() {
    //     $data['active_link'] = 'career_list'; 
    //   return view('admin.career.add', $data);
    // }

    // public function storeCareer(Request $request) {

      
    //     Career::create([
    //       'title' => trim($request->post('title')),
    //       'job' => trim( ucfirst($request->post('job'))),
    //       'jobtype' => trim($request->post('jobtype')),
    //       'description' => trim($request->post('description')),
    //       'status' => trim($request->post('status')),

    //     ]);
      
    //     return redirect()->route('admin.careerlist')->with('success','Career added successfully.');
      
    //   }

    //   public function ajaxCareerList() {

    //     return Datatables::of( Career::get())
    //     ->addColumn('action', function($data) {
    //         $data->deleteMsg = 'Are you sure want to delete ?';
            
    //         $button = '<a href="'.route('admin.editCareer', [$data->id]).'" id="'.$data->id.'" class="btn btn-info btn-sm" title="Edit Career"><i class="far fa-edit"></i></a>';
    //         $button .='&nbsp;&nbsp;';
  
    //         $button .='<a href="'.route('admin.deleteCareer', [$data->id]).'" id="'.$data->id.'" class="btn btn-danger btn-sm" onclick="return confirm('."'".$data->deleteMsg."'".');" title="Delete Category" ><i class="fas fa-trash-alt"></i></a>';
    //         $button .='&nbsp;&nbsp;';
            
    // if($data->status == 'Active') {
    //     $iconClass = 'fas fa-lock';
    //     $statusClass = 'btn btn-success btn-sm';
    //     $statusTitle = 'Inactive Blog';
    //     $data->statusMsg = 'Are you sure want to inactivate Blog '.$data->title.' ?';
  
    //   } else {
    //     $iconClass = 'fas fa-lock-open';
    //     $statusClass = 'btn btn-danger btn-sm';
    //     $statusTitle = 'Active Blog';
    //     $data->statusMsg = 'Are you sure want to change status ?';
    //     $data->statusMsg = 'Are you sure want to activate Blog '.$data->title.' ?';
    //   }
  
    //   $button .='<a href="'.route('admin.changeStatusCareer', [$data->id, $data->status]).'" id="'.$data->id.'" class="'.$statusClass.'" onclick="return confirm('."'".$data->statusMsg."'".');" title="'.$statusTitle.'" ><i class="'.$iconClass.'"></i></a>';
    //         return $button;  
    //     })
    //     ->rawColumns(['action'])
  
    //     ->make(true);
    // }

    // public function editCareer($id) {
    //     $data['active_link'] = 'career_list'; 
    //     $data['careerId'] = $id; 
    //     // get country info..
    //     $data['careerInfo'] = Career::where('id', $id)->first(); 
        
    //     return view('admin.career.edit', $data);
    //   }
        
    
    //   /**
    //    * Function name : updateCategory
    //    * Parameter : id { this is user unique id and primary key }, request { this is form request with the help of this we can get all http request }
    //    * task : update Category information. 
    //    * auther : Manish Silawat
    //    */   
    //   public function updateCareer(Request $request, $id) {
    
       
    
    //     Career::where('id', $id)->update([
    //     'title' => trim( ucfirst($request->post('title'))),
    //     'job' => trim( ucfirst($request->post('job'))),
    //     'jobtype' => trim($request->post('jobtype')),
    //     'description' => trim($request->post('description')),
    //     'status' => trim($request->post('status')),
    //     ]);
    
    //     return redirect()->route('admin.careerlist')->with('success','Career updated successfully.');
    //   }
    
    
      
    
    //   /**
    //    * Function name : deleteCategory
    //    * Parameter : id
    //    * task : delete Category information from database table.. 
    //    * auther : Manish Silawat
    //    */    
    //   public function deleteCareer($id) {
          
    //     Career::where('id', $id)->delete();
    
    //     return back()->with('success','Career deleted successfully.');
    
    //   }

    // public function  changeStatusCareer($id,$status){
    //     if($status == 'Inactive') {
    //         $updateField = 'Active';
    //       } else {
    //         $updateField = 'Inactive';
    //       }
        
    //       DB::table('career')->where('id', $id)->update([
    //         'status' => $updateField
    //       ]);
        
    //       return back()->with('success','Career status updated successfully.');
        
        }
        
 
        




