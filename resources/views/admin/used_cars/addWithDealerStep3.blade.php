 @extends('layouts.masters')

@section('title', 'Add Used Car')

@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Step Final</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Step Final</li>
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
              <h3 class="card-title">Posts Request</h3>
			  <div class="card-tools">
				<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
					<i class="fas fa-minus"></i></button>
				</div>
            </div>
            <div class="card-body">

            	<form method="post" action="{{ route('admin.storeUsedCarStep3', $car_id) }}" enctype="multipart/form-data">
            		@csrf
					<div class="form-group">
						<div class="form-check">
						  <input class="form-check-input" name="" type="checkbox" value="" id="flexCheckDefault">
						  <label class="form-check-label" for="flexCheckDefault">
							Inspection ${{$cars_plan->inspection_price}}
						  </label>
						</div>
						<div class="form-check">
						  <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
						  <label class="form-check-label" for="flexCheckChecked">
							Photography ${{$cars_plan->photography_price}}
						  </label>
						</div>
					</div>
              <div class="form-group">
               <input type="submit" name="Update" value="Save" class="btn btn-success">
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