 @extends('layouts.masters')

@section('title', 'Edit Inspection')

@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Inspection</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>

              <li class="breadcrumb-item"><a href="{{url('')}}/inspection/{{$eid}}">Inspection</a></li>
              <li class="breadcrumb-item active">Edit Inspection</li>
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

            	<form method="post" action="{{ route('admin.updateInspection', $inspection->id) }}" enctype="multipart/form-data">
            		@csrf
					<div class="form-group">
						<label for="inputName">Name<span class="estricCls">*</span></label>
						<input type="text" name="name" id="name" value="{{$inspection->name}}" class="form-control @error('description') is-invalid @enderror" placeholder="Enter Description">
						@error('description')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror  
					</div>
					<input type="hidden" name="iid" value="{{$eid}}">
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