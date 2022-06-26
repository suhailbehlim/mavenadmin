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
use App\Models\course_cataloge;

use App\Exports\UsersExport;
use DB;
use Hash;

class CatalogeController extends Controller{ 
    public function index() {
        $data['active_link'] = 'course_cataloge'; 
        $data['data'] = course_cataloge::all();
    
        return view('admin.course_cataloge.list', $data);
    }
	
	public function addcataloge() {
		$data['active_link'] = 'course_cataloge'; 
		return view('admin.course_cataloge.add', $data);
    }
	
	public function storecataloge(Request $request) {
		$date = date("Y-m-d h:i:s", time());
		$title = $request->post('title');
		$categories = $request->post('categories');
		$description = $request->post('description');
		$image = $request->file('image');
		$section = $request->file('section');
				
		$imageUrl = '';
		if($image){
			$extension = $image->getClientOriginalExtension();
			$desktopfn = time().'.'.$extension;
			$icon_type='img';
			$image->move('public/uploads/course_cataloge/', $desktopfn);
			$imageUrl = 'uploads/course_cataloge/'.$desktopfn;
		}
		
		
		$ar = [
			'section' => $request->section,
			'title' => $title,
			'categories' => $categories,
			'image' => $imageUrl,
			'description' => $description,
		];
		DB::table('course_cataloge')->insert($ar);
		return redirect()->route('admin.course_cataloge')->with('success','cataloge added successfully.');
    }
	

	
	
	public function deletecataloge($id) {
		DB::table('course_cataloge')->where('id', $id)->delete();
		return back()->with('success','course cataloge deleted successfully.');
    }
	
	public function editcataloge($id) {
      $data['active_link'] = 'course_cataloge';
     
      $data['banner'] = DB::table('course_cataloge')->where('id', $id)->first();
      return view('admin.course_cataloge.edit', $data);
    }
	
	public function updatecataloge(Request $request, $id) {
	$date = date("Y-m-d h:i:s", time());
		$title = $request->post('title');
		$categories = $request->post('categories');
		$description = $request->post('description');
		$image = $request->file('image');
		$section = $request->file('section');
		$select = DB::table('course_cataloge')->where('id',$id)->first();

		if($image){
			$extension = $image->getClientOriginalExtension();
			$desktopfn = time().'.'.$extension;
			$icon_type='img';
			$image->move('public/uploads/course_cataloge/', $desktopfn);
			$imageUrl = 'uploads/course_cataloge/'.$desktopfn;
		}else{
			$imageUrl = $select->image;
		}

		
		
		$ar = [
			'section' => $request->section,
			'title' => $title,
			'categories' => $categories,
			'image' => $imageUrl,
			'description' => $description,
		];
		DB::table('course_cataloge')->where('id', $id)->update($ar);
		return redirect()->route('admin.course_cataloge')->with('success','Course cataloge updated successfully.');
    }
	
    public function exportExcel($type) {
        return \Excel::download(new UsersExport, 'users.'.$type);
    }
}