 @extends('layouts.masters')

@section('title', 'Update Calculator')

@section('content')

    <section class="content-header">

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

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Update Calculator</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Update Calculator</li>
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

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">

            

          <form method="post" action="{{ route('admin.saveCalculator') }}" enctype="multipart/form-data">
            @csrf

          <div class="form-group">
            <label for="inputName">Calculator Percentage<span class="estricCls">*</span></label>
            <input type="text" name="percent" value="{{ $calculator->percent }}" id="percent" class="form-control @error('percent') is-invalid @enderror" placeholder="Enter boost charge"  autocomplete="percent" required autofocus>

            @error('percent')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror  


          </div>
			<div class="form-group">
			  <label for="inputStatus">Years List<span class="estricCls">*</span></label>
			  <select name="list" id="list" class="form-control custom-select" required>
				@if($calculator_time)
				@foreach($calculator_time as $time)
				<option value="{{$time->value}}">{{$time->type}}</option>
				@endforeach
				@endif
			  </select>
			</div>
			
			<div class="form-group">
            <label for="inputName">Add New Year<span class="estricCls">*</span></label>
            <input type="text" name="month" value="" id="month" class="form-control" placeholder=""  autocomplete="month" autofocus>

          </div>
          <div class="form-group">
            <input type="submit" name="Save" value="Update" class="btn btn-success">
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