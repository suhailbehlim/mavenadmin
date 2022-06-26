@extends('layouts.masters')

@section('title', 'Edit Blog')

@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Blog</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>

              <li class="breadcrumb-item"><a href="{{ route('admin.blog') }}"> Blog List</a></li>
              <li class="breadcrumb-item active">Edit Blog</li>
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
    
                <form method="post" action="{{ route('admin.updateblog',$blogInfo->id) }}" enctype="multipart/form-data">
                  @csrf
                    <div class="form-group">
                        <label>Blog Title</label>
                        <input type="text" class="form-control" name="title" value="{{ $blogInfo->title}}" placeholder="enter blog title" required>
                      </div>
                      <div class="form-group">
                        <label for="inputStatus">Blog Category<span class="estricCls">*</span></label>
                        <select name="blogcategory" id="blogcategory" class="form-control" value="{{$blogInfo->blogcategory}}">
                        @if($category)
                        @foreach($category as $km)
                        <option value="{{$km->name}}" @if($blogInfo->blogcategory==$km->id) selected @endif>{{$km->name}}</option>
                        @endforeach
                        @endif
                        </select>
                  
                      </div>
                      <div class="form-group">
                    <label for="type">Type<span class="estricCls">*</span></label>
                    <select name="type" id="type" class="form-control ">
                    
                      <option value="Image" @if($blogInfo->type== 'Image') selected @endif>Image</option>                      
                      <option value="Video" @if($blogInfo->type== 'Video') selected @endif>Video</option>                      
                    </select>
                  </div>
                      <div class="form-group">
                        <label for="inputName">Thumbnail<span class="estricCls">*</span></label>
                        <input type="file" name="thumbnail" id="thumbnail" class="form-control" >
                        <img src="{{ URL::to('/') }}/<?php echo $blogInfo->thumbnail; ?>" width="100">

                      </div>
                      <div class="form-group">
                        <label for="inputName">Blog Image<span class="estricCls">*</span></label>
                        <input type="file" name="blogimage" id="blogimage" class="form-control">
                        <img src="{{ URL::to('/') }}/<?php echo $blogInfo->blogimage; ?>" width="100">

                      </div>
                      <div class="form-group">
                        <label for="inputName">Blog Video<span class="estricCls">*</span></label>
                        <input type="file" name="blogvideo" id="blogvideo" class="form-control" >
                        <video src="{{ URL::to('/public') }}/system/courses/<?php echo $blogInfo->blogvideo; ?>" width="100">

                      </div>
                    <div class="form-group">
                      <label >Blog content</label>
                      <textarea type="text" class="form-control" id="exampleInputtext" name="content" cols="30" rows="10" >{{$blogInfo->content}}</textarea>
                    </div>
                     <div class="form-group">
                      <label >Date</label>
                      <input type="date" value="{{date('Y-m-d', strtotime($blogInfo->date))}}" class="form-control" id="exampleInputtext" name="date">
                    </div>
                  	
				<div class="form-group">
          <label for="inputStatus">Status<span class="estricCls">*</span></label>
          <select name="status" id="status" class="form-control custom-select">
            <option <?php if($blogInfo->status == 'Inactive') {
              echo 'selected="selected"';
            } ?>  value="Inactive">Inactive</option>
            <option <?php if($blogInfo->status == 'Active') {
              echo 'selected="selected"';
            } ?> value="Active">Active</option>
          </select>
        </div>
        <div class="form-group">
  <input type="hidden" name="id" value="{{$blogInfo->id}}" id="id">
         <input type="submit" name="Update" class="btn btn-success">
        </div>
                    
                  </form>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
         
        </div>
    
    
    @stop
    