<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Change Password</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }} ">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">

  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="content">
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
        
                        <form method="post" action="{{ route('api.updatePassword') }}" enctype="multipart/form-data">
                        
                        @csrf
        
                     
        
        
                      <div class="form-group">
                        <label for="inputName">New Password<span class="estricCls">*</span></label>
                        <input type="password" name="new_password" value="" id="new_password" class="form-control @error('new_password') is-invalid @enderror" placeholder="Enter new password"  autocomplete="password"  autofocus>

                        @error('new_password')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror  
        
                        
        
                      </div>
        
        
        
                      <div class="form-group">
                        <label for="inputName">Confirm Password<span class="estricCls">*</span></label>
                        <input type="password" name="confirm_new_password" value="" id="confirm_new_password" class="form-control @error('confirm_new_password') is-invalid @enderror" placeholder="Enter new password again"  autocomplete="confirm_new_password"  autofocus>

                        @error('confirm_new_password')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror  
        
              
                      </div>

                      <input type="hidden" value="{{ $password_token }}" name="password_token" >
        
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
        </div>
    </div>

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>

</body>
</html>