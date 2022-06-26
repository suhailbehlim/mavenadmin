<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\partner_section;

// use Barryvdh\DomPDF\Facade as PDF;


use App\Models\Notification;


use Yajra\Datatables\Datatables;


use DB;

class PartnersSectionController extends Controller
{
   
    public function partner_list(){
        $data['active_link'] = 'partnerList'; 
        return view('admin.partner.list', $data);
    }


    public function add_partner() {
        $data['active_link'] = 'partnerList'; 
        // $data['category'] = DB::table('categories')->where('status', 'Active')->get();

      return view('admin.partner.add', $data);
    }

    public function store_partner(Request $request) {

        $sectionTitle=$request->post('sectionTitle'); 
      $title=$request->post('title');
      $description=$request->post('description');
      $image=$request->file('image');
      $url=$request->post('url');
       $images = '';
      if ($image) {
        $destinationPath = 'public/system/partnerList/';
        $file_name = time() . "." . $image->getClientOriginalExtension();
        $image->move($destinationPath, $file_name);
        $images= 'system/partnerList/'.$file_name;
      }
     
      $data = [
        'sectionTitle'   => $sectionTitle,
        'title'   => $title,
         'description'   => $description,
         'image'   => $images,
         'url'   => $url,
  
      ];
    
      $adduser =DB::table('partner_section')->insert($data);

        return redirect()->route('admin.partner')->with('success','Partner added successfully.');
      
      }

    

    public function edit_partner($id) {
        $data['active_link'] = 'partnerList'; 
        $data['testoInfo'] = DB::table('partner_section')->where('id', $id)->first(); 
      
        return view('admin.partner.edit', $data);
      }
        
    
      public function update_partner(Request $request, $id) {
    
       
        $sectionTitle=$request->post('sectionTitle'); 
      $title=$request->post('title');
      $description=$request->post('description');
      $image=$request->file('image');
     
      
      $url=$request->post('url');
        $getblog = DB::table('partner_section')->where('id', $id)->select('*')->first();

        if ($image) {
          $destinationPath = 'public/system/partnerList/';
          $file_name = time() . "." . $image->getClientOriginalExtension();
          $image->move($destinationPath, $file_name);
          $images= 'system/partnerList/'.$file_name;
        }else{
         $images = isset($getblog) ? $getblog->image : '';
        }
       
        
        $data = [
           'sectionTitle'   => $sectionTitle,
        'title'   => $title,
         'description'   => $description,
         'image'   => $images,
         'url'   => $url,
    
        ];
        DB::table('partner_section')->where('id', $id)->update($data);

    
        return redirect()->route('admin.partner')->with('success','partner updated successfully.');
      }
    
  
      public function delete_partner($id) {
          
      DB::table('partner_section')->where('id', $id)->delete();
    
        return back()->with('success','Partner deleted successfully.');
    }
        
    }
