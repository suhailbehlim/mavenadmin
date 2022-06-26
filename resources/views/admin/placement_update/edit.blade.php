 @extends('layouts.masters')

@section('title', 'Edit Partner')

@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Placement</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>

              <li class="breadcrumb-item"><a href="{{ route('admin.partner') }}">Placement List</a></li>
              <li class="breadcrumb-item active">Edit Placement</li>
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

              <form method="post" action="{{ route('admin.update-placement-update', $testoInfo->id) }}" enctype="multipart/form-data">
                @csrf

 
 <div class="form-group">
                <label for="name">Name</label>
            
                  <input name="name" id="name" class="form-control custom-select" type="text" value="{{ $testoInfo->name}}" placeholder="Enter name" autocomplete="name"  autofocus>
   
              </div>
               <div class="form-group">
                <label for="designation">Designation</label>
            
                  <input name="designation" id="designation" class="form-control custom-select" type="text" value="{{ $testoInfo->designation}}" placeholder="Enter designation" autocomplete="designation"  autofocus>
   
              </div>
              <div class="form-group">
                <label for="company">Company</label>
            
                  <input name="company" id="company" class="form-control custom-select" type="text" value="{{ $testoInfo->company}}" placeholder="Enter company" autocomplete="company"  autofocus>
   
              </div>
                    
            
            <!--   <div class="form-group">
                <label for="inputName">Image</label>
                <input type="file" name="image"  id="image" class="form-control">
                <img src="{{ asset($testoInfo->image)}}" width="50" height="50">
              </div> -->

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