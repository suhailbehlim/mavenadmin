 @extends('layouts.masters')

@section('title', 'Body Type')

@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Body Type</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>

              <li class="breadcrumb-item"><a href="{{ route('admin.body_list') }}">List</a></li>
              <li class="breadcrumb-item active">Edit Body Type</li>
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

            	<form method="post" action="{{ route('admin.updateBody') }}" enctype="multipart/form-data">
            		@csrf
					<div class="form-group">
					<label for="inputName">Body Type<span class="estricCls">*</span></label>
					<input type="text" name="body_type" value="{{$body_type->body_type}}" id="body_type" class="form-control @error('body_type') is-invalid @enderror" placeholder="Enter body_type" autocomplete="body_type" required autofocus>

					@error('body_type')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror  
				  </div>
				  <div class="form-group">
					<label for="inputName">Model ID<span class="estricCls">*</span></label>
					<input type="text" name="model_id" value="{{$body_type->model_id}}" id="model_id" class="form-control @error('model_id') is-invalid @enderror" placeholder="Enter Model ID" autocomplete="model_id" required autofocus>

					@error('model_id')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror  
				  </div>
				  <input type="hidden" name="id" value="{{$body_type->id}}">
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

    @include('admin.customjs')

@stop