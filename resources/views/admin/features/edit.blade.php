 @extends('layouts.masters')

@section('title', 'Edit Section')

@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Section</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>

              <li class="breadcrumb-item"><a href="{{ route('admin.testomonialList') }}">Section List</a></li>
              <li class="breadcrumb-item active">Edit Section</li>
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

              <form method="post" action="{{ route('admin.update-features', $testoInfo->id) }}" enctype="multipart/form-data">
                @csrf

              <div class="form-group">
                <label for="section">Section Name<span class="estricCls">*</span></label>
              
               <select name="section" class="form-control">
                <option value="WHY_MAVEN_SILICON_list" @if($testoInfo->section== 'WHY_MAVEN_SILICON_list') selected @endif>WHY MAVEN SILICON</option>
                <option value="What_makes_our_courses_unique" @if($testoInfo->section== 'What_makes_our_courses_unique') selected @endif>What makes our courses unique  ------- corporate-training</option>
                 <option value="What_makes_our_courses_unique_talent_partner 
"  @if($testoInfo->section== 'What_makes_our_courses_unique_talent_partner') selected @endif>What makes our courses unique  -------  talent partner </option>
                <option value="Our_Career_Development_Training"  @if($testoInfo->section== 'Our_Career_Development_Training') selected @endif>Our_Career_Development_Training</option>
                <option value="about"  @if($testoInfo->section== 'about') selected @endif>About</option>
               
              </select>

                @error('section')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
        
              <div class="form-group">
                <label for="name">Name</label>
            
                  <input name="name" id="name" class="form-control custom-select" type="text" value="{{ $testoInfo->name}}" placeholder="Enter name" autocomplete="type"  autofocus>
   
              </div>
             
             

              <div class="form-group">
                <label for="inputName">Image</label>
                <input type="file" name="image"  id="image" class="form-control">
                 <img src="{{$testoInfo->image }}" width="100">
              </div>
             
              <div class="form-group">
                <label for="description">Description</label>
                <textarea type="text" name="description"  id="ckeditor" class="ckeditor form-control @error('description') is-invalid @enderror" placeholder="Enter description"  autocomplete="description"  autofocus >{{ $testoInfo->description}}</textarea>

                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
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


    </section>
    <!-- /.content -->

@stop