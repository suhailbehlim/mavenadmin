@extends('layouts.masters')

@section('title', 'Edit Car Model')

@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Car Model</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>

              <li class="breadcrumb-item"><a href="{{ route('admin.car_models') }}">Car Model List</a></li>
              <li class="breadcrumb-item active">Edit Car Model</li>
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

            	<form method="post" action="{{ route('admin.updateModel', $modelId) }}" enctype="multipart/form-data">
            		@csrf
				<div class="form-group">
                <label for="inputName">Model ID<span class="estricCls">*</span></label>
                <input type="text" name="model_id" value="{{ $modelInfo['model_id'] }}" id="name" class="form-control @error('model_id') is-invalid @enderror" placeholder="Enter Model ID"  autocomplete="model_id" required autofocus>

                @error('model_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
				<div class="form-group">
				  <label for="inputStatus">Make<span class="estricCls">*</span></label>
				  <select name="make" id="make" class="form-control custom-select">
					@if($make)
					@foreach($make as $km)
					<option value="{{$km['id']}}" @if($modelInfo['make']==$km['id']) selected @endif>{{$km['title']}}</option>
					@endforeach
					@endif
				  </select>
				</div>
              <div class="form-group">
                <label for="inputName">Model<span class="estricCls">*</span></label>
                <input type="text" name="title" value="{{ $modelInfo['title'] }}" id="name" class="form-control @error('title') is-invalid @enderror" placeholder="Enter Model"  autocomplete="title" required autofocus>

                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
				<div class="form-group">
					<label for="inputName">Trim<span class="estricCls">*</span></label>
					<input type="text" name="trim" value="{{ $modelInfo['title'] }}" id="trim" class="form-control @error('trim') is-invalid @enderror" placeholder="Enter trim"  autocomplete="trim" required autofocus>

					@error('trim')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror  
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

@stop