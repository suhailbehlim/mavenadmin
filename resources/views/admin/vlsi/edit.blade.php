@extends('layouts.masters')

@section('title', 'Edit VLSI')

@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit VLSI</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>

              <li class="breadcrumb-item"><a href="{{ route('admin.vlsiList') }}">VLSI List</a></li>
              <li class="breadcrumb-item active">Edit VLSI</li>
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

              
            </div>
            <div class="card-body">

            	<form method="post" action="{{ route('admin.updatevlsi', $testoInfo->id) }}" enctype="multipart/form-data">
            		@csrf

                <div class="form-group">
                  <label for="inputName">Title<span class="estricCls">*</span></label>
                  <input type="text" name="title" value="{{ $testoInfo->title}}" id="title" class="form-control @error('title') is-invalid @enderror" placeholder="Enter title"  autocomplete="title" required autofocus>
  
                  @error('title')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror  
                </div>
              <div class="form-group">
                <label for="inputName">Category<span class="estricCls">*</span></label>
                <input type="text" name="category" value="{{ $testoInfo->category}}" id="category" class="form-control @error('category') is-invalid @enderror" placeholder="Enter category"  autocomplete="category" required autofocus>

                @error('category')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
              <div class="form-group">
                <label for="inputName">Date<span class="estricCls">*</span></label>
                <input type="date" name="date" value="{{$testoInfo->date}}" id="date" class="form-control @error('date') is-invalid @enderror" autofocus>

                @error('date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
              <div class="form-group">
                <label for="inputName">Video<span class="estricCls">*</span></label>
                <input type="file" name="video" value="{{ $testoInfo->video}}" id="video" class="form-control @error('video') is-invalid @enderror" placeholder="Enter video"  autocomplete="video" autofocus>

                @error('video')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
              <div class="form-group">
                <label for="inputName">PDF<span class="estricCls">*</span></label>
                <input type="file" name="pdf" value="{{ $testoInfo->pdf}}" id="video" class="form-control @error('pdf') is-invalid @enderror" placeholder="Enter pdf"  autocomplete="pdf" autofocus>

                @error('pdf')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
              <div class="form-group">
                <label for="inputName">Description<span class="estricCls">*</span></label>
                <textarea type="text" name="description"  id="description" class="form-control @error('description') is-invalid @enderror" placeholder="Enter description"  autocomplete="description" autofocus>{{ $testoInfo->description}}</textarea>
                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
              
              
              <div class="form-group">
                <label for="inputStatus">Status<span class="estricCls">*</span></label>
                <select name="status" id="status" class="form-control custom-select">
                  <option <?php if($testoInfo->status == 'Inactive') {
                    echo 'selected="selected"';
                  } ?>  value="Inactive">Inactive</option>
                  <option <?php if($testoInfo->status == 'Active') {
                    echo 'selected="selected"';
                  } ?> value="Active">Active</option>
                </select>
              </div>
              <div class="form-group">
			  <input type="hidden" name="id" value="{{$testoInfo->id}}" id="id">
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