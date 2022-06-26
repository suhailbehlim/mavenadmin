@extends('layouts.masters')

@section('title', 'Edit Course')

@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Course</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>

              <li class="breadcrumb-item"><a href="{{ route('admin.courses') }}"> Course</a></li>
              <li class="breadcrumb-item active">Edit Course</li>
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
              <h3 class="card-title">Details</h3>

              
            </div>
            <div class="card-body">

            	<form method="post" action="{{ route('admin.updateCourse', $courseInfo->id) }}" enctype="multipart/form-data">
            		@csrf
			<div class="form-group">
                <label for="inputName">URL<span class="estricCls">*</span></label>
                <input type="text" name="url"  id="slug" class="form-control @error('slug') is-invalid @enderror" placeholder="Enter URL"  autocomplete="title" required autofocus>

                @error('url')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
             </div>
				<div class="form-group">
                <label for="inputName">Course Type<span class="estricCls"></span></label>
                <input type="text" name="course_type" value="{{ $courseInfo->course_type}}" id="course_type" class="form-control @error('course_type') is-invalid @enderror" placeholder="Enter Course Type"  autocomplete="course_type"  autofocus>
                @error('course_type')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
			  
			  
			  <div class="form-group">
				  <label for="inputStatus">Course Category<span class="estricCls">*</span></label>
				  <select name="category" id="category" class="form-control custom-select">
					@if($category)
					@foreach($category as $km)
					<option value="{{$km->name}}" @if($courseInfo->category==$km->id) selected @endif>{{$km->name}}</option>
					@endforeach
					@endif
				  </select>
				</div>
			  
				<div class="form-group">
					<label for="inputName">Batch Timing<span class="estricCls">*</span></label>
					<input type="datetime-local" name="batch" value="{{ date('Y-m-d\TH:i', strtotime($courseInfo->batch))}}" id="batch" class="form-control @error('batch') is-invalid @enderror" placeholder="Enter Batch Timing"  autocomplete="Batch" required autofocus>
	
					@error('batch')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror  
				  </div>
				  <div class="form-group">
					<label for="inputName">Duration<span class="estricCls"></span></label>
					<input type="text" name="duration"  id="duration" class="form-control  @error('duration') is-invalid @enderror" placeholder="Enter duration "value="{{$courseInfo->duration}}"   autocomplete="duration"  autofocus>
	
					@error('duration')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror  
				  </div>
				<div class="form-group">
					<label for="inputName">Languages<span class="estricCls"></span></label>
					<input type="text" name="languages" value="{{$courseInfo->languages}}" id="languages" class="form-control @error('languages') is-invalid @enderror" placeholder="Enter languages"  autocomplete="languages"  autofocus>
					@error('languages')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror  
				</div>
				
				<div class="form-group">
					<label for="inputName">Title<span class="estricCls"></span></label>
					<input type="text" name="title" value="{{$courseInfo->title}}" id="title" class="form-control @error('title') is-invalid @enderror" placeholder="Enter title"  autocomplete="title" autofocus>
					@error('title')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror  
				</div>
				
			<!-- 	<div class="form-group">
					<label for="inputName">Requirements<span class="estricCls">*</span></label>
					<textarea name="requirements" id="requirements" class="form-control @error('requirements') is-invalid @enderror" placeholder="Enter Requirements"  autocomplete="title" required autofocus>{{$courseInfo->requirements}}</textarea>
					@error('requirements')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror  
				</div> -->
				
			
				<div class="form-group">
					<label for="inputName">Subtitle<span class="estricCls"></span></label>
					<textarea name="short_description" id="short_description" class="form-control @error('short_description') is-invalid @enderror" placeholder="Enter short_description"  autocomplete="title"  autofocus>{{$courseInfo->short_description}}</textarea>
					@error('short_description')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror  
				</div>
				
				<div class="form-group">
					<label for="inputName"> Description<span class="estricCls"></span></label>
					<textarea name="full_description" id="full_description" class="form-control @error('full_description') is-invalid @enderror" placeholder="Enter full_description"  autocomplete="title"  autofocus>{{$courseInfo->full_description}}</textarea>
					@error('full_description')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror  
				</div>
				<div class="form-group">
					<label for="inputName" >Timing <span class="estricCls"></span></label>
					<input name="timing" type="time" id="timing" value="{{ date('H:i', strtotime($courseInfo->timing))}}" class="form-control @error('timing') is-invalid @enderror" placeholder="Enter time"  autocomplete="title"  autofocus></input>
					@error('timing')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror  
				</div>
				<div class="form-group">
					<label for="inputName">Offer <span class="estricCls"></span></label>
					<input name="offer" id="offerprice"value="{{$courseInfo->offer}}" class="form-control @error('offerprice') is-invalid @enderror" placeholder="Enter offer price"  autocomplete="title"  autofocus>
					@error('offerprice')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror  
				</div>
				
				<div class="form-group">
                <label for="inputStatus">Subscription<span class="estricCls"></span></label>
                <select name="subscription" id="subscription" class="form-control custom-select">
                  <option value="Monthly" @if($courseInfo->subscription=='Monthly') selected @endif>Monthly </option>
                  <option value="Quaterly" @if($courseInfo->subscription=='Quaterly') selected @endif>Quaterly</option>
				  <option value="Yearly" @if($courseInfo->subscription=='Yearly') selected @endif>Yearly</option>
                </select>
              </div>
				<div class="form-group">
					<label for="inputName">Price<span class="estricCls"></span></label>
					<input type="text" name="price" value="{{$courseInfo->price}}" id="price" class="form-control @error('price') is-invalid @enderror" placeholder="Enter price"  autocomplete="price" autofocus>
					@error('price')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror  
				</div>
				<div class="form-group">
					<label for="inputName">Thumbnail<span class="estricCls">*</span></label>
					<input type="file" name="thumbnail" id="thumbnail" class="form-control">
					<img src="{{ URL::to('/public') }}/system/courses/<?php echo $courseInfo->thumbnail; ?>" width="100">
				</div>
				<div class="form-group">
					<label for="inputName">Main Image<span class="estricCls">*</span></label>
					<input type="file" name="main_image" id="main_image" class="form-control">
					<img src="{{ URL::to('/public') }}/system/courses/<?php echo $courseInfo->main_image; ?>" width="100">
				</div>
				
				<div class="form-group">
					<label for="inputName">Short video<span class="estricCls">*</span></label>
					<input type="file" name="shorts" id="shorts" class="form-control" >
					<video src="{{ URL::to('/public') }}/system/courses/<?php echo $courseInfo->shorts; ?>" width="100">

				</div>
				<div class="form-group">
					<label for="inputName">Full Video<span class="estricCls">*</span></label>
					<input type="file" name="fullvideo" id="fullvideo" class="form-control">
					<video src="{{ URL::to('/public') }}/system/courses/<?php echo $courseInfo->fullvideo; ?>" width="100">

				</div>
				<div class="form-group">
					<label for="inputName">Next Batch<span class="estricCls"></span></label>
					<input name="nextbatch" id="nextbatch" class="form-control @error('nextbatch') is-invalid @enderror"value="{{$courseInfo->nextbatch}}" placeholder="Enter next batch"  autocomplete="nextbatch"  autofocus>
					@error('nextbatch')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror  
				</div>
				<div class="form-group">
					<label for="inputName">Demo Class Date<span class="estricCls"></span></label>
					<input type="date" name="batchdate" id="batchdate" class="form-control @error('batchdate') is-invalid @enderror"value="{{$courseInfo->batchdate}}" placeholder="Enter batch date"  autocomplete="batchdate"  autofocus>
					@error('batchdate')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror  
				</div>

					<div class="form-group">
					<label for="inputName1"> Apply Now Date<span class="estricCls"></span></label>
					<input type="date" name="batchdate1" id="batchdate1" class="form-control @error('batchdate1') is-invalid @enderror" value="{{ date('Y-m-d', strtotime($courseInfo->batchdate1))}}" placeholder="Enter batch date"  autocomplete="batchdate"  autofocus>
					@error('batchdate1')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror  
				</div>

					<div class="form-group">
					<label for="inputName2"> Enquire Now Date<span class="estricCls"></span></label>
					<input type="date" name="batchdate2" id="batchdate2" class="form-control @error('batchdate2') is-invalid @enderror" value="{{ date('Y-m-d', strtotime($courseInfo->batchdate2))}}" placeholder="Enter batch date"  autocomplete="batchdate2"  autofocus>
					@error('batchdate2')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror  
				</div>
				
				
				<div class="form-group">
                <label for="inputStatus">Status<span class="estricCls">*</span></label>
                <select name="status" id="status" class="form-control custom-select">
                  <option <?php if($courseInfo->status == 'Inactive') {
                    echo 'selected="selected"';
                  } ?>  value="Offline">Offline</option>
                  <option <?php if($courseInfo->status == 'Active') {
                    echo 'selected="selected"';
                  } ?> value="Online">Online</option>
                </select>
              </div>
              <div class="form-group">
			  <input type="hidden" name="id" value="{{$courseInfo->id}}" id="id">
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