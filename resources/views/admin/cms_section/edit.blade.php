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

              <form method="post" action="{{ route('admin.update-cms-section', $testoInfo->id) }}" enctype="multipart/form-data">
                @csrf

              <div class="form-group">
                <label for="pageName">Page Name<span class="estricCls">*</span></label>
              <select name="pageName" class="form-control">
                 <option value="Home" @if($testoInfo->pageName== 'Home') selected @endif>Home</option>
                <option value="placements" @if($testoInfo->pageName== 'placements') selected @endif>Placements</option>
                <option value="univercity" @if($testoInfo->pageName== 'univercity') selected @endif>Univercity</option>
                <option value="hire-talent" @if($testoInfo->pageName== 'hire-talent') selected @endif>Hire Talent</option>
                 <option value="why-maven-silicon" @if($testoInfo->pageName== 'why-maven-silicon') selected @endif>why maven silicon</option>
                 <option value="about" @if($testoInfo->pageName== 'about') selected @endif>About</option>
                  <option value="connect-with-us" @if($testoInfo->pageName== 'connect-with-us') selected @endif>connect-with-us</option>
                   <option value="our-partners" @if($testoInfo->pageName== 'our-partners') selected @endif>Our Partners</option>
                   <option value="corporate-training" @if($testoInfo->pageName== 'corporate-training') selected @endif>Corporate Training</option>
                   <option value="free_vlsi_resourse" @if($testoInfo->pageName== 'free_vlsi_resourse') selected @endif>free vlsi resourse</option>
                <option value="free_vlsi_workshop" @if($testoInfo->pageName== 'free_vlsi_workshop') selected @endif>free vlsi workshop</option>
                <option value="Career" @if($testoInfo->pageName== 'Career') selected @endif>Career</option>
                <option value="testimonial" @if($testoInfo->pageName== 'testimonial') selected @endif>testimonial</option>
                <option value="traning-calendar" @if($testoInfo->pageName== 'traning-calendar') selected @endif>traning-calendar</option>
              </select>

                @error('pageName')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
        
              <div class="form-group">
                <label for="title">Title</label>
            
                  <input name="title" id="title" class="form-control custom-select" type="text" value="{{ $testoInfo->title}}" placeholder="Enter title" autocomplete="type"  autofocus>
   
              </div>
              <div class="form-group">
                <label for="subtitle">Subtitle</label>
            
                  <input name="subtitle" id="subtitle" class="form-control custom-select" type="text" value="{{ $testoInfo->subtitle}}" placeholder="Enter subtitle" autocomplete="type"  autofocus>
   
              </div>
             
             

              <div class="form-group">
                <label for="inputName">Image</label>
                <input type="file" name="image[]"  id="image" class="form-control">
              

          @if(isset($testoInfo->image))

    
              <img src="{{$testoInfo->image[0]}}">
           @endif
              </div>
             
              <div class="form-group">
                <label for="sectionDesc">Description</label>
                <textarea type="text" name="sectionDesc"  id="ckeditor" class="ckeditor form-control @error('sectionDesc') is-invalid @enderror" placeholder="Enter description"  autocomplete="description"  autofocus >{{ $testoInfo->sectionDesc}}</textarea>

                @error('sectionDesc')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
              <div class="form-group">
                <label for="url">URL</label>
                <input type="url" name="url" value="{{ $testoInfo->url}}" id="url" class="form-control">
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


    </section>
    <!-- /.content -->

@stop