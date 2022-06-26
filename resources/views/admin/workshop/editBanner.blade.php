 @extends('layouts.masters')

@section('title', 'Banner')

@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Banner</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>

              <li class="breadcrumb-item"><a href="{{ route('admin.workshopindex') }}">List</a></li>
              <li class="breadcrumb-item active">Edit Banner</li>
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

            	<form method="post" action="{{ route('admin.updateLifeBanners') }}" enctype="multipart/form-data">
            		@csrf
               
<div class="form-group">
                <label for="section">Section<span class="estricCls">*</span></label>
                <select name="section" class="form-control">
                <option value="main" @if($testoInfo->section == 'main') selected @endif>Main</option>
                 <option value="corporate-training" @if($testoInfo->section == 'corporate-training') selected @endif>corporate-training</option>
                 <option value="connect-with-us" @if($testoInfo->section == 'connect-with-us') selected @endif>connect-with-us</option>
                 <option value="workshop" @if($testoInfo->section == 'workshop') selected @endif>workshop</option>
                 <option value="placements" @if($testoInfo->section == 'placements') selected @endif>placements</option>
                 <option value="career" @if($testoInfo->section == 'career') selected @endif>career</option>
               </select>

                @error('section')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>

              <div class="form-group">
                <label for="inputName">Title<span class="estricCls">*</span></label>
                <input type="text" name="title" value="{{$life_banners->title}}"  id="slug" class="form-control @error('title') is-invalid @enderror" placeholder="Enter title"  autocomplete="title" required autofocus>

                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
				<div class="form-group">
                <label for="inputName">Banner<span class="estricCls">*</span></label>
                <input type="file" name="banner" value="" id="banner" class="form-control @error('pdf') is-invalid @enderror" placeholder="Enter pdf"  autocomplete="pdf" autofocus>

				@if($life_banners->banner !='')
					<img src="{{ URL::to('/public') }}/system/global/{{$life_banners->banner}}" width="100">
				@else 
					NA
				@endif
              </div>
              <div class="form-group">
			  <input type="hidden" name="id" value="{{$life_banners->id}}" id="id">
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