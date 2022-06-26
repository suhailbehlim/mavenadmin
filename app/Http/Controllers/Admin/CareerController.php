<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Career;
use App\Models\Testomonial;
// use Barryvdh\DomPDF\Facade as PDF;


use App\Models\Notification;


use Yajra\Datatables\Datatables;


use DB;
class CareerController extends Controller
{
    public function careerlist(){
        $data['active_link'] = 'career_list'; 
        return view('admin.career.list', $data);
    }


    public function addCareer() {
        $data['active_link'] = 'career_list'; 
      return view('admin.career.add', $data);
    }

    public function storeCareer(Request $request) {

      
        Career::create([
		'url' => trim($request->post('url')),
          'title' => trim($request->post('title')),
          'opening' => trim($request->post('opening')),
          'job' => trim( ucfirst($request->post('job'))),
          'jobtype' => trim($request->post('jobtype')),
          'location' => trim($request->post('location')),

          'description' => trim($request->post('description')),
          'status' => trim($request->post('status')),

        ]);
      
        return redirect()->route('admin.careerlist')->with('success','Career added successfully.');
      
      }

      public function ajaxCareerList() {

        return Datatables::of( Career::get())
        ->addColumn('action', function($data) {
            $data->deleteMsg = 'Are you sure want to delete ?';
            
            $button = '<a href="'.route('admin.editCareer', [$data->id]).'" id="'.$data->id.'" class="btn btn-info btn-sm" title="Edit Career"><i class="far fa-edit"></i></a>';
            $button .='&nbsp;&nbsp;';
  
            $button .='<a href="'.route('admin.deleteCareer', [$data->id]).'" id="'.$data->id.'" class="btn btn-danger btn-sm" onclick="return confirm('."'".$data->deleteMsg."'".');" title="Delete Career" ><i class="fas fa-trash-alt"></i></a>';
            $button .='&nbsp;&nbsp;';
            
    if($data->status == 'Active') {
        $iconClass = 'fas fa-lock';
        $statusClass = 'btn btn-success btn-sm';
        $statusTitle = 'Inactive Blog';
        $data->statusMsg = 'Are you sure want to inactivate Career '.$data->title.' ?';
  
      } else {
        $iconClass = 'fas fa-lock-open';
        $statusClass = 'btn btn-danger btn-sm';
        $statusTitle = 'Active Blog';
        $data->statusMsg = 'Are you sure want to change status ?';
        $data->statusMsg = 'Are you sure want to activate Career '.$data->title.' ?';
      }
  
      $button .='<a href="'.route('admin.changeStatusCareer', [$data->id, $data->status]).'" id="'.$data->id.'" class="'.$statusClass.'" onclick="return confirm('."'".$data->statusMsg."'".');" title="'.$statusTitle.'" ><i class="'.$iconClass.'"></i></a>';
            return $button;  
        })
        ->rawColumns(['action'])
  
        ->make(true);
    }

    public function editCareer($id) {
        $data['active_link'] = 'career_list'; 
        $data['careerId'] = $id; 
        // get country info..
        $data['careerInfo'] = Career::where('id', $id)->first(); 
        
        return view('admin.career.edit', $data);
      }
        
    
      /**
       * Function name : updateCategory
       * Parameter : id { this is user unique id and primary key }, request { this is form request with the help of this we can get all http request }
       * task : update Category information. 
       * auther : Manish Silawat
       */   
      public function updateCareer(Request $request, $id) {
    
       
    
        Career::where('id', $id)->update([
		
        'title' => trim( ucfirst($request->post('title'))),
        'opening' => trim($request->post('opening')),
        'job' => trim( ucfirst($request->post('job'))),
        'jobtype' => trim($request->post('jobtype')),
        'location' => trim($request->post('location')),

        'description' => trim($request->post('description')),
        'status' => trim($request->post('status')),
        ]);
    
        return redirect()->route('admin.careerlist')->with('success','Career updated successfully.');
      }
    
    
      
    
      /**
       * Function name : deleteCategory
       * Parameter : id
       * task : delete Category information from database table.. 
       * auther : Manish Silawat
       */    
      public function deleteCareer($id) {
          
        Career::where('id', $id)->delete();
    
        return back()->with('success','Career deleted successfully.');
    
      }

    public function  changeStatusCareer($id,$status){
        if($status == 'Inactive') {
            $updateField = 'Active';
          } else {
            $updateField = 'Inactive';
          }
        
          DB::table('career')->where('id', $id)->update([
            'status' => $updateField
          ]);
        
          return back()->with('success','Career status updated successfully.');
        
        }
        
 
        







/////////////////////////////////////
////////////for testomonials/////////



    public function testomonialList(){
        $data['active_link'] = 'testomonialList'; 
        return view('admin.testomonial.list', $data);
    }


    public function addTestomonial() {
        $data['active_link'] = 'testomonialList'; 
        $data['category'] = DB::table('categories')->where('status', 'Active')->get();

      return view('admin.testomonial.add', $data);
    }

    public function storeTestomonial(Request $request) {

      $name=$request->post('name'); 
      $type=$request->post('type');
      $category=$request->post('category');
      $image=$request->file('image');
      $video=$request->file('video');
      $description=$request->post('description');
      $url=$request->post('url');
      $status=$request->post('status');
       $images = '';
      if ($image) {
        $destinationPath = 'public/system/testomonial/';
        $file_name = time() . "." . $image->getClientOriginalExtension();
        $image->move($destinationPath, $file_name);
        $images=$file_name;
      }
      $videos = '';
      if ($video) {
        $destinationPath = 'public/system/testomonial/';
        $file_name = time() . "." . $video->getClientOriginalExtension();
        $video->move($destinationPath, $file_name);
        $videos=$file_name;
      }
      $data = [
        'name'   => $name,
        'type'   => $type,
         'category'   => $category,
         'image'   => $images,
         'video'   => $videos,
         'description'   => $description,
         'url'   => $url,
         'position'  => $request->position,
         'review'  => $request->review,
         'photos'  => $request->photos,
         'positive'  => $request->positive,
         'like'  => $request->like,
         'status'  => $status,
         
  
      ];
    
      $adduser =DB::table('testomonial')->insert($data);


        // Testomonial::create([
        //   'name' => trim($request->post('name')),
        //   'type' =>$request->post('type'),
        //   'category'=>$request->post('category'),
        //   'image' => $request->file('image'),
        //   'video' =>$request->file('video'),

        //   'description' => trim($request->post('description')),
        //   'status' => trim($request->post('status')),

        // ]);

        return redirect()->route('admin.testomonialList')->with('success','Testimonial added successfully.');
      
      }

      public function ajaxtestomonialList() {

        return Datatables::of( DB::table('testomonial')->orderBy('id', 'DESC')->get())
        ->addColumn('action', function($data) {
            $data->deleteMsg = 'Are you sure want to delete ?';
            
            $button = '<a href="'.route('admin.editTestomonial', [$data->id]).'" id="'.$data->id.'" class="btn btn-info btn-sm" title="Edit Testimonial"><i class="far fa-edit"></i></a>';
            $button .='&nbsp;&nbsp;';
  
            $button .='<a href="'.route('admin.deleteTestomonial', [$data->id]).'" id="'.$data->id.'" class="btn btn-danger btn-sm" onclick="return confirm('."'".$data->deleteMsg."'".');" title="Delete Testimonial" ><i class="fas fa-trash-alt"></i></a>';
            $button .='&nbsp;&nbsp;';
            
    if($data->status == 'Active') {
        $iconClass = 'fas fa-lock';
        $statusClass = 'btn btn-success btn-sm';
         
        
        $statusTitle = 'Inactive Testimonial';
        $data->statusMsg = 'Are you sure want to inactivate Testimonial '.$data->name.' ?';
  
      } else {
        $iconClass = 'fas fa-lock-open';
        $statusClass = 'btn btn-danger btn-sm';
        $statusTitle = 'Active Testimonial';
        $data->statusMsg = 'Are you sure want to change status ?';
        $data->statusMsg = 'Are you sure want to activate Testimonial '.$data->name.' ?';
      }
  
      $button .='<a href="'.route('admin.changeStatusTestomonial', [$data->id, $data->status]).'" id="'.$data->id.'" class="'.$statusClass.'" onclick="return confirm('."'".$data->statusMsg."'".');" title="'.$statusTitle.'" ><i class="'.$iconClass.'"></i></a>';
            return $button;  
        })
        ->rawColumns(['action'])
  
        ->make(true);
    }

    public function editTestomonial($id) {
        $data['active_link'] = 'testomonialList'; 
        $data['testoInfo'] = DB::table('testomonial')->where('id', $id)->first(); 
        $data['category'] = DB::table('categories')->where('status', 'Active')->get();
        
        return view('admin.testomonial.edit', $data);
      }
        
    
      /**
       * Function name : updateCategory
       * Parameter : id { this is user unique id and primary key }, request { this is form request with the help of this we can get all http request }
       * task : update Category information. 
       * auther : Manish Silawat
       */   
      public function updateTestomonial(Request $request, $id) {
    
       
        $name=$request->post('name'); 
        $type=$request->post('type');
        $category=$request->post('category');
        $image=$request->file('image');
        $video=$request->file('video');
        $description=$request->post('description');
        $url=$request->post('url');
        $status=$request->post('status');
        $getblog = DB::table('testomonial')->where('id', $id)->select('name','type','category','image','video','description')->first();

        if ($image) {
          $destinationPath = 'public/system/testomonial/';
          $file_name = time() . "." . $image->getClientOriginalExtension();
          $image->move($destinationPath, $file_name);
          $images=$file_name;
        }else{
         $images = isset($getblog) ? $getblog->image : '';
        }
        if ($video) {
          $destinationPath = 'public/system/testomonial/';
          $file_name = time() . "." . $video->getClientOriginalExtension();
          $video->move($destinationPath, $file_name);
          $videos=$file_name;
        }else{
         $videos = isset($getblog) ? $getblog->video: '';
        }
        
        $data = [
          'name'   => $name,
          'type'   => $type,
           'category'   => $category,
           'image'   => $images,
           'video'   => $videos,
           'description'   => $description,
           'url'   => $url,
           'status'  => $status,
           'position'  => $request->position,
         'review'  => $request->review,
         'photos'  => $request->photos,
         'positive'  => $request->positive,
         'like'  => $request->like,
    
        ];
        DB::table('testomonial')->where('id', $id)->update($data);

        // Testomonial::where('id', $id)->update([
        // 'name' => trim( ucfirst($request->post('name'))),
        // 'type' =>$request->post('type'),
        // 'category'=>$request->post('category'),
        // 'image' => $request->file('image'),
        // 'video' => $request->file('video'),

        // 'description' => trim($request->post('description')),
        // 'status' => trim($request->post('status')),
        // ]);
    
        return redirect()->route('admin.testomonialList')->with('success','Testimonial updated successfully.');
      }
    
    
      
    
      /**
       * Function name : deleteCategory
       * Parameter : id
       * task : delete Category information from database table.. 
       * auther : Manish Silawat
       */    
      public function deleteTestomonial($id) {
          
      DB::table('testomonial')->where('id', $id)->delete();
    
        return back()->with('success','Testimonial deleted successfully.');
    
      }

    public function  changeStatusTestomonial($id,$status){
        if($status == 'Inactive') {
            $updateField = 'Active';
          } else {
            $updateField = 'Inactive';
          }
        
          DB::table('testomonial')->where('id', $id)->update([
            'status' => $updateField
          ]);
        
          return back()->with('success','Testimonial status updated successfully.');
        
        }
 
        





//free vlsi list




public function addvlsi() {
  $data['active_link'] = 'freeVLSI'; 
  // $data['category'] = DB::table('categories')->where('status', 'Active')->get();

return view('admin.vlsi.add', $data);
}

public function storevlsi(Request $request) {

$title=$request->post('title'); 
$category=$request->post('category');
$date=$request->post('date');
$video=$request->file('video');
$pdf=$request->file('pdf');

$description=$request->post('description');
$status=$request->post('status');

$videos = '';
if ($video) {
  $destinationPath = 'public/system/testomonial/';
  $file_name = time() . "." . $video->getClientOriginalExtension();
  $video->move($destinationPath, $file_name);
  $videos=$file_name;
}

$pdfs = '';
if ($pdf) {
  $destinationPath = 'public/system/testomonial/';
  $file_name = time() . "." . $pdf->getClientOriginalExtension();
  $pdf->move($destinationPath, $file_name);
  $pdfs=$file_name;
}
$data = [
  'title'   => $title,
   'category'   => $category,
   'date'   => $date,
   'video'   => $videos,
   'pdf'=>$pdfs,
   'description'   => $description,
   'status'  => $status,

];

$adduser =DB::table('vlsi')->insert($data);


  // Testomonial::create([
  //   'name' => trim($request->post('name')),
  //   'type' =>$request->post('type'),
  //   'category'=>$request->post('category'),
  //   'image' => $request->file('image'),
  //   'video' =>$request->file('video'),

  //   'description' => trim($request->post('description')),
  //   'status' => trim($request->post('status')),

  // ]);

  return redirect()->route('admin.vlsiList')->with('success','VLSI Resources added successfully.');

}




public function vlsiList(){
  $data['active_link'] = 'freeVLSI'; 

  return view('admin.vlsi.list', $data);
}
public function ajaxvlsiList() {

  return Datatables::of( DB::table('vlsi')->orderBy('id', 'DESC')->get())
  ->addColumn('action', function($data) {
      $data->deleteMsg = 'Are you sure want to delete ?';
      
      $button = '<a href="'.route('admin.editvlsi', [$data->id]).'" id="'.$data->id.'" class="btn btn-info btn-sm" title="Edit Free VLSI"><i class="far fa-edit"></i></a>';
      $button .='&nbsp;&nbsp;';

      $button .='<a href="'.route('admin.deletevlsi', [$data->id]).'" id="'.$data->id.'" class="btn btn-danger btn-sm" onclick="return confirm('."'".$data->deleteMsg."'".');" title="Delete  FreeVLSI" ><i class="fas fa-trash-alt"></i></a>';
      $button .='&nbsp;&nbsp;';
      
if($data->status == 'Active') {
  $iconClass = 'fas fa-lock';
  $statusClass = 'btn btn-success btn-sm';
   
  
  $statusTitle = 'Inactive VLSI Resources';
  $data->statusMsg = 'Are you sure want to inactivate VLSI Resources '.$data->title.' ?';

} else {
  $iconClass = 'fas fa-lock-open';
  $statusClass = 'btn btn-danger btn-sm';
  $statusTitle = 'Active VLSI Resources';
  $data->statusMsg = 'Are you sure want to change status ?';
  $data->statusMsg = 'Are you sure want to activate VLSI Resources '.$data->title.' ?';
}

$button .='<a href="'.route('admin.changeStatusvlsi', [$data->id, $data->status]).'" id="'.$data->id.'" class="'.$statusClass.'" onclick="return confirm('."'".$data->statusMsg."'".');" title="'.$statusTitle.'" ><i class="'.$iconClass.'"></i></a>';
     
return $button; 
       
  })
  
  ->rawColumns(['action'])

  ->make(true);
}


public function exportpdf($type) {
  return \Pdf::download(new PdfExport, 'vlsi.'.$type);
}
public function editvlsi($id) {
  $data['active_link'] = 'freeVLSI'; 
  $data['testoInfo'] = DB::table('vlsi')->where('id', $id)->first(); 
  // $data['category'] = DB::table('categories')->where('status', 'Active')->get();
  // $data['vlsiId'] = $id; 
  
  return view('admin.vlsi.edit', $data);
}
 





/**
 * Function name : updateCategory
 * Parameter : id { this is user unique id and primary key }, request { this is form request with the help of this we can get all http request }
 * task : update Category information. 
 * auther : Manish Silawat
 */   
public function updatevlsi(Request $request, $id) {

 
  $title=$request->post('title'); 
  $category=$request->post('category');
  $date=$request->post('date');
  $video=$request->file('video');
  $pdf=$request->file('pdf');

  $description=$request->post('description');
  $status=$request->post('status');
  $getvlsi = DB::table('vlsi')->where('id', $id)->select('title','category','date','video','description')->first();


  if ($video) {
    $destinationPath = 'public/system/testomonial/';
    $file_name = time() . "." . $video->getClientOriginalExtension();
    $video->move($destinationPath, $file_name);
    $videos=$file_name;
  }else{
   $videos = isset($getvlsi) ? $getvlsi->video: '';
  }
  
  if ($pdf) {
    $destinationPath = 'public/system/testomonial/';
    $file_name = time() . "." . $pdf->getClientOriginalExtension();
    $pdf->move($destinationPath, $file_name);
    $pdfs=$file_name;
  }else{
   $pdfs = isset($getvlsi) ? $getvlsi->video: '';
  }
  
  $data = [
    'title'   => $title,
    'category'   => $category,
     'date'   => $date,
     'video'   => $videos,
     'pdf'  => $pdfs,
     'description'   => $description,
     'status'  => $status,

  ];
  DB::table('vlsi')->where('id', $id)->update($data);

  // Testomonial::where('id', $id)->update([
  // 'name' => trim( ucfirst($request->post('name'))),
  // 'type' =>$request->post('type'),
  // 'category'=>$request->post('category'),
  // 'image' => $request->file('image'),
  // 'video' => $request->file('video'),

  // 'description' => trim($request->post('description')),
  // 'status' => trim($request->post('status')),
  // ]);

  return redirect()->route('admin.vlsiList')->with('success','VLSI resources updated successfully.');
}




/**
 * Function name : deleteCategory
 * Parameter : id
 * task : delete Category information from database table.. 
 * auther : Manish Silawat
 */    
public function deletevlsi($id) {
    
DB::table('vlsi')->where('id', $id)->delete();

  return back()->with('success','VLSI Resources deleted successfully.');

}

public function  changeStatusvlsi($id,$status){
  if($status == 'Inactive') {
      $updateField = 'Active';
    } else {
      $updateField = 'Inactive';
    }
  
    DB::table('vlsi')->where('id', $id)->update([
      'status' => $updateField
    ]);
  
    return back()->with('success','VLSI Resources status updated successfully.');
  
  }
        
    }
