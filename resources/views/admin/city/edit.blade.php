@extends('layouts.masters')

@section('title', 'Add City')

@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add City</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>

              <li class="breadcrumb-item"><a href="{{ route('admin.states', $countryId) }}">State List</a></li>
              
              <li class="breadcrumb-item"><a href="{{ route('admin.cities', [$countryId, $stateId]) }}">City List</a></li>

              <li class="breadcrumb-item active">Edit City</li>
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

            	<form method="post" action="{{ route('admin.updateCity', [$countryId, $stateId, $cityId]) }}" enctype="multipart/form-data">
            		@csrf

              <div class="form-group">
                <label for="inputName">Name<span class="estricCls">*</span></label>
                <input type="text" name="name" value="{{ $cityInfo['name'] }}" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter name"  autocomplete="name" required autofocus>

                @error('name')
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