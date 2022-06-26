<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

use App\Exports\UsersExport;
use DB;
use Hash;


class CommentController extends Controller
{
    public function index($id) {
        $data['active_link'] = 'comments';
		$data['carname'] = DB::table('cars')->where('id',$id)->select('registration_number')->first();
		$data['details'] = $id;
        return view('admin.comments.list', $data);
    }
	
    public function ajaxCommentsList($id) {
        return Datatables::of(DB::table('comments')->where('car_id',$id)->join('users', 'comments.user_id', '=', 'users.id')->select('comments.id','comments.car_type','comments.car_id','comments.user_id','comments.post_comment','comments.status','comments.created_at','users.first_name','users.last_name')->get())
        ->addColumn('action', function($data) {
        	$data->deleteMsg = 'Are you sure want to delete ?';
        	$button ='<a href="'.route('admin.deleteComment', [$data->id]).'" id="'.$data->id.'" id="'.$data->id.'" class="btn btn-danger btn-sm" onclick="return confirm('."'".$data->deleteMsg."'".');" title="Delete Comment" ><i class="fas fa-trash-alt"></i></a>';
			$button .='&nbsp;&nbsp;';
			if($data->status == 'Active') {
				$iconClass = 'fas fa-lock';
				$statusClass = 'btn btn-success btn-sm';
				$statusTitle = 'Inactive Comment';
				$data->statusMsg = 'Are you sure want to inactivate Comment ?';
			} else {
				$iconClass = 'fas fa-lock-open';
				$statusClass = 'btn btn-danger btn-sm';
				$statusTitle = 'Active Comment';
				$data->statusMsg = 'Are you sure want to change status ?';
				$data->statusMsg = 'Are you sure want to activate Comment ?';
			}
			$button .='<a href="'.route('admin.CommentChangeStatus', [$data->id, $data->status]).'" id="'.$data->id.'" class="'.$statusClass.'" onclick="return confirm('."'".$data->statusMsg."'".');" title="'.$statusTitle.'" ><i class="'.$iconClass.'"></i></a>';
        	return $button;  
        })->addColumn('userName', function($row){
			  return $row->first_name.' '.$row->last_name;
		})
        ->rawColumns(['action'])
        ->make(true);
	}
	
	public function deleteComment($id) {
		DB::table('comments')->where('id', $id)->delete();
		return back()->with('success','Comment deleted successfully.');
    }

	public function CommentChangeStatus($id, $status) {
		if($status == 'Inactive') {
			$updateField = 'Active';
		} else {
			$updateField = 'Inactive';
		}
		DB::table('comments')->where('id', $id)->update([
			'status' => $updateField
		]);
		return back()->with('success','Comment status updated successfully.');
    }
	
}