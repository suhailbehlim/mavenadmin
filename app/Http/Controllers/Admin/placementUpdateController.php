<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\placement_update;

// use Barryvdh\DomPDF\Facade as PDF;


use App\Models\Notification;


use Yajra\Datatables\Datatables;


use DB;

class placementUpdateController extends Controller
{
   
    public function placement_update_list(){
        $data['active_link'] = 'placement_update'; 
        return view('admin.placement_update.list', $data);
    }


    public function add_placement_update() {
        $data['active_link'] = 'placement_update'; 
        // $data['category'] = DB::table('categories')->where('status', 'Active')->get();

      return view('admin.placement_update.add', $data);
    }

    public function store_placement_update(Request $request) {

        $name=$request->post('name'); 
      $designation=$request->post('designation');
      $company=$request->post('company');
      // $image=$request->file('image');
     
      //  $images = '';
      // if ($image) {
      //   $destinationPath = 'public/system/placement_update';
      //   $file_name = time() . "." . $image->getClientOriginalExtension();
      //   $image->move($destinationPath, $file_name);
      //   $images= 'system/placement_update/'.$file_name;
      // }
     
      $data = [
        'name'   => $name,
        'designation'   => $designation,
         'company'   => $company,
         // 'image'   => $images,
         
  
      ];
    
      $adduser =DB::table('placement_update')->insert($data);

        return redirect()->route('admin.placement')->with('success','placement section added successfully.');
      
      }

    

    public function edit_placement_update($id) {
        $data['active_link'] = 'placement_update'; 
        $data['testoInfo'] = DB::table('placement_update')->where('id', $id)->first(); 
      
        return view('admin.placement_update.edit', $data);
      }
        
    
      public function update_placement_update(Request $request, $id) {
    
      
       
         $getblog = DB::table('placement_update')->where('id', $id)->select('*')->first();
          $name=$request->post('name'); 
      $designation=$request->post('designation');
      $company=$request->post('company');
      // $image=$request->file('image');
     
      
      // if ($image) {
      //   $destinationPath = 'public/system/placement_update/';
      //   $file_name = time() . "." . $image->getClientOriginalExtension();
      //   $image->move($destinationPath, $file_name);
      //   $images= 'system/placement_update/'.$file_name;
      // }else{
      //    $images = isset($getblog) ? $getblog->image : '';
      //   }
     
      $data = [
        'name'   => $name,
        'designation'   => $designation,
         'company'   => $company,
         // 'image'   => $images,
         
  
      ];
        DB::table('placement_update')->where('id', $id)->update($data);

    
        return back()->with('success','placement section updated successfully.');
      }
    
  
      public function delete_placement_update($id) {
          
      DB::table('placement_update')->where('id', $id)->delete();
    
        return back()->with('success','placement section deleted successfully.');
    }
        
    }
