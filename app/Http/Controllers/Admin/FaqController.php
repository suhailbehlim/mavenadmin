<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Notification;


use Yajra\Datatables\Datatables;


use DB;
class FaqController extends Controller
{
    /**
     * Function name : index
     * Parameter : null
     * task : show all country list
     * auther : Manish Silawat
     */   
    public function index() {

        $data['active_link'] = 'FAQ';
        return view('admin.questions.list', $data);
    }

    
public function addFaq(){
    $data['active_link'] = 'FAQ'; 
    
    return view('admin.questions.add',$data);
  }
  
  public function addquestion(Request $request){
    $question=$request->post('question');
    $answer=$request->post('answer');
  $status=$request->post('status');

    
  
    $data =[
      'question'   => $question,
      'answer'   => $answer,
      'status'  => $status,
  
    ];
    $addquestion =DB::table('faq')->insert($data);
  
    return redirect()->route('admin.faqindex')->with('success','FAQ Added successfully.');  
  }


      
      public function editfaq($id){
        $data['active_link'] = 'Faq list';
        $data['faqInfo'] = DB::table('faq')->where('id', $id)->first(); 
        return view('admin.questions.edit', $data);
      }




      public function updatefaq(Request $request, $id) {
        $question=$request->post('question');
              $answer=$request->post('answer');
              $status=$request->post('status');

          $getfaq = DB::table('faq')->where('id', $id)->select('question','answer',)->first();
      
          

               $data = [
                'question'   => $question,
                'answer'   => $answer,
                'status'  => $status,   
              ];
              DB::table('faq')->where('id', $id)->update($data);
       
              return redirect()->route('admin.faqindex')->with('success','FAQ updated successfully.');
            
            
         
      
      }
      public function deletefaq($id) {
            
        DB::table('faq')->where('id', $id)->delete();
      
        return back()->with('success','FAQ deleted successfully.');
      
      }


   
    public function ajaxFaqlist() {
       return Datatables::of( DB::table('faq')->orderBy('id', 'DESC')->get())
      ->addColumn('action', function($data) {
        $data->deleteMsg = 'Are you sure want to delete ?';
        $button = '<a href="'.route('admin.editfaq', [$data->id]).'" id="'.$data->id.'" class="btn btn-info btn-sm" title="Edit FAQ"><i class="far fa-edit"></i></a>';
        $button .='&nbsp;&nbsp;';
        $button .='<a href="'.route('admin.deletefaq', [$data->id]).'" id="'.$data->id.'" class="btn btn-danger btn-sm" onclick="return confirm('."'".$data->deleteMsg."'".');" title="Delete FAQ" ><i class="fas fa-trash-alt"></i></a>';
        $button .='&nbsp;&nbsp;';
    
  if($data->status == 'Active') {
    $iconClass = 'fas fa-lock';
    $statusClass = 'btn btn-success btn-sm';
    $statusTitle = 'Inactive FAQ';
    $data->statusMsg = 'Are you sure want to inactivate FAQ '.$data->question.' ?';

  } else {
    $iconClass = 'fas fa-lock-open';
    $statusClass = 'btn btn-danger btn-sm';
    $statusTitle = 'Active Blog';
    $data->statusMsg = 'Are you sure want to change status ?';
    $data->statusMsg = 'Are you sure want to activate FAQ '.$data->question.' ?';
  }

  $button.='<a href="'.route('admin.changeStatusfaq', [$data->id, $data->status]).'" id="'.$data->id.'" class="'.$statusClass.'" onclick="return confirm('."'".$data->statusMsg."'".');" title="'.$statusTitle.'" ><i class="'.$iconClass.'"></i></a>';
  return $button;         
      })->rawColumns(['action'])
      ->make(true);
    } 

    
    public function changeStatusfaq($id , $status) {
      if($status == 'Inactive') {
        $updateField = 'Active';
      } else {
        $updateField = 'Inactive';
      }
    
      DB::table('faq')->where('id', $id)->update([
        'status' => $updateField
      ]);
    
      return back()->with('success','FAQ status updated successfully.');
    
    }    
  
}