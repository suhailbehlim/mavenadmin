 @extends('layouts.masters')

@section('title', 'Change Password')

@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Change Password</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Change Password</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


        <!-- Main content -->
    <section class="content">

        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>    
            <strong>{{ $message }}</strong>
        </div>
        @endif
          
        @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>    
            <strong>{{ $message }}</strong>
        </div>
        @endif
      
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">General Details</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">

            	<form method="post" action="{{ route('admin.updatePassword') }}" enctype="multipart/form-data">
            		@csrf

              <div class="form-group">
                <label for="inputName">Old Password<span class="estricCls">*</span></label>
                <input type="password" name="oldPassword" value="" id="password" class="form-control @error('oldPassword') is-invalid @enderror" placeholder="Enter old password"  autocomplete="oldPassword" required autofocus>

                @error('oldPassword')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  

              </div>


              <div class="form-group">
                <label for="inputName">New Password<span class="estricCls">*</span></label>
                <input type="password" name="password" value="" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter new password"  autocomplete="password" required autofocus>

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  

              </div>



              <div class="form-group">
                <label for="inputName">Confirm Password<span class="estricCls">*</span></label>
                <input type="password" name="password_confirmation" value="" id="password-confirm" class="form-control" placeholder="Enter new password again"  autocomplete="password_confirmation" required autofocus>

      
              </div>

              <div class="form-group">
               <input type="submit" name="Save" value="Change Password" class="btn btn-success">
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