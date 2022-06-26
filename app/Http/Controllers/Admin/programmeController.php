<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\programme;

// use Barryvdh\DomPDF\Facade as PDF;


use App\Models\Notification;


use Yajra\Datatables\Datatables;


use DB;

class programmeController extends Controller
{
   
    public function programme_list(){
        $data['active_link'] = 'programme'; 
        return view('admin.programme.list', $data);
    }


    public function add_programme() {
        $data['active_link'] = 'programme'; 
        // $data['category'] = DB::table('categories')->where('status', 'Active')->get();

      return view('admin.programme.add', $data);
    }

    public function store_programme(Request $request) {

      //  $images = '';
      // if ($image) {
      //   $destinationPath = 'public/system/partnerList';
      //   $file_name = time() . "." . $image->getClientOriginalExtension();
      //   $image->move($destinationPath, $file_name);
      //   $images= asset('system/programme/'.$file_name);
      // }
     
      $data = [
        'title'   => $request->title,
        'subtitle'   => $request->subtitle,
        'list'   => $request->list,
        'description'   => $request->description,
        'url'   => $request->url,   
      ];
    
      $adduser =DB::table('ProgrammeOffer')->insert($data);

        return redirect()->route('admin.programme')->with('success','programme section added successfully.');
      
      }

    

    public function edit_programme($id) {
        $data['active_link'] = 'programme'; 
        $data['testoInfo'] = DB::table('ProgrammeOffer')->where('id', $id)->first(); 
      
        return view('admin.programme.edit', $data);
      }
        
    
      public function update_programme(Request $request, $id) {
    
       
        $getblog = DB::table('ProgrammeOffer')->where('id', $id)->select('*')->first();

        // if ($image) {
        // $destinationPath = 'public/system/partnerList';

        //   $file_name = time() . "." . $image->getClientOriginalExtension();
        //   $image->move($destinationPath, $file_name);
        //   $images= asset('system/programme/'.$file_name);
        // }else{
        //  $images = isset($getblog) ? $getblog->image : '';
        // }
       
        
        $data = [
        'title'   => $request->title,
        'subtitle'   => $request->subtitle,
        'list'   => $request->list,
        'description'   => $request->description,
        'url'   => $request->url,   
      ];
        DB::table('ProgrammeOffer')->where('id', $id)->update($data);

    
        return redirect()->route('admin.programme')->with('success','placement section updated successfully.');
      }
    
  
      public function delete_programme($id) {
          
      DB::table('ProgrammeOffer')->where('id', $id)->delete();
    
        return back()->with('success','placement section deleted successfully.');
    }
        
    }
