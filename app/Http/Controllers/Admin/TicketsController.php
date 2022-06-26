<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

use App\Exports\UsersExport;
use DB;
use Hash;


class TicketsController extends Controller
{ 
    public function index() {
        $data['active_link'] = 'tickets'; 
        return view('admin.tickets.list', $data);
    }
	
	public function ajaxTicketsList() {
        return Datatables::of(DB::table('tickets')->join('users', 'tickets.user_id', '=', 'users.id')->select('tickets.id','tickets.replied','tickets.ticket_id','tickets.user_id','tickets.query','tickets.created_at','users.first_name','users.last_name')->get())
        ->addColumn('action', function($data) {
			$data->deleteMsg = 'Are you sure want to delete ?';
        	$button ='<a href="'.route('admin.deleteTicket', [$data->id]).'" id="'.$data->id.'" id="'.$data->id.'" class="btn btn-danger btn-sm" onclick="return confirm('."'".$data->deleteMsg."'".');" title="Delete Ticket" ><i class="fas fa-trash-alt"></i></a>';
			$button .='&nbsp;&nbsp;';
			
        	$button .='<a href="'.route('admin.viewTicket', [$data->id]).'" id="'.$data->id.'" class="btn btn-success btn-sm" title="" ><i class="fas fa-comment-dots"></i></a>';
        	return $button;  
        })->addColumn('userName', function($row){
			  return $row->first_name.' '.$row->last_name;
		})
		->addColumn('replied', function($row){
			if($row->replied==0){
				$rt = 'Unread (Not replied yet)';
			}else{
				$rt = 'Read (Replied)';
			}
			return $rt;
		})
        ->rawColumns(['action'])
        ->make(true);
	}
	
	public function viewTicket($id) {
		$data['active_link'] = 'tickets';
		$detl = DB::table('tickets')->where('id', $id)->first();
		$usr = DB::table('users')->where('id', $detl->user_id)->select('first_name','last_name')->first();
		$data['username'] = $usr->first_name;
		$data['detail'] = $detl;
		$data['replies'] = DB::table('tickets_reply')->where('ticket_id', $id)->get();
		return view('admin.tickets.show', $data);
    }

	public function deleteTicket($id) {
		DB::table('tickets')->where('id', $id)->delete();
		return back()->with('success','Ticket deleted successfully.');
    }

	public function ticketReply(Request $request) {
		$date = date("Y-m-d h:i:s", time());	
		$ticket_id = $request->post('ticket_id');
		$ar = [
			'ticket_id' => $ticket_id,
			'reply' => trim($request->post('reply')),
			'from' => trim($request->post('from')),
			'to' => trim($request->post('to')),
			'created_at' => $date
		];
		DB::table('tickets')->where('id', $ticket_id)->update([
		  'replied' => 1
		]);
		DB::table('tickets_reply')->insert($ar);
		return redirect()->route('admin.viewTicket', ['id' => $ticket_id])->with('success','Replied successfully.');
    }
	
    public function exportExcel($type) {
        return \Excel::download(new UsersExport, 'users.'.$type);
    }
}