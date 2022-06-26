@extends('layouts.masters')

@section('title', 'Edit Fuel')

@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Fuel</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>

              <li class="breadcrumb-item"><a href="{{ route('admin.fuel_types') }}">Fuel List</a></li>
              <li class="breadcrumb-item active">Edit Fuel</li>
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
            <div class="card-body">

            	<form method="post" action="{{ route('admin.updateFuelType', $body_type->id) }}" enctype="multipart/form-data">
            		@csrf 
			  <div class="form-group">
                <label for="inputName">Type<span class="estricCls">*</span></label>
                <input type="text" name="type" value="{{ $body_type->type }}" id="name" class="form-control @error('type') is-invalid @enderror" placeholder="Enter Fuel Type"  autocomplete="type" required autofocus>

                @error('type')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
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