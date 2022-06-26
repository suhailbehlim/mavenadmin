 @extends('layouts.masters')

@section('title', 'Add Section')

@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Section</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>

              <li class="breadcrumb-item"><a href="{{ route('admin.testomonialList') }}">Section List</a></li>
              <li class="breadcrumb-item active">Add Section</li>
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

            	<form method="post" action="{{ route('admin.store-cms-section') }}" enctype="multipart/form-data">
            		@csrf

              <div class="form-group">
                <label for="pageName">Page Name<span class="estricCls">*</span></label>
              <select name="pageName" class="form-control">
                <option value="Home">Home</option>
                <option value="placements">Placements</option>
                <option value="univercity">Univercity</option>
                <option value="hire-talent">Hire Talent</option>
                <option value="why-maven-silicon">why maven silicon</option>
                <option value="about">About</option>
                <option value="connect-with-us">connect-with-us</option>
                <option value="our-partners">our-partners</option>
                <option value="corporate-training">corporate-training</option>
                <option value="free_vlsi_resourse">free vlsi resourse</option>
                <option value="free_vlsi_workshop">free vlsi workshop</option>
                <option value="Career">Career</option>
                <option value="testimonial">testimonial</option>
                <option value="traning-calendar">traning-calendar</option>
            
              </select>

                @error('pageName')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
			  
              <div class="form-group">
                <label for="title">Title</label>
            
                  <input name="title" id="title" class="form-control custom-select" type="text" value="{{ old('title') }}" placeholder="Enter title" autocomplete="type"  autofocus>
   
              </div>
              <div class="form-group">
                <label for="subtitle">Subtitle</label>
            
                  <input name="subtitle" id="subtitle" class="form-control custom-select" type="text" value="{{ old('subtitle') }}" placeholder="Enter subtitle" autocomplete="type"  autofocus>
   
              </div>
              
             

              <div class="form-group">
                <label for="inputName">Image</label>
                <input type="file" name="image[]"  id="image" class="form-control" multiple>
              </div>
             
              <div class="form-group">
                <label for="sectionDesc">Description</label>
                 <div id="toolbar-container"></div>
                <textarea type="text" name="sectionDesc"  id="ckeditor" class="ckeditor form-control @error('sectionDesc') is-invalid @enderror" placeholder="Enter description"  autocomplete="description"  autofocus ></textarea>

                @error('sectionDesc')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
              <div class="form-group">
                <label for="url">URL</label>
                <input type="url" name="url"  id="url" class="form-control">
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