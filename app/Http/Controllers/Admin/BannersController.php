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
use App\Models\Usedcars;

use App\Exports\UsersExport;
use DB;
use Hash;

class BannersController extends Controller{ 
    public function index() {
        $data['active_link'] = 'banners'; 
        return view('admin.banners.list', $data);
    }
	
	public function addBanner() {
		$data['active_link'] = 'addBanner'; 
		return view('admin.banners.add', $data);
    }
	
	public function storeBanner(Request $request) {
		$date = date("Y-m-d h:i:s", time());
		$title = $request->post('title');
		$alt = $request->post('alt');
		$status = $request->post('status');
		$desktop_banner = $request->file('desktop_banner');
		$mobile_banner = $request->file('mobile_banner');
				
		$desktopfn = '';
		if($desktop_banner){
			$extension = $desktop_banner->getClientOriginalExtension();
			$desktopfn = time().'.'.$extension;
			$icon_type='img';
			$desktop_banner->move('public/uploads/banners/', $desktopfn);
		}
		$mobilefn = '';
		if($mobile_banner){
			$extension = $mobile_banner->getClientOriginalExtension();
			$mobilefn = time().'.'.$extension;
			$icon_type='img';
			$mobile_banner->move('public/uploads/banners/', $mobilefn);
		}
		
		$ar = [
			'section' => $request->section,
			'title' => $title,
			'alt' => $alt,
			'desktop_banner' => $desktopfn,
			'mobile_banner' => $mobilefn,
			'status' => $status,
			'created_at' => $date,
			'updated_at' => $date
		];
		DB::table('banners')->insert($ar);
		return redirect()->route('admin.banners')->with('success','Banner added successfully.');
    }
	
	public function ajaxBannerList() {
        return Datatables::of(DB::table('banners')->get())
        ->addColumn('action', function($data) {
        	$data->deleteMsg = 'Are you sure want to delete ?';
        	$button = '<a href="'.route('admin.editBanner', [$data->id]).'" id="'.$data->id.'" class="btn btn-info btn-sm" title="Edit Banner"><i class="far fa-edit"></i></a>';
        	$button .='&nbsp;&nbsp;';
        	$button .='<a href="'.route('admin.deleteBanner', [$data->id]).'" id="'.$data->id.'" id="'.$data->id.'" class="btn btn-danger btn-sm" onclick="return confirm('."'".$data->deleteMsg."'".');" title="Delete Banner" ><i class="fas fa-trash-alt"></i></a>';
			$button .='&nbsp;&nbsp;';

			if($data->status == 'Active') {
				$iconClass = 'fas fa-lock';
				$statusClass = 'btn btn-success btn-sm';
				$statusTitle = 'Inactive Banner';
				$data->statusMsg = 'Are you sure want to inactivate Banner ?';
			} else {
				$iconClass = 'fas fa-lock-open';
				$statusClass = 'btn btn-danger btn-sm';
				$statusTitle = 'Active Banner';
				$data->statusMsg = 'Are you sure want to change status ?';
				$data->statusMsg = 'Are you sure want to activate Banner ?';
			}
        	$button .='<a href="'.route('admin.BannerChangeStatus', [$data->id, $data->status]).'" id="'.$data->id.'" class="'.$statusClass.'" onclick="return confirm('."'".$data->statusMsg."'".');" title="'.$statusTitle.'" ><i class="'.$iconClass.'"></i></a>';
        	return $button;  
        })
        ->rawColumns(['action'])
        ->make(true);
	}
	
	public function BannerChangeStatus($id, $status) {
		if($status == 'Inactive') {
			$updateField = 'Active';
		} else {
			$updateField = 'Inactive';
		}
		DB::table('banners')->where('id', $id)->update([
			'status' => $updateField
		]);
		return back()->with('success','banner status updated successfully.');
    }
	
	public function deleteBanner($id) {
		DB::table('banners')->where('id', $id)->delete();
		return back()->with('success','banner deleted successfully.');
    }
	
	public function editBanner($id) {
      $data['active_link'] = 'banners';
     
      $data['banner'] = DB::table('banners')->where('id', $id)->first();
      return view('admin.banners.edit', $data);
    }
	
	public function updateBanner(Request $request, $id) {
		$date = date("Y-m-d h:i:s", time());
		$title = $request->post('title');
		$alt = $request->post('alt');
		$status = $request->post('status');
		$desktop_banner = $request->file('desktop_banner');
		$mobile_banner = $request->file('mobile_banner');
		$select = DB::table('banners')->where('id',$id)->first();

		if($desktop_banner){
			$extension = $desktop_banner->getClientOriginalExtension();
			$desktopfn = time().'.'.$extension;
			$icon_type='img';
			$desktop_banner->move('public/uploads/banners/', $desktopfn);
		}else{
			$desktopfn = $select->desktop_banner;
		}

		if($mobile_banner){
			$extension = $mobile_banner->getClientOriginalExtension();
			$mobilefn = time().'.'.$extension;
			$icon_type='img';
			$mobile_banner->move('public/uploads/banners/', $mobilefn);
		}else{
			$mobilefn = $select->mobile_banner;
		}
		
		$ar = [
			'section' => $request->section,
			'title' => $title,
			'alt' => $alt,
			'desktop_banner' => $desktopfn,
			'mobile_banner' => $mobilefn,
			'status' => $status,
			'updated_at' => $date
		];
		DB::table('banners')->where('id', $id)->update($ar);
		return redirect()->route('admin.banners')->with('success','Banner updated successfully.');
    }
	
    public function exportExcel($type) {
        return \Excel::download(new UsersExport, 'users.'.$type);
    }
}