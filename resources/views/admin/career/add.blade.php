 @extends('layouts.masters')

@section('title', 'Add Career')

@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Career</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>

              <li class="breadcrumb-item"><a href="{{ route('admin.careerlist') }}">Career List</a></li>
              <li class="breadcrumb-item active">Add Career</li>
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

            	<form method="post" action="{{ route('admin.storeCareer') }}" enctype="multipart/form-data">
            		@csrf

              <div class="form-group">
                <label for="inputName">Title<span class="estricCls">*</span></label>
                <input type="text" name="title"  id="slug" class="form-control @error('slug') is-invalid @enderror" placeholder="Enter title"  autocomplete="title" required autofocus>

                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
              <div class="form-group">
                <label for="inputName">Openings<span class="estricCls">*</span></label>
                <input type="text" name="opening"  id="opening" class="form-control @error('opening') is-invalid @enderror" placeholder="Enter opening"  autocomplete="opening" required autofocus>

                @error('opening')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
			  
			  <div class="form-group">
                <label for="inputName">Job Level<span class="estricCls">*</span></label>
                <select type="text" name="job"  id="job" class="form-control @error('job') is-invalid @enderror" placeholder="Enter job"  autocomplete="job" required autofocus>
					<option >Senior Level</option>
					<option >Junior Level</option>
					<option>Mid Level</option>
                </select>


                @error('job')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>

              <div class="form-group">
                <label for="inputName">Job-Type<span class="estricCls">*</span></label>
                <select type="text" name="jobtype"  id="jobtype" class="form-control @error('jobtype') is-invalid @enderror" placeholder="Enter jobtype"  autocomplete="jobtype" required autofocus>
                <option > Full time</option>
                <option >Part Time</option>
                <option>Internship</option>
                <option>Temporary</option>

                      </select>
      
                @error('jobtype')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
              <div class="form-group">
                <label for="inputName">Location<span class="estricCls">*</span></label>
                <input type="text" name="location"  id="location" class="form-control @error('location') is-invalid @enderror" placeholder="Enter location"  autocomplete="location" required autofocus >

                @error('location')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
              <div class="form-group">
                <label for="inputName">Description<span class="estricCls">*</span></label>
                <textarea type="text" name="description"  id="description" class="ckeditor form-control @error('description') is-invalid @enderror" placeholder="Enter description"  autocomplete="description" required autofocus ></textarea>

                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
              <div class="form-group">
                <label for="inputStatus">Status<span class="estricCls">*</span></label>
                <select name="status" id="status" class="form-control custom-select">
                  <option value="Inactive">Inactive</option>
                  <option value="Active">Active</option>
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