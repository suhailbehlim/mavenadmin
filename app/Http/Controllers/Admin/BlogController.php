<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\BlogCategory;

use App\Models\Notification;


use Yajra\Datatables\Datatables;


use DB;
class BlogController extends Controller
{
    /**
     * Function name : index
     * Parameter : null
     * task : show all country list
     * auther : Manish Silawat
     */   
    public function blogindex() {

        $data['active_link'] = 'blog';
        return view('admin.bloglist', $data);
    }
    
  
  public function blog(){
    $data['active_link'] = 'blog'; 
    $data['category'] = DB::table('catblog')->where('status', 'Active')->get();
    return view('admin.blog',$data);
  }

public function addblog (Request $request){
  
  $title=$request->post('title');
  $category=$request->post('blogcategory');
  $thumbnail=$request->file('thumbnail');
  $blogimage=$request->file('blogimage');
  $blogvideo=$request->file('blogvideo');
  $blogcontent=$request->post('content');
  $status=$request->post('status');
  $thumb='';
  if ($thumbnail) {
    $destinationPath = 'public/system/blog/';
    $file_name = time() . "." . $thumbnail->getClientOriginalExtension();
    $thumbnail->move($destinationPath, $file_name);
    $thumb=$destinationPath.$file_name;
  }
   $videos = '';
  if ($blogvideo) {
    $destinationPath = 'public/system/blog/';
    $file_name = time() . "." . $blogvideo->getClientOriginalExtension();
    $blogvideo->move($destinationPath, $file_name);
    $videos=$destinationPath.$file_name;
  }
  $images='';
  if ($blogimage) {
    $destinationPath = 'public/system/blog/';
    $file_name = time() . "." . $blogimage->getClientOriginalExtension();
    $blogimage->move($destinationPath, $file_name);
    $images=$destinationPath.$file_name;
  }
  
  
  // $thumbnails = '';
	// 	if ($thumbnail) {
	// 		$destinationPath = 'public/system/courses/';
	// 		$file_name = time() . "." . $thumbnail->getClientOriginalExtension();
	// 		$thumbnail->move($destinationPath, $file_name);
	// 		$thumbnails.=$file_name;
	// 	}
  //   $blogimages = '';
	// 	if ($blogimage) {
	// 		$destinationPath = 'public/system/courses/';
	// 		$file_name = time() . "." . $blogimage->getClientOriginalExtension();
	// 		$blogimage->move($destinationPath, $file_name);
	// 		$blogimages.=$file_name;
	// 	}
  //   $blogvideos = '';
	// 	if ($blogvideo) {
	// 		$destinationPath = 'public/system/courses/';
	// 		$file_name = time() . "." . $blogvideo->getClientOriginalExtension();
	// 		$blogvideo->move($destinationPath, $file_name);
	// 		$blogvideos.=$file_name;
	// 	}
    $data = [
      'title'   => $title,
      'type'   => $request->type,
      'blogcategory'   => $category,
       'thumbnail'   => $thumb,
       'blogimage'   => $images,
       'blogvideo'   => $videos,
       'content'   => $blogcontent,
       'date'   => $request->date,
       'status'  => $status,

    ];
  
		$adduser =DB::table('blog')->insert($data);
    return redirect()->route('admin.blogindex')->with('success','Blog Added successfully.');
  }
  



  public function editblog($id) {
    $data['active_link'] = 'bloglist';
    $data['blogInfo'] = DB::table('blog')->where('id', $id)->first(); 
  $data['category'] = DB::table('catblog')->where('status', 'Active')->get();
    return view('admin.editblog', $data);
  }

  public function updateBlog(Request $request, $id) {
    $title=$request->post('title');
    $category=$request->post('blogcategory');
    $thumbnail=$request->file('thumbnail');
    $blogimage=$request->file('blogimage');
    $blogvideo=$request->file('blogvideo');
    $blogcontent=$request->post('content');
    $status=$request->post('status');

       $getblog = DB::table('blog')->where('id', $id)->select('title','blogcategory','thumbnail','blogimage','blogvideo','content')->first();

      //  $thumbnails = '';
       if ($thumbnail) {
         $destinationPath = 'public/system/blog/';
         $file_name = time() . "." . $thumbnail->getClientOriginalExtension();
         $thumbnail->move($destinationPath, $file_name);
         $thumbnails=$destinationPath.$file_name;
       }else{
        $thumbnails = isset($getblog) ? $getblog->thumbnail : '';
       }

      //  $blogimages = '';
       if ($blogimage) {

         $destinationPath = 'public/system/blog/';
         $file_name = time() . "." . $blogimage->getClientOriginalExtension();
         $blogimage->move($destinationPath, $file_name);
         $blogimages=$destinationPath.$file_name;
       }else{
        $blogimages = isset($getblog) ? $getblog->blogimage : '';
       }
      //  $blogvideos = '';
       if ($blogvideo) {
         $destinationPath = 'public/system/blog/';
         $file_name = time() . "." . $blogvideo->getClientOriginalExtension();
         $blogvideo->move($destinationPath, $file_name);
         $blogvideos=$destinationPath.$file_name;
       }else{
        $blogvideos = isset($getblog) ? $getblog->blogvideo: '';
       }
       $data = [
         'title'   => $title,
         'type'   => $request->type,
         'blogcategory'   => $category,
          'thumbnail'   => $thumbnails,
          'blogimage'   => $blogimages,
          'blogvideo'   => $blogvideos,
          'content'   => $blogcontent,
          'date'   => $request->date,
          'status'  => $status,

          
       ];
       DB::table('blog')->where('id', $id)->update($data);

       return redirect()->route('admin.blogindex')->with('success','  blog updated successfully.');
     
     
  }


public function ajaxBlogList() {

  return Datatables::of( DB::table('blog')->orderBy('id', 'DESC')->get())
  ->addColumn('action', function($data) {
    $data->deleteMsg = 'Are you sure want to delete ?';
    $button = '<a href="'.route('admin.editblog', [$data->id]).'" id="'.$data->id.'" class="btn btn-info btn-sm" title="Edit Blog"><i class="far fa-edit"></i></a>';
    $button .='&nbsp;&nbsp;';
    $button .='<a href="'.route('admin.deleteblog', [$data->id]).'" id="'.$data->id.'" class="btn btn-danger btn-sm" onclick="return confirm('."'".$data->deleteMsg."'".');" title="Delete Blog" ><i class="fas fa-trash-alt"></i></a>';
    $button .='&nbsp;&nbsp;';

    if($data->status == 'Active') {
      $iconClass = 'fas fa-lock';
      $statusClass = 'btn btn-success btn-sm';
      $statusTitle = 'Inactive Blog';
      $data->statusMsg = 'Are you sure want to inactivate Blog '.$data->title.' ?';

    } else {
      $iconClass = 'fas fa-lock-open';
      $statusClass = 'btn btn-danger btn-sm';
      $statusTitle = 'Active Blog';
      $data->statusMsg = 'Are you sure want to change status ?';
      $data->statusMsg = 'Are you sure want to activate Blog '.$data->title.' ?';
    }

    $button .='<a href="'.route('admin.changeStatusblog', [$data->id, $data->status]).'" id="'.$data->id.'" class="'.$statusClass.'" onclick="return confirm('."'".$data->statusMsg."'".');" title="'.$statusTitle.'" ><i class="'.$iconClass.'"></i></a>';
    
    return $button; 
  })->rawColumns(['action'])
  ->make(true);
  // return view('admin.bloglist',$data);
}

public function deleteblog($id) {
      
  DB::table('blog')->where('id', $id)->delete();

  return back()->with('success','blog deleted successfully.');

}

public function changeStatusblog($id, $status) {
  if($status == 'Inactive') {
    $updateField = 'Active';
  } else {
    $updateField = 'Inactive';
  }

  DB::table('blog')->where('id', $id)->update([
    'status' => $updateField
  ]);

  return back()->with('success','blog status updated successfully.');

}







  

  /**
   * Function name : addCategory
   * Parameter : null
   * task : load view for addCategory information. 
   * auther : Manish Silawat
   */   
  public function blogcategoryList() {

    $data['active_link'] = 'Blog_category'; 
    return view('admin.Blogcategory.list', $data);
}
   

  public function addblogCategory() {
    $data['active_link'] = 'Blog_category'; 
  return view('admin.Blogcategory.add', $data);
}
 /**
   * Function name : ajaxCategoryList
   * Parameter : null
   * task : show category list with ajax 
   * auther : Manish Silawat
   */      
  public function ajaxBlogCategoryList() {

    return Datatables::of( BlogCategory::get())
    ->addColumn('action', function($data) {
        $data->deleteMsg = 'Are you sure want to delete ?';
        
        $button = '<a href="'.route('admin.editblogCategory', [$data->id]).'" id="'.$data->id.'" class="btn btn-info btn-sm" title="Edit Category"><i class="far fa-edit"></i></a>';
        $button .='&nbsp;&nbsp;';

        $button .='<a href="'.route('admin.deleteblogCategory', [$data->id]).'" id="'.$data->id.'" class="btn btn-danger btn-sm" onclick="return confirm('."'".$data->deleteMsg."'".');" title="Delete Category" ><i class="fas fa-trash-alt"></i></a>';
        $button .='&nbsp;&nbsp;';
        
        return $button;  
    })
    ->rawColumns(['action'])

    ->make(true);
}


// * Function name : storeCategory
// * Parameter : request { this is form request with the help of this we can get all http request }
// * task : store category information. 
// * auther : Manish Silawat
  
 public function storeblogCategory(Request $request) {

   $request->validate([
    'slug'        => 'required|min:2|unique:categories',
 	'name'        => 'required|min:2|unique:categories',
   ]);

  BlogCategory::create([
   'slug' => trim($request->post('slug')),
 	'name' => trim( ucfirst($request->post('name'))),
 	'status' => trim($request->post('status')),
   ]);

   return redirect()->route('admin.blogcategories')->with('success','Category added successfully.');

 }


  /**
   * Function name : editCategory
   * Parameter : id { this is user unique id and primary key }
   * task : show Category information on view. 
   * auther : Manish Silawat
   */
  public function editblogCategory($id) {
    $data['active_link'] = 'Blog_category'; 
    $data['categoryId'] = $id; 
    // get country info..
    $data['categoryInfo'] = BlogCategory::where('id', $id)->first(); 
    
    return view('admin.Blogcategory.edit', $data);
  }
    

  // /**
  //  * Function name : updateCategory
  //  * Parameter : id { this is user unique id and primary key }, request { this is form request with the help of this we can get all http request }
  //  * task : update Category information. 
  //  * auther : Manish Silawat
  //  */   
  public function updateblogCategory(Request $request, $id) {

    $request->validate([
      'name' => 'required|min:2|'.\Illuminate\Validation\Rule::unique('categories')->ignore($id),
    ]);

    BlogCategory::where('id', $id)->update([
	'name' => trim( ucfirst($request->post('name'))),
  'slug' => trim( ucfirst($request->post('slug'))),

	'status' => trim($request->post('status')),
    ]);

    return redirect()->route('admin.blogcategories')->with('success','Category updated successfully.');
  }


  

  // /**
  //  * Function name : deleteCategory
  //  * Parameter : id
  //  * task : delete Category information from database table.. 
  //  * auther : Manish Silawat
  //  */    
  public function deleteblogCategory($id) {
      
    BlogCategory::where('id', $id)->delete();

    return back()->with('success','Category deleted successfully.');

  }

    

}