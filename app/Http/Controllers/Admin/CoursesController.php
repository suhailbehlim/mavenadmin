<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;


use App\Models\User;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\CourseDescription;
use App\Models\CourseDescriptionFeatures;
use App\Models\AdmissionProcess;
use App\Models\ScholarshipScheme;
use App\Models\BatchCalendar;
use App\Models\CourseFaq;
use App\Models\WinningDifference;


use App\Exports\UsersExport;

use Hash;
use DB;


class CoursesController extends Controller
{
    public function index() {
        $data['active_link'] = 'courses-list'; 
        return view('admin.courses.list', $data);
    }
	
    public function ajaxCoursesList() {
        return Datatables::of( DB::table('courses')->orderBy('id', 'DESC')->get())
        ->addColumn('description', function($data) {
        	$statusClass = 'btn btn-success btn-sm';
        	return '<a href="'.route('admin.description', [$data->id]).'" id="'.$data->id.'" class="'.$statusClass.'" title="Coourse Description" >Description</a>';
        })->rawColumns(['description'])
        ->addColumn('action', function($data) {

        	$data->deleteMsg = 'Are you sure want to delete ?';
        	$button = '<a href="'.route('admin.editCourse', [$data->id]).'" id="'.$data->id.'" class="btn btn-info btn-sm" title="Edit Course"><i class="far fa-edit"></i></a>';
        	$button .='&nbsp;&nbsp;';
        	$button .='<a href="'.route('admin.deleteCourse', [$data->id]).'" id="'.$data->id.'" class="btn btn-danger btn-sm" onclick="return confirm('."'".$data->deleteMsg."'".');" title="Delete Course" ><i class="fas fa-trash-alt"></i></a>';
			$button .='&nbsp;&nbsp;';

          if($data->status == 'Online') {
            $iconClass = 'fas fa-lock';
            $statusClass = 'btn btn-success btn-sm';
            $statusTitle = 'Offline Course';
            $data->statusMsg = 'Are you sure want to Offline Course '.$data->title.' ?';

          } else {
            $iconClass = 'fas fa-lock-open';
            $statusClass = 'btn btn-danger btn-sm';
            $statusTitle = 'Online Course';
            $data->statusMsg = 'Are you sure want to change status ?';
            $data->statusMsg = 'Are you sure want to Online Course '.$data->title.' ?';
          }

        	$button .='<a href="'.route('admin.changeStatusCourse', [$data->id, $data->status]).'" id="'.$data->id.'" class="'.$statusClass.'" onclick="return confirm('."'".$data->statusMsg."'".');" title="'.$statusTitle.'" ><i class="'.$iconClass.'"></i></a>';
        	
        	return $button;  
        })->rawColumns(['action'])
        ->escapeColumns('description')
        ->make(true);
	  }

	
    public function exportExcel($type) {
        return \Excel::download(new UsersExport, 'users.'.$type);
    }
    
	public function deleteCourse($id) {
      
      DB::table('courses')->where('id', $id)->delete();

      return back()->with('success','Course deleted successfully.');

    }

    public function changeStatusCourse($id, $status) {
      if($status == 'Offline') {
        $updateField = 'Online';
      } else {
        $updateField = 'Offline';
      }

      DB::table('courses')->where('id', $id)->update([
        'status' => $updateField
      ]);

      return back()->with('success','Course status updated successfully.');

    }    
         
    public function addCourse() {
      $data['active_link'] = 'courses-list'; 
	  $data['category'] = DB::table('categories')->get();
      return view('admin.courses.add',$data);
    } 
	public function course_description($id) {
		$data['active_link'] = 'Course - Description'; 
		$data['CourseDescription'] = DB::table('CourseDescription')->where('CourseID',$id)->first();
		$data['courseID'] = $id;
		return view('admin.courses.description',$data);
	  }
	  public function course_description_action($type,$id,$actionId = null) {
		$data['active_link'] = $type; 
		$data['CourseDescription'] = DB::table('CourseDescription')->find($id);
		if($type == 'features'){
		$data['tableData'] =	CourseDescriptionFeatures::where('courseID', $id)->orderBy('Order','DESC')->get();
		if($actionId){
			$data['actionData'] =	CourseDescriptionFeatures::where('id', $actionId)->first();
		}
		}
		elseif($type == 'Admission Process'){
$data['tableData'] =	AdmissionProcess::where('courseID', $id)->orderBy('Order','DESC')->get();
if($actionId){
			$data['actionData'] =	AdmissionProcess::where('id', $actionId)->first();
		}
		}
elseif($type == 'Scholarship Scheme'){
$data['tableData'] =	ScholarshipScheme::where('courseID', $id)->orderBy('Order','DESC')->get();
if($actionId){
			$data['actionData'] =	ScholarshipScheme::where('id', $actionId)->first();
		}
}
elseif($type == 'Batch Calendar'){
$data['tableData'] =	BatchCalendar::where('courseID', $id)->orderBy('Order','DESC')->get();
if($actionId){
			$data['actionData'] =	BatchCalendar::where('id', $actionId)->first();
		}
}
elseif($type == 'Winning Difference'){
$data['tableData'] =	WinningDifference::where('courseID', $id)->orderBy('Order','DESC')->get();
if($actionId){
			$data['actionData'] =	WinningDifference::where('id', $actionId)->first();
		}
}
elseif($type == 'faq'){
$data['tableData'] =	CourseFaq::where('courseID', $id)->orderBy('Order','DESC')->get();
if($actionId){
			$data['actionData'] =	CourseFaq::where('id', $actionId)->first();
		}
}

		$data['courseID'] = $id;
		$data['type'] = $type;
		return view('admin.courses.action',$data);
	  }

	   public function course_description_delete($type,$id) {
		$data['active_link'] = $type; 
		$data['CourseDescription'] = DB::table('CourseDescription')->find($id);
		if($type == 'features'){
		$status=	CourseDescriptionFeatures::destroy($id);
		}
		elseif($type == 'Admission Process'){
$status =	AdmissionProcess::destroy($id);
		}
elseif($type == 'Scholarship Scheme'){
$status =	ScholarshipScheme::destroy($id);
}
elseif($type == 'Batch Calendar'){
$status =	BatchCalendar::destroy($id);
}
elseif($type == 'Winning Difference'){
$status =	WinningDifference::destroy($id);
}
elseif($type == 'faq'){
$status =	CourseFaq::destroy($id);
}

		$data['courseID'] = $id;
		$data['type'] = $type;
		if($status){
	return back()->with('success',$type.' delete successfully.');
}else{
	return back()->with('error','Fail.');
}
	  }

	  
	  public function course_description_action_store($type,$id, Request $request) { 
	  	// dd($request->all());
	  	if($type == 'features'){
	  		
		$request->validate([
		  'title'        => 'required',
		  
		]);

			$status = CourseDescriptionFeatures::updateOrCreate(
			[
			   'id'   => $request->id,
			],
			[
			   'courseID'     => $id,
			   'title'     => $request->title,
			   'primeryList'     => $request->primeryList,
			   'secondaryList'     => $request->secondaryList,
			   'Order'     => $request->Order,
			],
		);

		}
				elseif($type == 'Admission Process'){
$request->validate([
		  'title'        => 'required',
		  'description'             => 'required',
		]);
$image = $request->file('image');
$actionData =	AdmissionProcess::where('id', $id)->first();
if ($actionData) {
	$file = $actionData->icon;
}else{
	$file = '';
}
	
		if ($image) {
			$destinationPath = 'public/system/courses/admission_process/';
			$file_name = time() . "." . $image->getClientOriginalExtension();
			$image->move($destinationPath, $file_name);
			$file=$file_name;
		}
			$status = AdmissionProcess::updateOrCreate(
			[
			   'id'   => $request->id,
			],
			[
			   'courseID'     => $id,
			   'title'     => $request->title,
			   'description'     => $request->description,
			   'image'     => $file,
			   'Order'     => $request->Order,
			],
		);
		}
elseif($type == 'Scholarship Scheme'){

$request->validate([
		  'title'        => 'required',
		  'academic_criteria'             => 'required',
		  'test_score'             => 'required',
		  'scholarship'             => 'required',
		]);

			$status = ScholarshipScheme::updateOrCreate(
			[
			   'id'   => $request->id,
			],
			[
			   'courseID'     => $id,
			   'title'     => $request->title,
			   'academic_criteria'     => $request->academic_criteria,
			   'test_score'     => $request->test_score,
			   'scholarship'     => $request->scholarship,
			   'Order'     => $request->Order,
			],
		);

}
elseif($type == 'Batch Calendar'){
$request->validate([
		  'mode'        => 'required',
		  'Date'             => 'required',
		  'Duration'             => 'required',
		]);

			$status = BatchCalendar::updateOrCreate(
			[
			   'id'   => $request->id,
			],
			[
			   'courseID'     => $id,
			   'mode'     => $request->mode,
			   'Date'     => $request->Date,
			   'Duration'     => $request->Duration,
			   'Order'     => $request->Order,
			],
		);
}
elseif($type == 'Winning Difference'){
$request->validate([
		  'title'        => 'required',
		  // 'icon'             => 'required',
		]);
$image = $request->file('icon');
$actionData =	WinningDifference::where('id', $id)->first();
if ($actionData) {
	$file = $actionData->icon;
}else{
	$file = '';
}
		
		if ($image) {
			$destinationPath = 'public/system/courses/Winning_Difference/';
			$file_name = time() . "." . $image->getClientOriginalExtension();
			$image->move($destinationPath, $file_name);
			$file=$file_name;
		}
			$status = WinningDifference::updateOrCreate(
			[
			   'id'   => $request->id,
			],
			[
			   'courseID'     => $id,
			   'title'     => $request->title,
			   'icon'     => $file,
			   'Order'     => $request->Order,
			],
		);
}
elseif($type == 'faq'){
$request->validate([
		  'question'        => 'required',
		  'answer'             => 'required',
		]);


	
			$status = CourseFaq::updateOrCreate(
			[
			   'id'   => $request->id,
			],
			[
			   'courseID'     => $id,
			   'question'     => $request->question,
			   'answer'     => $request->answer,
			   'Order'     => $request->Order,
			],
		);
}
		if($status){
			return redirect()->route('admin.courses-description-action',['type'=>$type,'id'=>$id])->with('success',$type.' added successfully.');
	// return back()->with('success',$type.' added successfully.');
}else{
	return back()->with('error','Fail.');
}
		
	}
		public function storedescription(Request $request) { 
		// $request->validate([
		//   'courseID'        => 'required',
		//   'courseFeatures'             => 'required',
		//   'whatWeLearn'          => 'required',
		//   'courseDetails' => 'required',
		//   'courseDetailsFaqquestion' => 'required',
		//   'courseDetailsFaqanswer' => 'required',
  
		// ]);
			$CourseDescription = DB::table('CourseDescription')->find($request->courseID);
		$courseDetailsFaq = [];
		$courseDetailsFaq['courseDetailsFaqquestion'] = $request->courseDetailsFaqquestion;
		$courseDetailsFaq['courseDetailsFaqanswer'] = $request->courseDetailsFaqanswer;
$whatWeLearnImageFile = $request->file('whatWeLearnImage');
if($CourseDescription){
$whatWeLearnImage = $CourseDescription->whatWeLearnImage;
$courseDetailsImage = $CourseDescription->courseDetailsImage;
$placementImage = $CourseDescription->placementImage;
}else{
	$whatWeLearnImage = '';
	$courseDetailsImage = '';
	$placementImage = '';
}
		
		if ($whatWeLearnImageFile) {
			$destinationPath = 'public/system/courses/whatWeLearnImage/';
			$file_name = time() . "." . $whatWeLearnImageFile->getClientOriginalExtension();
			$whatWeLearnImageFile->move($destinationPath, $file_name);
			$whatWeLearnImage=$file_name;
		}
		$courseDetailsImageFile = $request->file('courseDetailsImage');
		
		if ($courseDetailsImageFile) {
			$destinationPath = 'public/system/courses/courseDetailsImage/';
			$file_name = time() . "." . $courseDetailsImageFile->getClientOriginalExtension();
			$courseDetailsImageFile->move($destinationPath, $file_name);
			$courseDetailsImage=$file_name;
		}

$placementImageFile = $request->file('placementImage');
		
		if ($placementImageFile) {
			$destinationPath = 'public/system/courses/placementImage/';
			$file_name = time() . "." . $placementImageFile->getClientOriginalExtension();
			$placementImageFile->move($destinationPath, $file_name);
			$placementImage=$file_name;
		}
$faq = [];
        $faq['question'] = $request->question;
        $faq['answer'] = $request->answer;
		$status = CourseDescription::updateOrCreate(
			[
			   'courseID'   => $request->courseID,
			],
			[
			   'courseFeatures'     => $request->courseFeatures,
			   'whatWeLearn'     => $request->whatWeLearn,
			   'courseDetails'     => $request->courseDetails,
			   'whatWeLearnImage'     => $whatWeLearnImage,
			   'courseDetailsImage'     => $courseDetailsImage,
			   'courseDetailsFaq'     => serialize($courseDetailsFaq),
			   'course_features_list'     => $request->course_features_list,
			   'admission_process_type'     => $request->admission_process_type,
			   'admission_process_subtitle'     => $request->admission_process_subtitle,
			   'placement'     => $request->placement,
			   'scholarship'     => $request->scholarship,
			   'fees'     => $request->fees,
			   'faq'   => serialize($faq),
			   'placementImage'     => $placementImage,
			],
		);
if($status){
	return back()->with('success','Course added successfully.');
}else{
	return back()->with('error','Fail.');
}
		
		 
  
	  }

    public function storeCourse(Request $request) {
      $request->validate([
        'course_type'        => 'required|min:2',
        'category'             => 'required',
        'title'          => 'required',

      ]);
	  $batchdate=$request->post('batchdate');
	  $batchdate1=$request->post('batchdate1');
	  $batchdate2=$request->post('batchdate2');

	  $nextbatch=$request->post('nextbatch');
	  $duration=$request->post('duration');

		$course_type=$request->post('course_type');
		$category=$request->post('category');
		// $level=$request->post('level');
		$languages=$request->post('languages');
        $title=$request->post('title');
		$timing=$request->post('timing');
		$url=$request->post('url');
        $requirements=$request->post('requirements');
		$short_description=$request->post('short_description');
		$full_description=$request->post('full_description');
		$subscription=$request->post('subscription');
		$price=$request->post('price');
		$batch=$request->post('batch');
		$offer=$request->post('offer');
		$thumbnail = $request->file('thumbnail');
		$main_image = $request->file('main_image');
		$shortvideo = $request->file('shorts');
		$fullvideo = $request->file('fullvideo');
		$status=$request->post('status');
		$date = date("Y-m-d H:i:s", time());
		$thumb = '';
		if ($thumbnail) {
			$destinationPath = 'public/system/courses/';
			$file_name = time() . "." . $thumbnail->getClientOriginalExtension();
			$thumbnail->move($destinationPath, $file_name);
			$thumb.=$file_name;
		}
		$mainThumb = '';
		if ($main_image) {
			$destinationPath = 'public/system/courses/';
			$file_name = time() . "." . $main_image->getClientOriginalExtension();
			$main_image->move($destinationPath, $file_name);
			$mainThumb.=$file_name;
		}
		$shortvideo='';
		if ($shortvideo) {
			$destinationPath = 'public/system/courses/';
			$file_name = time() . "." . $shortvideo->getClientOriginalExtension();
			$shortvideo->move($destinationPath, $file_name);
			$shortvideo.=$file_name;
		}
		$fullvideo = '';
		if ($fullvideo) {
			$destinationPath = 'public/system/courses/';
			$file_name = time() . "." . $fullvideo->getClientOriginalExtension();
			$fullvideo->move($destinationPath, $file_name);
			$fullvideo.=$file_name;
		}
		$data = [
			'course_type' => trim($course_type),
			'url' => $url,
			'category'   => $category, 
			// 'level'      => trim($level),
			'languages'   => trim($languages),
			'title'   => trim($title),
			'batch' => $batch,
			'timing' => $timing,
			'requirements'    => trim($requirements),
			'short_description'    => trim($short_description),
			'full_description'   => $full_description,
			'subscription'   => $subscription,
			'price'   => $price,
			'offer' => $offer,
			'thumbnail'   => $thumb,
			'main_image'   => $mainThumb,
			'shorts'   => $shortvideo,
			'fullvideo' => $fullvideo,
			'status'  => $status,
			'nextbatch' =>$nextbatch,
			'duration' =>$duration,
			'batchdate'=>$batchdate,
			'batchdate1'=>$batchdate1,
			'batchdate2'=>$batchdate2,

			'created_at'  => $date,
			'updated_at'  => $date,
		];
		$adduser =DB::table('courses')->insert($data);
		$id = DB::getPdo()->lastInsertId();

		DB::table('courses')->where('id', $id)->update([
			'course_id'  => 'UN0000'.$id
		]);
		return redirect()->route('admin.courses')->with('success','Course added successfully.');

    }

    public function editCourse($id) {
      $data['active_link'] = 'courses-edit';
      $data['courseInfo'] = DB::table('courses')->where('id', $id)->first(); 
	  $data['category'] = DB::table('categories')->where('status', 'Active')->get();
      return view('admin.courses.edit', $data);
    }
 
    public function updateCourse(Request $request, $id) {

      $request->validate([
        'course_type'        => 'required|min:2',
        'category'             => 'required',
        'title'          => 'required',

      ]);
	  $batchdate=$request->post('batchdate');
	  $nextbatch=$request->post('nextbatch');
	  $duration=$request->post('duration');
	  $url = $request->post('url');
		$course_type=$request->post('course_type');
		$category=$request->post('category');
		// $level=$request->post('level');
		$languages=$request->post('languages');
        $title=$request->post('title');
		$batch=$request->post('batch');
		$timing=$request->post('timing');
        $requirements=$request->post('requirements');
		$short_description=$request->post('short_description');
		$full_description=$request->post('full_description');
		$subscription=$request->post('subscription');
		$price=$request->post('price');
		$offer=$request->post('offer');
		$thumbnail = $request->file('thumbnail');
		$shortvideo = $request->file('shorts');
		$fullvideo = $request->file('fullvideo');
		$main_image = $request->file('main_image');
		$status=$request->post('status');
		$date = date("Y-m-d H:i:s", time());
		$getcourse = DB::table('courses')->where('id', $id)->select('thumbnail','main_image','shorts','fullvideo')->first();
		
		if ($thumbnail) {
			$destinationPath = 'public/system/courses/';
			$file_name = time() . "." . $thumbnail->getClientOriginalExtension();
			$thumbnail->move($destinationPath, $file_name);
			$thumb =$file_name;
		}else{
			$thumb = isset($getcourse) ? $getcourse->thumbnail : '';
		}
		if ($main_image) {
			$destinationPath = 'public/system/courses/';
			$file_name = time() . "." . $main_image->getClientOriginalExtension();
			$main_image->move($destinationPath, $file_name);
			$mainThumb=$file_name;
		}else{
			$mainThumb = isset($getcourse) ? $getcourse->main_image : '';
		}
		if ($shortvideo) {
			$destinationPath = 'public/system/courses/';
			$file_name = time() . "." . $shortvideo->getClientOriginalExtension();
			$shortvideo->move($destinationPath, $file_name);
			$shorts =$file_name;
		}else{
			$shorts = isset($getcourse) ? $getcourse->shorts : '';
		}
		if ($fullvideo) {
			$destinationPath = 'public/system/courses/';
			$file_name = time() . "." . $fullvideo->getClientOriginalExtension();
			$fullvideo->move($destinationPath, $file_name);
			$fullvideos=$file_name;
		}else{
			$fullvideos = isset($getcourse) ? $getcourse->fullvideo : '';
		}
		
		$data = [
			'nextbatch'=>$nextbatch,
			'duration'=>$duration,
			'batchdate'=>$batchdate,
			'url' => $url,
			'course_type' => trim($course_type),
			'category'   => $category, 
			// 'level'      => trim($level),
			'languages'   => trim($languages),
			'title'   => trim($title),
			'requirements'    => trim($requirements),
			'short_description'    => trim($short_description),
			'full_description'   => $full_description,
			'subscription'   => $subscription,
			'price'   => $price,
			'timing'  => $timing,
			'batch'   => $batch,
			'offer'  => $offer,
			'thumbnail'   => $thumb,
			'shorts'   => $shorts,
			'fullvideo' => $fullvideos,
			'main_image'   => $mainThumb,
			'status'  => $status,
			'created_at'  => $date,
			'updated_at'  => $date,
		];
		DB::table('courses')->where('id', $id)->update($data);
  
      return redirect()->route('admin.courses')->with('success','Course updated successfully.');
    }
}




