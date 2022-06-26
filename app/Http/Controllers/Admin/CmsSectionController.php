<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\cms_section;
use App\Models\Testomonial;
// use Barryvdh\DomPDF\Facade as PDF;


use App\Models\Notification;


use Yajra\Datatables\Datatables;


use DB;

class CmsSectionController extends Controller
{
   
    public function cms_section_list(){
        $data['active_link'] = 'cms_section'; 
        return view('admin.cms_section.list', $data);
    }


    public function add_cms_section() {
        $data['active_link'] = 'cms_section'; 
        // $data['category'] = DB::table('categories')->where('status', 'Active')->get();

      return view('admin.cms_section.add', $data);
    }

    public function store_cms_section(Request $request) {

      $pageName=$request->post('pageName'); 
      $title=$request->post('title');
      $subtitle=$request->post('subtitle');
      // $image=$request->file('image');
     
      $sectionDesc=$request->post('sectionDesc');
      $url=$request->post('url');
       $images = [];
      if ($request->hasFile('image')) {
         foreach ($request->file('image') as $imagefile) {
        $destinationPath = 'public/system/cms_section/';
        $file_name = time() . "." . $imagefile->getClientOriginalExtension();
        $imagefile->move($destinationPath, $file_name);
        $images[]= asset('public/system/cms_section/'.$file_name);
      }
      }
     
      $data = [
        'pageName'   => $pageName,
        'title'   => $title,
         'subtitle'   => $subtitle,
         'sectionDesc'   => $sectionDesc,
         'image'   => serialize($images),
         'url'   => $url,
  
      ];
    
      $adduser =DB::table('cms_pages_section')->insert($data);

        return redirect()->route('admin.cms-section')->with('success','section added successfully.');
      
      }

    

    public function edit_cms_section($id) {

        $data['active_link'] = 'cms_section'; 
        $data['testoInfo'] = cms_section::where('id', $id)->first(); 
      
        return view('admin.cms_section.edit', $data);
      }
        
    
      public function update_cms_section(Request $request, $id) {
    
        $pageName=$request->post('pageName'); 
      $title=$request->post('title');
      $subtitle=$request->post('subtitle');
      $image=$request->file('image');
     
      $sectionDesc=$request->post('sectionDesc');
      $url=$request->post('url');
        $getblog = DB::table('cms_pages_section')->where('id', $id)->select('*')->first();

if ($request->hasFile('image')) {

   $images = [];
         foreach ($request->file('image') as $imagefile) {
       
         
        $destinationPath = 'public/system/cms_section/';
        $file_name = time() . "." . $imagefile->getClientOriginalExtension();
        $imagefile->move($destinationPath, $file_name);
        $images[]= asset('public/system/cms_section/'.$file_name);
      }
      $images = serialize($images);
      }else{
         $images = isset($getblog) ? $getblog->image : '';
        }

       
       
        
        $data = [
           'pageName'   => $pageName,
        'title'   => $title,
         'subtitle'   => $subtitle,
         'sectionDesc'   => $sectionDesc,
         'image'   => $images,
         'url'   => $url,
    
        ];
        DB::table('cms_pages_section')->where('id', $id)->update($data);

    
        return redirect()->route('admin.cms-section')->with('success','section updated successfully.');
      }
    
  
      public function delete_cms_section($id) {
          
      DB::table('cms_pages_section')->where('id', $id)->delete();
    
        return back()->with('success','section deleted successfully.');
    }
        
    }
