<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Updates;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{

	public function __construct( Request $request) {
		$this->request = $request;
	}



	public function uploadImageEditor()
	{
	if($this->request->hasFile('upload')) {

			$validator = Validator::make($this->request->all(), [
				'upload' => 'required|mimes:jpg,gif,png,jpe,jpeg|max:10240',
						]);

			if ($validator->fails()) {
 	        return response()->json([
 			        'uploaded' => 0,
							'error' => ['message' => 'max. upload size is 10 mb'],
 			    ]);
 	    } //<-- Validator


        $originName = $this->request->file('upload')->getClientOriginalName();
        $fileName = pathinfo($originName, PATHINFO_FILENAME);
        $extension = $this->request->file('upload')->getClientOriginalExtension();
        $fileName = $fileName.'_'.time().'.'.$extension;

        $this->request->file('upload')->move(public_path('system/editor'), $fileName);

        $CKEditorFuncNum = $this->request->input('CKEditorFuncNum');
        $url = asset('public/system/editor/'.$fileName);
        $msg = 'Image uploaded successfully';
        $response = "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg');</script>";

        //@header('Content-type: text/html; charset=utf-8');
				//echo $response;
				return response()->json([ 'fileName' => $fileName, 'uploaded' => true, 'url' => $url, ]);
    }

	}


}
