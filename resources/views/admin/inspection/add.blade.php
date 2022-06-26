 @extends('layouts.masters')

@section('title', 'Add Inspection')

@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add New {{$inspectionname->inspection}}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>

              <li class="breadcrumb-item"><a href="{{url('')}}/inspection/{{$eid}}">Inspection</a></li>
              <li class="breadcrumb-item active">Add New {{$inspectionname->inspection}}</li>
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
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-body">

            	<form method="post" action="{{ route('admin.storeInspection') }}" enctype="multipart/form-data">
            		@csrf
					<div class="form-group">
						<label for="inputName">Name<span class="estricCls">*</span></label>
						<input type="text" name="name" id="name" class="form-control @error('description') is-invalid @enderror" placeholder="Enter name">
						@error('description')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror  
					</div>
				<input type="hidden" name="iid" value="{{$eid}}">
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