 @extends('layouts.masters')

@section('title', 'Add Used Car')

@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Used Car</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Add Used Car</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


        <!-- Main content -->
    <section class="content">
		@if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>    
            <strong>{{ $message }}</strong>
        </div>
        @endif
          
        @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>    
            <strong>{{ $message }}</strong>
        </div>
        @endif
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Basic Information</h3>
			  <div class="card-tools">
				<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
					<i class="fas fa-minus"></i></button>
				</div>
            </div>
            <div class="card-body">

            	<form method="post" action="{{ route('admin.storeUsedCarStep1', $dealerid) }}" enctype="multipart/form-data">
            		@csrf
					<div class="form-group">
					  <label for="inputStatus">Vehicle Type<span class="estricCls">*</span></label>
					  <select name="vehicle_type" id="vehicle_type" class="form-control custom-select" required>
						@if($vehicle_type)
						@foreach($vehicle_type as $type)
						<option value="{{$type->id}}">{{$type->type}}</option>
						@endforeach
						@endif
					  </select>
					</div>
					
					<div class="form-group">
					  <label for="inputStatus">Make<span class="estricCls">*</span></label>
					  <select name="make" id="make" class="form-control custom-select" onchange="getModel(this.value);" required>
						@if($make)
						@foreach($make as $km)
						<option value="{{$km['id']}}">{{$km['title']}}</option>
						@endforeach
						@endif
					  </select>
					</div>
					<div class="form-group">
					  <label for="inputStatus">Model<span class="estricCls">*</span></label>
					  <select name="model" id="model" class="form-control custom-select" required>
						
					  </select>
					</div>
					
					<div class="form-group">
					  <label for="inputStatus">Year<span class="estricCls">*</span></label>
					  <select name="year" id="year" class="form-control custom-select" required>
						
					  </select>
					</div>
					
					<div class="form-group">
						<label for="inputName">Registration Number<span class="estricCls">*</span></label>
						<input type="text" name="registration_number" value="" id="registration_number" class="form-control @error('registration_number') is-invalid @enderror" placeholder="Enter Registration Number" autocomplete="registration_number" required autofocus>

						@error('registration_number')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror  
					</div>
					
					<div class="form-group">
						<label for="inputName">Current Mileage<span class="estricCls">*</span></label>
						<input type="number" name="current_mileage" value="" id="current_mileage" class="form-control @error('current_mileage') is-invalid @enderror" placeholder="Enter Current Mileage" autocomplete="current_mileage" required autofocus>

						@error('current_mileage')
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
					   <input type="submit" name="Update" value="Next" class="btn btn-success">
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