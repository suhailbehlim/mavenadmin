 @extends('layouts.masters')

@section('title', 'Add Role')

@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Role</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>

              <li class="breadcrumb-item"><a href="{{ route('admin.roles') }}">Roles</a></li>
              <li class="breadcrumb-item active">Add Role</li>
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

            	<form method="post" action="{{ route('admin.storeRole') }}" enctype="multipart/form-data">
            		@csrf

				  <div class="form-group">
					<label for="inputName">Name<span class="estricCls">*</span></label>
					<input type="text" name="name" value="{{ old('name') }}" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter role name" autocomplete="name" required autofocus>

					@error('name')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror  
				  </div>
					<h4>Role Permission</h4>
				  <div id="add">
					<div class="form-group">
					  <label for="inputStatus">Add<span class="estricCls">*</span></label>
					  <select name="add" id="add" class="form-control custom-select">
						<option value="1">Yes</option>
						<option value="0">No</option>
					  </select>
					</div>
				  </div>
					<div id="edit">
						<div class="form-group">
						  <label for="inputStatus">Edit<span class="estricCls">*</span></label>
						  <select name="edit" id="edit" class="form-control custom-select">
							<option value="1">Yes</option>
							<option value="0">No</option>
						  </select>
						</div>
					</div>
					<div id="delete">
						<div class="form-group">
						  <label for="inputStatus">Delete<span class="estricCls">*</span></label>
						  <select name="delete" id="Delete" class="form-control custom-select">
							<option value="1">Yes</option>
							<option value="0">No</option>
						  </select>
						</div>
					</div>
					<div id="view">
						<div class="form-group">
						  <label for="inputStatus">View<span class="estricCls">*</span></label>
						  <select name="view" id="view" class="form-control custom-select">
							<option value="1">Yes</option>
							<option value="0">No</option>
						  </select>
						</div>
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

    @include('admin.customjs')
@stop