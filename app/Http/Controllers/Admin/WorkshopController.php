<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;




use Yajra\Datatables\Datatables;


use DB;
class WorkshopController extends Controller
{
    /**
     * Function name : index
     * Parameter : null
     * task : show all country list
     * auther : Manish Silawat
     */   
    public function workshopindex() {
        $data['active_link'] = 'workshoplist';
        return view('admin.workshop.list', $data);
    }
	
	public function workshopage() {
        $data['active_link'] = 'workshoplist';
		$data['data'] = DB::table('workshop')->where('id',1)->first();
        return view('admin.workshop.edit', $data);
    }
    
	public function workshopUpdate(Request $request) {
      $request->validate([
        'title' => 'required',
      ]);
	  
		$title=$request->post('title');
		$first_black_title=$request->post('first_black_title');
		$first_green_title=$request->post('first_green_title');
		$first_icon = $request->file('first_icon');
        $first_content=$request->post('first_content');
		$learn_content=$request->post('data');
		$first_image = $request->file('first_image');
		
        $second_black_title=$request->post('second_black_title');
		$second_green_title=$request->post('second_green_title');
		$second_icon = $request->file('second_icon');
		$second_content=$request->post('second_content');
		$learn_content2=$request->post('data2');
		$second_image = $request->file('second_image');
		$date = date("Y-m-d H:i:s", time());
		$imgs = DB::table('workshop')->where('id', 1)->select('first_icon','first_image','second_icon','second_image')->first();
		
		if ($first_icon) {
			$destinationPath = 'public/system/global/';
			$file_name = time()."_fi." . $first_icon->getClientOriginalExtension();
			$first_icon->move($destinationPath, $file_name);
			$first_iconi =$file_name;
		}else{
			$first_iconi = isset($imgs) ? $imgs->first_icon : '';
		}

		if ($first_image) {
			$file_name2 = time()."_fim." . $first_image->getClientOriginalExtension();
			$first_image->move('public/system/global/', $file_name2);
			$first_imagei =$file_name2;
		}else{
			$first_imagei = isset($imgs) ? $imgs->first_image : '';
		}

		if ($second_icon) {
			$file_name3 = time() . "_si." . $second_icon->getClientOriginalExtension();
			$second_icon->move('public/system/global/', $file_name3);
			$second_icon2 =$file_name3;
		}else{
			$second_icon2 = isset($imgs) ? $imgs->second_icon : '';
		}

		if ($second_image) {
			$file_name4 = time() . "_sim." . $second_image->getClientOriginalExtension();
			$second_image->move('public/system/global/', $file_name4);
			$second_image2 =$file_name4;
		}else{
			$second_image2 = isset($imgs) ? $imgs->second_image : '';
		}
		$data = [
			'title' => trim($title),
			'first_black_title'   => $first_black_title, 
			'first_green_title'   => trim($first_green_title),
			'first_icon'   => trim($first_iconi),
			'first_content' => $first_content,
			'learn_content' => $learn_content,
			'first_image'    => trim($first_imagei),
			'second_black_title'    => trim($second_black_title),
			'second_green_title'   => $second_green_title,
			'second_icon'   => $second_icon2,
			'second_content'   => $second_content,
			'learn_content2' => $learn_content2,
			'second_image'   => $second_image2,
		];
		$adduser =DB::table('workshop')->where('id',1)->update($data);
		return redirect()->route('admin.workshopage')->with('success','Data successfully.');

    }

public function ajaxworkshopList() {

  return Datatables::of( DB::table('life_banners')->orderBy('id', 'DESC')->get())
  ->addColumn('action', function($data) {
    $data->deleteMsg = 'Are you sure want to delete ?';
    $button = '<a href="'.route('admin.editBanner', [$data->id]).'" id="'.$data->id.'" class="btn btn-info btn-sm" title="Edit banner"><i class="far fa-edit"></i></a>';
    $button .='&nbsp;&nbsp;';
    $button .='<a href="'.route('admin.deleteBanner', [$data->id]).'" id="'.$data->id.'" class="btn btn-danger btn-sm" onclick="return confirm('."'".$data->deleteMsg."'".');" title="Delete banner" ><i class="fas fa-trash-alt"></i></a>';
    $button .='&nbsp;&nbsp;';

    return $button; 
  })->rawColumns(['action'])
  ->make(true);

}
	public function deleteBanner($id) {
      
      DB::table('life_banners')->where('id', $id)->delete();

      return back()->with('success','Banner deleted successfully.');

    }
	public function editBanner($id) {
      $data['active_link'] = 'workshoplist';
      $data['life_banners'] = DB::table('life_banners')->where('id', $id)->first(); 
      return view('admin.workshop.editBanner', $data);
    }
	public function addLifeBanner() {
        $data['active_link'] = 'workshoplist';
        return view('admin.workshop.addBanner', $data);
    }



	public function storeLifeBanners(Request $request) {
      $request->validate([
        'banner' => 'required',
      ]);
	  
		$title=$request->post('title');
		$banner = $request->file('banner');
		$first_iconi = '';
		if ($banner) {
			$destinationPath = 'public/system/global/';
			$file_name = time()."_li." . $banner->getClientOriginalExtension();
			$banner->move($destinationPath, $file_name);
			$first_iconi.=$file_name;
		}
		$data = [
			'title' => trim($title),
			'banner'   => trim($first_iconi),
		];
		$adduser =DB::table('life_banners')->insert($data);
		return redirect()->route('admin.workshopindex')->with('success','Data successfully.');

    }
	public function updateLifeBanners(Request $request) {
      $request->validate([
        'banner' => 'required',
      ]);
	  
		$id=$request->post('id');
		$title=$request->post('title');
		$banner = $request->file('banner');
		$imgs = DB::table('life_banners')->where('id', $id)->select('banner')->first();
		if ($banner) {
			$destinationPath = 'public/system/global/';
			$file_name = time()."_li." . $banner->getClientOriginalExtension();
			$banner->move($destinationPath, $file_name);
			$first_iconi=$file_name;
		}else{
			$first_iconi =isset($imgs) ? $imgs->banner : '';
		}
		$data = [
			'title' => trim($title),
			'banner'   => trim($first_iconi),
		];
		$adduser =DB::table('life_banners')->where('id', $id)->update($data);
		return redirect()->route('admin.workshopindex')->with('success','Data successfully.');

    }


}


  
