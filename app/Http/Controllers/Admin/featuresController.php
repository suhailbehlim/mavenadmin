<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\features;
use App\Models\transition;

// use Barryvdh\DomPDF\Facade as PDF;


use App\Models\Notification;


use Yajra\Datatables\Datatables;


use DB;

class featuresController extends Controller
{
   
    public function features_list(){
        $data['active_link'] = 'features'; 
        return view('admin.features.list', $data);
    }


    public function add_features() {
        $data['active_link'] = 'features'; 
        // $data['category'] = DB::table('categories')->where('status', 'Active')->get();

      return view('admin.features.add', $data);
    }

    public function store_features(Request $request) {

        $section=$request->post('section'); 
      $name=$request->post('name');
      $description=$request->post('description');
      $image=$request->file('image');
     
       $images = '';
      if ($image) {
        $destinationPath = 'public/system/partnerList';
        $file_name = time() . "." . $image->getClientOriginalExtension();
        $image->move($destinationPath, $file_name);
        $images= asset('public/system/partnerList/'.$file_name);
      }
     
      $data = [
        'section'   => $section,
        'name'   => $name,
         'description'   => $description,
         'image'   => $images,
         
  
      ];
    
      $adduser =DB::table('features')->insert($data);

        return redirect()->route('admin.features')->with('success','features section added successfully.');
      
      }

    

    public function edit_features($id) {
        $data['active_link'] = 'features'; 
        $data['testoInfo'] = DB::table('features')->where('id', $id)->first(); 
      
        return view('admin.features.edit', $data);
      }
        
    
      public function update_features(Request $request, $id) {
    
       
         $section=$request->post('section'); 
      $name=$request->post('name');
      $description=$request->post('description');
      $image=$request->file('image');
     
      
      $url=$request->post('url');
        $getblog = DB::table('features')->where('id', $id)->select('*')->first();

        if ($image) {
        $destinationPath = 'public/system/partnerList';

          $file_name = time() . "." . $image->getClientOriginalExtension();
          $image->move($destinationPath, $file_name);
          $images= asset('public/system/partnerList/'.$file_name);
        }else{
         $images = isset($getblog) ? $getblog->image : '';
        }
       
        
        $data = [
            'section'   => $section,
        'name'   => $name,
         'description'   => $description,
         'image'   => $images,
    
        ];
        DB::table('features')->where('id', $id)->update($data);

    
        return redirect()->route('admin.features')->with('success','features section updated successfully.');
      }
    
  
      public function delete_features($id) {
          
      DB::table('features')->where('id', $id)->delete();
    
        return back()->with('success','placement section deleted successfully.');
    }
       public function ourprogress() {
        $data['active_link'] = 'our progress'; 
        $data['testoInfo'] = DB::table('progress')->first(); 
      
        return view('admin.ourprogress.edit', $data);
      } 
          public function updateourprogress(Request $request) {
      $image=$request->file('image'); 
           
    
        $getblog = DB::table('progress')->first();

        if ($image) {
        $destinationPath = 'public/system/partnerList';

          $file_name = time() . "." . $image->getClientOriginalExtension();
          $image->move($destinationPath, $file_name);
          $images= asset('public/system/partnerList/'.$file_name);
        }else{
         $images = isset($getblog) ? $getblog->image : '';
        }
        $faq = [];
        $faq['question'] = $request->question;
        $faq['answer'] = $request->answer;
        
        $data = [
            'title'   => $request->title,
            'subtitle'   => $request->subtitle,
            'faq'   => serialize($faq),
            'student_count'   => $request->student_count,
            'courses_count'   => $request->courses_count,
            'years_count'   => $request->years_count,
            'instructors_count'   => $request->instructors_count,
            'satisfaction_count'   => $request->satisfaction_count,
            'hrs_of_video'   => $request->hrs_of_video,
         'image'   => $images,
    
        ];
        DB::table('progress')->where('id', 1)->update($data);

    
        return back()->with('success','features section updated successfully.');
      }

      public function orderList($type){
         if ($type == "order") {
           
            $data['active_link'] = 'orders'; 
           
            $data['info'] = \App\Models\transition::all();
            return view('admin.order.list', $data);
        } 
      }
    }

    