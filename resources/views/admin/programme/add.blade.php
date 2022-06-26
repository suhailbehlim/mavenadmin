 @extends('layouts.masters')

@section('title', 'Add Section')

@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Feature</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>

              <li class="breadcrumb-item"><a href="{{ route('admin.programme') }}">Feature List</a></li>
              <li class="breadcrumb-item active">Add programme</li>
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

            	<form method="post" action="{{ route('admin.store-programme') }}" enctype="multipart/form-data">
            		@csrf

              <!-- <div class="form-group">
                <label for="section">Section<span class="estricCls">*</span></label>
              <select name="section" class="form-control">
                <option value="WHY_MAVEN_SILICON_list">WHY MAVEN SILICON</option>
               
              </select>

                @error('section')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div> -->
			  
              <div class="form-group">
                <label for="title">Title</label>
            
                  <input name="title" id="title" class="form-control custom-select" type="text" value="{{ old('title') }}" placeholder="Enter title" autocomplete="type"  autofocus>
   
              </div>
               <div class="form-group">
                <label for="subtitle">Sub - Title</label>
            
                  <input name="subtitle" id="subtitle" class="form-control custom-select" type="text" value="{{ old('subtitle') }}" placeholder="Enter subtitle" autocomplete="type"  autofocus>
   
              </div>
              
             

              <!-- <div class="form-group">
                <label for="inputName">Image</label>
                <input type="file" name="image"  id="image" class="form-control">
              </div> -->
             
              <div class="form-group">
                <label for="list">List</label>
                <textarea type="text" name="list"  id="list" class="ckeditor form-control @error('list') is-invalid @enderror" autocomplete="list"  autofocus ></textarea>

                @error('list')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
              <div class="form-group">
                <label for="description">Description</label>
                <textarea type="text" name="description"  id="description" class="ckeditor form-control @error('description') is-invalid @enderror" placeholder="Enter description"  autocomplete="description"  autofocus ></textarea>

                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
               <div class="form-group">
                <label for="url">url</label>
            
                  <input name="url" id="url" class="form-control custom-select" type="text" value="{{ old('url') }}" placeholder="Enter url" autocomplete="type"  autofocus>
   
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