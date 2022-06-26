 @extends('layouts.masters')

@section('title', 'Banner')

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

              <li class="breadcrumb-item"><a href="{{ route('admin.workshopindex') }}">List</a></li>
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

            	<form method="post" action="{{ route('admin.storeLifeBanners') }}" enctype="multipart/form-data">
            		@csrf

              <div class="form-group">
                <label for="inputName">Title<span class="estricCls">*</span></label>
                <input type="text" name="title"  id="slug" class="form-control @error('title') is-invalid @enderror" placeholder="Enter title"  autocomplete="title" required autofocus>

                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
				<div class="form-group">
                <label for="inputName">Banner<span class="estricCls">*</span></label>
                <input type="file" name="banner" value="" id="banner" class="form-control @error('pdf') is-invalid @enderror" placeholder="Enter pdf"  autocomplete="pdf" autofocus>

                @error('pdf')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
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