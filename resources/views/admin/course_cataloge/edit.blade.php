 @extends('layouts.masters')

@section('title', 'Edit Cataloge')

@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Cataloge</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>

              <li class="breadcrumb-item"><a href="{{ route('admin.course_cataloge') }}">Cataloge</a></li>
              <li class="breadcrumb-item active">Edit Cataloge</li>
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

            	<form method="post" action="{{ route('admin.updatecataloge', $banner->id) }}" enctype="multipart/form-data">
            		@csrf
                 <input type="hidden" name="section" value="main">
            		 <div class="form-group">
                <label for="section">Section<span class="estricCls">*</span></label>
                <select name="section" class="form-control">
                <option value="main" @if($banner->section == 'main') selected @endif>Main</option>
                 <option value="corporate-training" @if($banner->section == 'corporate-training') selected @endif>corporate-training</option>
                 <option value="connect-with-us" @if($banner->section == 'connect-with-us') selected @endif>connect-with-us</option>
                 <option value="workshop" @if($banner->section == 'workshop') selected @endif>workshop</option>
                 <option value="placements" @if($banner->section == 'placements') selected @endif>placements</option>
                 <option value="career" @if($banner->section == 'career') selected @endif>career</option>
               </select>

                @error('section')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
					<div class="form-group">
					<label for="inputName">Title<span class="estricCls">*</span></label>
            <input type="text" name="title" value="{{$banner->title}}" id="title" class="form-control @error('title') is-invalid @enderror" placeholder="Enter title" required> 
					@error('title')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror  
				  </div>
				<div class="form-group">
          <label for="categories">categories<span class="estricCls">*</span></label>
          <input type="text" name="categories" value="{{$banner->categories}}" id="categories" class="form-control @error('categories') is-invalid @enderror" placeholder="Enter banner categories" autocomplete="categories"  autofocus>
          @error('categories')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror  
          </div>
            <div class="form-group">
          <label for="description">Description<span class="estricCls">*</span></label>
            <textarea name="description" class="description form-control ckeditor" required>{{$banner->description}}</textarea>
          @error('description')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror  
          </div>
				  
					<div class="form-group">
						<label for="image">Image<span class="estricCls">*</span></label>
						<input type="file" name="image" value="" id="image" class="form-control">
						@if( $banner->image !='')
							<img src="{{ URL::to('/public') }}/{{ $banner->image }}" width="100">
						@else 
							NA
						@endif
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

    @include('admin.customjs')

@stop