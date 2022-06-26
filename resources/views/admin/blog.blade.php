@extends('layouts.masters')


@section('content')


<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Add Blog</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>

            <li class="breadcrumb-item"><a href="{{ route('admin.blogindex') }}">Blog List</a></li>
            <li class="breadcrumb-item active">Add Blog</li>
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
            <h3 class="card-title">Details</h3>

          </div>
          <div class="card-body">

            <form method="post" action="{{ route('admin.addblog') }}" enctype="multipart/form-data">
              @csrf
                <div class="form-group">
                    <label>Blog Title</label>
                    <input type="text" class="form-control" name="title" placeholder="enter blog title" required>
                  </div>
                  <div class="form-group">
                    <label for="inputStatus">Blog Category<span class="estricCls">*</span></label>
                    <select name="blogcategory" id="blogcategory" class="form-control ">
                      @if($category)
                      @foreach($category as $km)
                      <option value="{{$km->name}}">{{$km->name}}</option>
                      @endforeach
                      @endif
                      
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="type">Type<span class="estricCls">*</span></label>
                    <select name="type" id="type" class="form-control ">
                    
                      <option value="Image">Image</option>                      
                      <option value="Video">Video</option>                      
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="inputName">Thumbnail<span class="estricCls">*</span></label>
                    <input type="file" name="thumbnail" id="thumbnail" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="inputName">Blog Image<span class="estricCls">*</span></label>
                    <input type="file" name="blogimage" id="blogimage" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="inputName">Blog Video<span class="estricCls">*</span></label>
                    <input type="file" name="blogvideo" id="blogvideo" class="form-control">
                  </div>
                <div class="form-group">
                  <label >Blog content</label>
                  <textarea type="text" class="ckeditor form-control" id="exampleInputtext" name="content" placeholder="Enter Blog Content..." cols="30" rows="10"></textarea>
                </div>
                 <div class="form-group">
                      <label >Date</label>
                      <input type="date" class="form-control" id="exampleInputtext" name="date">
                    </div>
                <div class="form-group">
                  <label for="inputStatus">Status<span class="estricCls">*</span></label>
                  <select name="status" id="status" class="form-control custom-select">
                    <option value="Inactive">Active</option>
                    <option value="Active">InActive</option>
                  </select>
                </div>
                <div class="form-group">
                 <input type="submit" name="Save" class="btn btn-success">
                </div>
               

              </form>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
     
    </div>


@stop

