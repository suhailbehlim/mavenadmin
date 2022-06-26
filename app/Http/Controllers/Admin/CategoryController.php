<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Yajra\Datatables\Datatables;

use DB;
class CategoryController extends Controller
{


public function categoryList() {

      $data['active_link'] = 'category_list'; 
      return view('admin.category.list', $data);
  }

  /**
   * Function name : ajaxCategoryList
   * Parameter : null
   * task : show category list with ajax 
   * auther : Manish Silawat
   */      
  public function ajaxCategoryList() {

      return Datatables::of( Category::get())
      ->addColumn('action', function($data) {
          $data->deleteMsg = 'Are you sure want to delete ?';
          
          $button = '<a href="'.route('admin.editCategory', [$data->id]).'" id="'.$data->id.'" class="btn btn-info btn-sm" title="Edit Category"><i class="far fa-edit"></i></a>';
          $button .='&nbsp;&nbsp;';

          $button .='<a href="'.route('admin.deleteCategory', [$data->id]).'" id="'.$data->id.'" class="btn btn-danger btn-sm" onclick="return confirm('."'".$data->deleteMsg."'".');" title="Delete Category" ><i class="fas fa-trash-alt"></i></a>';
          $button .='&nbsp;&nbsp;';
          
          return $button;  
      })
      ->rawColumns(['action'])

      ->make(true);
  }
  
  

  /**
   * Function name : addCategory
   * Parameter : null
   * 
   * task : load view for addCategory information. 
   * auther : Manish Silawat
   */      
  public function addCategory() {
    $data['active_link'] = 'category_list'; 
  return view('admin.category.add', $data);
}

/**
* Function name : storeCategory
* Parameter : request { this is form request with the help of this we can get all http request }
* task : store category information. 
* auther : Manish Silawat
*/  
public function storeCategory(Request $request) {

  $request->validate([
    'slug'        => 'required|min:2|unique:categories',
	'name'        => 'required|min:2|unique:categories',
  ]);

  Category::create([
    'slug' => trim($request->post('slug')),
	'name' => trim( ucfirst($request->post('name'))),
	'status' => trim($request->post('status')),
  ]);

  return redirect()->route('admin.categoryList')->with('success','Category added successfully.');

}


  /**
   * Function name : editCategory
   * Parameter : id { this is user unique id and primary key }
   * task : show Category information on view. 
   * auther : Manish Silawat
   */
  public function editCategory($id) {
    $data['active_link'] = 'category_list'; 
    $data['categoryId'] = $id; 
    // get country info..
    $data['categoryInfo'] = Category::where('id', $id)->first(); 
    
    return view('admin.category.edit', $data);
  }
    

  /**
   * Function name : updateCategory
   * Parameter : id { this is user unique id and primary key }, request { this is form request with the help of this we can get all http request }
   * task : update Category information. 
   * auther : Manish Silawat
   */   
  public function updateCategory(Request $request, $id) {

    $request->validate([
      'name' => 'required|min:2|'.\Illuminate\Validation\Rule::unique('categories')->ignore($id),
    ]);

    Category::where('id', $id)->update([
	'name' => trim( ucfirst($request->post('name'))),
	'slug' => trim( ucfirst($request->post('slug'))),

	'status' => trim($request->post('status')),

    ]);

    return redirect()->route('admin.categoryList')->with('success','Category updated successfully.');
  }


  

  /**
   * Function name : deleteCategory
   * Parameter : id
   * task : delete Category information from database table.. 
   * auther : Manish Silawat
   */    
  public function deleteCategory($id) {
      
    Category::where('id', $id)->delete();

    return back()->with('success','Category deleted successfully.');

  }
}