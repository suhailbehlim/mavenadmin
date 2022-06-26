 @extends('layouts.masters')

@section('title', 'Add Banner')

@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Banner</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>

              <li class="breadcrumb-item"><a href="{{ route('admin.banners') }}">Banners</a></li>
              <li class="breadcrumb-item active">Add Banner</li>
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

            	<form method="post" action="{{ route('admin.storeBanner') }}" enctype="multipart/form-data">
            		@csrf
                <input type="hidden" name="section" value="main">
            <!--   <div class="form-group">
                <label for="section">Section<span class="estricCls">*</span></label>
                <select name="section" class="form-control">
                <option value="main">Main</option>
                 <option value="corporate-training" >corporate-training</option>
                 <option value="connect-with-us" >connect-with-us</option>
                 <option value="workshop">workshop</option>
                 <option value="placements" >placements</option>
                 <option value="career" >career</option>
               </select>

                @error('section')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div> -->
				  <div class="form-group">
					<label for="inputName">Title<span class="estricCls">*</span></label>
           <textarea name="title" class=" form-control @error('title') is-invalid @enderror ckeditor" required></textarea>
					
					@error('title')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror  
				  </div>
				  <div class="form-group">
					<label for="inputName">ALT<span class="estricCls">*</span></label>
					<input type="text" name="alt" value="" id="alt" class="form-control @error('alt') is-invalid @enderror" placeholder="Enter banner alt" autocomplete="alt" required autofocus>
					@error('alt')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror  
				  </div>
           <div class="form-group">
          <label for="description">Description<span class="estricCls">*</span></label>
            <textarea name="description" class="description form-control ckeditor" required></textarea>
          @error('description')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror  
          </div>
				  
					<div class="form-group">
						<label for="inputName">Desktop Banner<span class="estricCls">*</span></label>
						<input type="file" name="desktop_banner" value="" id="desktop_banner" class="form-control">
					</div>
					<div class="form-group">
						<label for="inputName">Mobile Banner<span class="estricCls">*</span></label>
						<input type="file" name="mobile_banner" value="" id="mobile_banner" class="form-control">
					</div>
					
				  <div class="form-group">
					<label for="inputStatus">Status<span class="estricCls">*</span></label>
					<select name="status" id="status" class="form-control custom-select">
					  <option value="Inactive">Inactive</option>
					  <option value="Active">Active</option>
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

    @include('admin.customjs')
@stop