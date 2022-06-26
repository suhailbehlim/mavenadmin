 @extends('layouts.masters')

@section('title', 'Add Testomonial')

@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Testimonial</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>

              <li class="breadcrumb-item"><a href="{{ route('admin.testomonialList') }}">Testimonial List</a></li>
              <li class="breadcrumb-item active">Add Testimonial</li>
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

            	<form method="post" action="{{ route('admin.storeTestomonial') }}" enctype="multipart/form-data">
            		@csrf

              <div class="form-group">
                <label for="inputName">Name<span class="estricCls">*</span></label>
                <input type="text" name="name"  id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter name"  autocomplete="name" required autofocus>

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
			  
              <div class="form-group">
                <label for="type">Type<span class="estricCls">*</span></label>
             <div class="form-group">
              
              <select name="type" class="form-control">
                <option value="Normal" @if(old('type') == 'Normal') selected @endif>Normal</option>
                <option value="Google" @if(old('type') == 'Google') selected @endif>Google</option>
                <option value="From the Maven Silicon Community" @if(old('type') == 'From the Maven Silicon Community') selected @endif>From the Maven Silicon Community</option>
                <option value="Academia Testimonials" @if(old('type') == 'Academia Testimonials') selected @endif>Academia Testimonials</option>
				<option value="Alumini Reviews" @if(old('type') == 'Alumini Reviews') selected @endif>Alumini Reviews</option>
				<option value="Recruiters Reviews" @if(old('type') == 'Recruiters Reviews') selected @endif>Recruiters Reviews</option>
                <option value="Our CEO" @if(old('type') == 'Our CEO') selected @endif>Our CEO</option>
              </select>
            </div>
                                 
                  
              </div>
              
              <div class="form-group">
                <label for="inputStatus"> Category<span class="estricCls">*</span></label>
                <select name="category" id="category" class="form-control custom-select">
                @if($category)
                @foreach($category as $km)
                <option value="{{$km->name}}">{{$km->name}}</option>
                @endforeach
                @endif
                 <option value="other" @if(old('category')== 'other') selected @endif>Other</option>
                </select>
              </div>

              <div class="form-group">
                <label for="inputName">Image<span class="estricCls">*</span></label>
                <input type="file" name="image"  id="image" class="form-control">
              </div>
              <div class="form-group">
                <label for="inputName">Testimonial Video<span class="estricCls">*</span></label>
                <input type="file" name="video"  id="video" class="form-control">
              </div>
              <div class="form-group">
                <label for="inputName">Description<span class="estricCls">*</span></label>
                <textarea type="text" name="description"  id="description" class="form-control @error('description') is-invalid @enderror" placeholder="Enter description"  autocomplete="description"  autofocus ></textarea>

                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
               <div class="form-group">
                <label for="url">URL<span class="estricCls">*</span></label>
            
                  <input name="url" id="url" class="form-control custom-select" type="text" value="{{ old('url') }}" placeholder="Enter url" autocomplete="type"  autofocus>
              </div>
              <div class="form-group">
                <label for="position">Position<span class="estricCls">*</span></label>
            
                  <input name="position" id="position" class="form-control custom-select" type="text" value="{{ old('position') }}" placeholder="Enter Position" autocomplete="position"  autofocus>
              </div>
              <div class="form-group">
                <label for="review">Total Review<span class="estricCls">*</span></label>
            
                  <input name="review" id="review" class="form-control custom-select" type="number" value="{{ old('review') }}" placeholder="Enter Total review" autocomplete="review"  autofocus>
              </div>
              <div class="form-group">
                <label for="photos">Total photos<span class="estricCls">*</span></label>
            
                  <input name="photos" id="photos" class="form-control custom-select" type="number" value="{{ old('photos') }}" placeholder="Enter Total photos" autocomplete="photos"  autofocus>
              </div>
              <div class="form-group">
                <label for="like">Total like<span class="estricCls">*</span></label>
            
                  <input name="like" id="like" class="form-control custom-select" type="number" value="{{ old('like') }}" placeholder="Enter Total like" autocomplete="like"  autofocus>
              </div>
              <div class="form-group">
                <label for="positive">Positive<span class="estricCls">*</span></label>
            
                  <input name="positive" id="positive" class="form-control custom-select" type="text" value="{{ old('positive') }}" placeholder="Enter positive" autocomplete="positive"  autofocus>
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

@stop