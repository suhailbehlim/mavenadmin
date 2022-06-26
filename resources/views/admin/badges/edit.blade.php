 @extends('layouts.masters')

@section('title', 'Edit Badge')

@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Badge Approvel</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>

              <li class="breadcrumb-item"><a href="{{ route('admin.badges') }}">Badges</a></li>
              <li class="breadcrumb-item active">Badge Approvel</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


        <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-md-6">
			  <div class="card card-primary">
				<div class="card-body">
					<h5>Customer : {{$user->first_name}} {{$user->last_name}}</h5>
					<h5>Car : {{$car->registration_number}}</h5>
				</div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="card card-primary">
				<div class="card-body">
					<h5>Request For</h5>
					@if($badge_request)
						@foreach($badge_request as $request)
							@if($request->request_for=='360photo')
								<h5>360 Photography : Yes ({{$request->status}})</h5>
							@elseif($request->request_for=='inspection')
								<h5>Inspection : Yes </h5>
							@else
							
							@endif
						@endforeach
					@endif
				</div>
			  </div>
			</div>
		</div>
	  
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-body">
				<h5>360 Photography | Customer Details</h5>
				<p> Address : @if($degreePhoto){{$degreePhoto->address}} @endif</p>
				<p> Payment Id : @if($degreePhoto){{$degreePhoto->payment_id}}  @endif</p>
				<p> Payment Method : @if($degreePhoto){{$degreePhoto->payment_method}}  @endif</p>
				<p> Status : @if($degreePhoto){{$degreePhoto->status}}  @endif</p>
				<p> Date : @if($degreePhoto){{$degreePhoto->date}}  @endif</p>
            	
				<br><br>
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
				<h5>360 Photography | Data Submit</h5>
				<form method="post" action="{{ route('admin.update360Request', $badges->id) }}" enctype="multipart/form-data">
            		@csrf
					
					<div class="form-group">
						<label for="inputName">Title<span class="estricCls">*</span></label>
						<input type="text" name="title" value="@if($badge_360){{$badge_360->title}}@endif" id="title" class="form-control @error('title') is-invalid @enderror" placeholder="Enter banner title" autocomplete="title" required autofocus>
						@error('title')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror  
					</div>
					
					<div class="form-group">
						<label for="inputName">Meta<span class="estricCls">*</span></label>
						<input type="text" name="meta" value="@if($badge_360){{$badge_360->meta}}@endif" id="meta" class="form-control @error('meta') is-invalid @enderror" placeholder="Enter meta" autocomplete="meta" required autofocus>
						@error('meta')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror  
					</div>
					
					<div class="form-group">
						<label for="inputName">Upload 360 Photo<span class="estricCls">*</span></label>
						<input type="file" name="panel" value="" id="panel" class="form-control">
						@if($badge_360)
							<img src="{{ URL::to('/public') }}/uploads/360photography/{{ $badge_360->panel }}" width="100">
						@endif
					</div>
					
					<div class="form-group">
						<label for="inputStatus">Status<span class="estricCls">*</span></label>
						<select name="status" id="status" class="form-control custom-select">
						  <option value="pending" @if($badge_360) @if($badge_360->status=='pending') selected @endif @endif>Pending</option>
						  <option value="success" @if($badge_360) @if($badge_360->status=='success') selected @endif @endif>Success</option>
						</select>
					</div>
					<input type="hidden" name="resid" value="@if($badge_360){{$badge_360->id}}@endif">
					
					<div class="form-group">
					   <input type="submit" name="Update" class="btn btn-success">
					</div>

				</form>
            </div>
          </div>
        </div>
		
		<div class="col-md-6">
          <div class="card card-primary">
			@if($inspectionDt)
            <div class="card-body">
				<h5>Inspection | Customer Details</h5>
				<p> Address : {{$inspectionDt->address}} </p>
				<p> Payment Id : {{$inspectionDt->payment_id}} </p>
				<p> Payment Method : {{$inspectionDt->payment_method}} </p>
				<p> Status : {{$inspectionDt->status}} </p>
				<p> Date : {{$inspectionDt->date}} </p>
            	
				<br><br>
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
				<h5>Inspection | Data Submit</h5>
				<form method="post" action="{{ route('admin.updateInspectionRequest', $badges->id) }}" enctype="multipart/form-data">
            		@csrf
					
					<?php 
					//echo '<pre>';
					//print_r($inspection_options);
					?>
					
					@if($inspection_options)
					@foreach($inspection_options as $firstkeys)
					<div class="form-group">
						<label for="inputName">{{$firstkeys['inspection_name']}}<span class="estricCls">*</span></label>
						@if($firstkeys['inspection_options'])
						@foreach($firstkeys['inspection_options'] as $options)
						
						<fieldset id="group1" style="line-height: 35px;">
							<span style="width: 60%;display: inline-block;">{{$options['name']}}</span> &nbsp;&nbsp;&nbsp;
							<input type="radio" value="{{$options['id']}}_true" name="{{$options['id']}}_{{$options['id']}}" @if($options['report']=='true') checked @endif> True
							@if($options['report'])
							<input type="radio" value="{{$options['id']}}_false" name="{{$options['id']}}_{{$options['id']}}" @if($options['report']=='false') checked @endif> False
							@else
							<input type="radio" value="{{$options['id']}}_false" name="{{$options['id']}}_{{$options['id']}}" checked> False
							@endif
						</fieldset>
						
						@endforeach
						@endif
					</div>
					@endforeach
					@endif
					
					<div class="form-group">
						<label for="inputStatus">Status<span class="estricCls">*</span></label>
						<select name="status" id="status" class="form-control custom-select">
						  <option value="pending" @if($inspectionDt) @if($inspectionDt->status=='pending') selected @endif @endif>Pending</option>
						  <option value="success" @if($inspectionDt) @if($inspectionDt->status=='success') selected @endif @endif>Success</option>
						</select>
					</div>
					<input type="hidden" name="resid" value="<?php if(count($inspection_report)>0){ echo $badges->id; } ?>">
					<div class="form-group">
					   <input type="submit" name="Update" class="btn btn-success">
					</div>

				</form>
            </div>
			@endif
          </div>
        </div>
       
      </div>


    </section>
    <!-- /.content -->

    @include('admin.customjs')

@stop