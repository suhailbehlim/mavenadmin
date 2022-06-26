 @extends('layouts.masters')

@section('title', 'Add Course')

@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Course</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>

              <li class="breadcrumb-item"><a href="{{ route('admin.car_models') }}">Course List</a></li>
              <li class="breadcrumb-item active">Add Course</li>
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

            	<form method="post" action="{{ route('admin.storeCourse') }}" enctype="multipart/form-data">
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
                <input type="text" name="course_type" value="{{ old('course_type') }}" id="course_type" class="form-control @error('course_type') is-invalid @enderror" placeholder="Enter Course Type"  autocomplete="course_type"  autofocus>
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
					<option value="{{$km->name}}">{{$km->name}}</option>
					@endforeach
					@endif
				  </select>
				</div>
			  
              <div class="form-group">
                <label for="inputName">Batch Timing<span class="estricCls">*</span></label>
                <input type="datetime-local" name="batch"  id="batch" class="form-control @error('batch') is-invalid @enderror" placeholder="Enter Batch Timing"  autocomplete="Batch" required autofocus>

                @error('batch')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
			  <div class="form-group">
                <label for="inputName">Duration<span class="estricCls"></span></label>
                <input type="text" name="duration"  id="duration" class="form-control @error('duration') is-invalid @enderror" placeholder="Enter duration "  autocomplete="duration"  autofocus>

                @error('duration')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
				<div class="form-group">
					<label for="inputName">Languages<span class="estricCls"></span></label>
					<input type="text" name="languages" value="{{ old('languages') }}" id="languages" class="form-control @error('languages') is-invalid @enderror" placeholder="Enter languages"  autocomplete="languages"  autofocus>
					@error('languages')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror  
				</div>
				
				<div class="form-group">
					<label for="inputName">Title<span class="estricCls"></span></label>
					<input type="text" name="title" value="{{ old('title') }}" id="title" class="form-control @error('title') is-invalid @enderror" placeholder="Enter title"  autocomplete="title"  autofocus>
					@error('title')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror  
				</div>
				
				<!-- <div class="form-group">
					<label for="inputName">Requirements<span class="estricCls">*</span></label>
					<textarea name="requirements" id="requirements" class="form-control @error('requirements') is-invalid @enderror" placeholder="Enter Requirements"  autocomplete="title" required autofocus></textarea>
					@error('requirements')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror  
				</div> -->
				
				<div class="form-group">
					<label for="inputName">Subtitle<span class="estricCls"></span></label>
					<textarea name="short_description" id="short_description" class="form-control @error('short_description') is-invalid @enderror" placeholder="Enter short_description"  autocomplete="title"  autofocus></textarea>
					@error('short_description')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror  
				</div>
				
				<div class="form-group">
					<label for="inputName">Description<span class="estricCls"></span></label>
					<textarea name="full_description" id="full_description" class="form-control @error('full_description') is-invalid @enderror" placeholder="Enter full_description"  autocomplete="title"  autofocus></textarea>
					@error('full_description')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror  
				</div>
				<div class="form-group">
					<label for="inputName" >Timing <span class="estricCls"></span></label>
					<input name="timing" type="time" id="timing" class="form-control @error('timing') is-invalid @enderror" placeholder="Enter time"  autocomplete="title"  autofocus></input>
					@error('timing')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror  
				</div>
				<div class="form-group">
					<label for="inputName">Offer <span class="estricCls"></span></label>
					<textarea name="offer" id="offerprice" class="form-control @error('offerprice') is-invalid @enderror" placeholder="Enter offer price"  autocomplete="title" autofocus></textarea>
					@error('offerprice')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror  
				</div>
				
				<div class="form-group">
                <label for="inputStatus">Subscription<span class="estricCls"></span></label>
                <select name="subscription" id="subscription" class="form-control custom-select">
                  <option value="Monthly">Monthly </option>
                  <option value="Quaterly">Quaterly</option>
				  <option value="Yearly">Yearly</option>
                </select>
              </div>
				<div class="form-group">
					<label for="inputName">Price<span class="estricCls"></span></label>
					<input type="text" name="price" value="{{ old('price') }}" id="price" class="form-control @error('price') is-invalid @enderror" placeholder="Enter price"  autocomplete="price"  autofocus>
					@error('price')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror  
				</div>
				<div class="form-group">
					<label for="inputName">Thumbnail<span class="estricCls"></span></label>
					<input type="file" name="thumbnail" id="thumbnail" class="form-control">
				</div>
				<div class="form-group">
					<label for="inputName">Main Image<span class="estricCls"></span></label>
					<input type="file" name="main_image" id="main_image" class="form-control">
				</div>

				<div class="form-group">
					<label for="inputName">Short video<span class="estricCls"></span></label>
					<input type="file" name="shorts" id="shorts" class="form-control">
				</div>
				<div class="form-group">
					<label for="inputName">Full Video<span class="estricCls"></span></label>
					<input type="file" name="fullvideo" id="fullvideo" class="form-control">
				</div>
				
				<div class="form-group">
					<label for="inputName">Next Batch<span class="estricCls"></span></label>
					<input name="nextbatch" id="nextbatch" class="form-control @error('nextbatch') is-invalid @enderror" placeholder="Enter nextbatch"  autocomplete="nextbatch"  autofocus>
					@error('nextbatch')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror  
				</div>
				<div class="form-group">
					<label for="inputName">Demo Class Date<span class="estricCls"></span></label>
					<input  type="date" name="batchdate" id="batchdate" class="form-control @error('batchdate') is-invalid @enderror" placeholder="Enter batch date"  autocomplete="batchdate"  autofocus>
					@error('batchdate')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror  
				</div>


					<div class="form-group">
					<label for="inputName1">Apply Now Date<span class="estricCls"></span></label>
					<input type="date" name="batchdate1" id="batchdate1" class="form-control @error('batchdate1') is-invalid @enderror" value="" placeholder="Enter batch date"  autocomplete="batchdate"  autofocus>
					@error('batchdate1')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror  
				</div>

					<div class="form-group">
					<label for="inputName2">Enquire Now Date<span class="estricCls"></span></label>
					<input type="date" name="batchdate2" id="batchdate2" class="form-control @error('batchdate2') is-invalid @enderror" value="" placeholder="Enter batch date"  autocomplete="batchdate2"  autofocus>
					@error('batchdate2')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror  
				</div>
				
				
				<div class="form-group">
                <label for="inputStatus">Status<span class="estricCls">*</span></label>
                <select name="status" id="status" class="form-control custom-select">
                  <option value="Offline">Offline</option>
                  <option value="Online">Online</option>
                </select>
              </div>
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

@stop