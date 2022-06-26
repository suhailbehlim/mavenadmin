@extends('layouts.masters')

@section('title', 'Edit Career')

@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Career</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>

              <li class="breadcrumb-item"><a href="{{ route('admin.careerlist') }}">Career List</a></li>
              <li class="breadcrumb-item active">Edit Career</li>
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

            	<form method="post" action="{{ route('admin.updateCareer', $careerId) }}" enctype="multipart/form-data">
            		@csrf
			
			  <div class="form-group">
                <label for="inputName">Title<span class="estricCls">*</span></label>
                <input type="text" name="title" value="{{ $careerInfo['title'] }}" id="title" class="form-control @error('title') is-invalid @enderror" placeholder="Enter title"  autocomplete="title" required autofocus>

                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
              <div class="form-group">
                <label for="inputName">Openings<span class="estricCls">*</span></label>
                <input type="text" name="opening" value="{{ $careerInfo['opening'] }}" id="opening" class="form-control @error('opening') is-invalid @enderror" placeholder="Enter opening"  autocomplete="opening" required autofocus>

                @error('opening')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
              <div class="form-group">
                <label for="inputName">Job Level<span class="estricCls">*</span></label>
                <select type="text" name="job" value="{{ $careerInfo['job'] }}" id="job" class="form-control @error('job') is-invalid @enderror" placeholder="Enter job"  autocomplete="job" required autofocus>
                  <option >{{ $careerInfo['job'] }}</option>

                  <option >Senior Level</option>
                <option >Junior Level</option>
                <option>Mid level</option>
                      </select>
                @error('job')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
              <div class="form-group">
                <label for="inputName">JobType<span class="estricCls">*</span></label>
                <select type="text" name="jobtype" value="{{ $careerInfo['jobtype'] }}" id="jobtype" class="form-control @error('jobtype') is-invalid @enderror" placeholder="Enter jobtype"  autocomplete="jobtype" required autofocus >
                <option >{{ $careerInfo['jobtype'] }}</option>
                <option >Temporary</option>
                <option >Part Time</option>
              <option >Full Time</option>
              <option>Internship</option>
              </select>
                @error('jobtype')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
              <div class="form-group">
                <label for="inputName">Location<span class="estricCls">*</span></label>
                <input type="text" name="location"  id="location" class="form-control @error('location') is-invalid @enderror" placeholder="Enter location" value="{{ $careerInfo['location'] }}" autocomplete="location" required autofocus>

                @error('location')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
              <div class="form-group">
                <label for="inputName">Description<span class="estricCls">*</span></label>
                <textarea type="text" name="description"  id="ckeditor" class="ckeditor form-control @error('description') is-invalid @enderror" placeholder="Enter description"  autocomplete="description" required autofocus>{{ $careerInfo['description'] }}</textarea>

                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
              
			  <div class="form-group">
                <label for="inputStatus">Status<span class="estricCls">*</span></label>
                <select name="status" id="status" class="form-control custom-select">
                  <option <?php if($careerInfo['status'] == 'Inactive') {
                    echo 'selected="selected"';
                  } ?>  value="Inactive">Inactive</option>
                  <option <?php if($careerInfo['status'] == 'Active') {
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