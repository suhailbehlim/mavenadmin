@extends('layouts.masters')

@section('title', 'Edit BlogCategory')

@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Category</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>

              <li class="breadcrumb-item"><a href="{{ route('admin.blogcategories') }}">Category List</a></li>
              <li class="breadcrumb-item active">Edit Category</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


        <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">General Details</h3>

              
            </div>
            <div class="card-body">

            	<form method="post" action="{{ route('admin.updateblogCategory', $categoryId) }}" enctype="multipart/form-data">
            		@csrf
                <div class="form-group">
                  <label for="inputName">Slug<span class="estricCls">*</span></label>
                  <input type="text" name="slug" value="{{ $categoryInfo['slug'] }}" id="slug" class="form-control @error('slug') is-invalid @enderror" placeholder="Enter slug"  autocomplete="slug" required autofocus>
  
                  @error('slug')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror  
                </div>
			  <div class="form-group">
                <label for="inputName">Name<span class="estricCls">*</span></label>
                <input type="text" name="name" value="{{ $categoryInfo['name'] }}" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter name"  autocomplete="name" required autofocus>

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
              
			  <div class="form-group">
                <label for="inputStatus">Status<span class="estricCls">*</span></label>
                <select name="status" id="status" class="form-control custom-select">
                  <option <?php if($categoryInfo['status'] == 'Inactive') {
                    echo 'selected="selected"';
                  } ?>  value="Inactive">Inactive</option>
                  <option <?php if($categoryInfo['status'] == 'Active') {
                    echo 'selected="selected"';
                  } ?> value="Active">Active</option>
                </select>
              </div>

              <div class="form-group">
               <input type="submit" name="Update" class="btn btn-success">
              </div>

			</form>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
       
      </div>


    </section>
    <!-- /.content -->

@stop