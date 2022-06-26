 @extends('layouts.masters')

@section('title', 'Edit Educator')

@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Educator</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>

              <li class="breadcrumb-item"><a href="{{ route('admin.dealers') }}">Educator List</a></li>
              <li class="breadcrumb-item active">Edit Educator</li>
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

            	<form method="post" action="{{ route('admin.updateDealer', $customerInfo['id']) }}" enctype="multipart/form-data">
            		@csrf

                <div class="form-group">
                <label for="inputName">Name<span class="estricCls">*</span></label>
                <input type="text" name="name" value="{{$customerInfo['name']}}" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter name"  autocomplete="name" required autofocus>

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>

              <div class="form-group">
                <label for="inputName">Email Address<span class="estricCls">*</span></label>
                <input type="email" name="email" id="email" value="{{$customerInfo['email']}}" class="form-control @error('email') is-invalid @enderror" placeholder="Enter email" required autocomplete="email" autofocus>

	              @error('email')
	                    <span class="invalid-feedback" role="alert">
	                        <strong>{{ $message }}</strong>
	                    </span>              
	              @enderror                
              </div>

              <div class="form-group">
                <label for="inputName">Phone No.<span class="estricCls">*</span></label>
                <input type="text" name="phone" id="phone" value="{{$customerInfo['phone']}}" class="form-control @error('phone') is-invalid @enderror" placeholder="Enter phone no." required autocomplete="phone" autofocus>

	              @error('phone')
	                    <span class="invalid-feedback" role="alert">
	                        <strong>{{ $message }}</strong>
	                    </span>              
	              @enderror                
              </div>


              <div class="form-group">
                <label for="inputName">Age<span class="estricCls">*</span></label>
                <input type="text" name="age" id="age" value="{{$customerInfo['age']}}" class="form-control @error('age') is-invalid @enderror" placeholder="Enter flat no." required autocomplete="age" autofocus>

	              @error('age')
	                    <span class="invalid-feedback" role="alert">
	                        <strong>{{ $message }}</strong>
	                    </span>              
	              @enderror                
              </div>                
			  
			  <div class="form-group">
                <label for="inputName">Education History<span class="estricCls">*</span></label>
                <input type="text" name="education_history" id="education_history" value="{{$customerInfo['education_history']}}" class="form-control @error('education_history') is-invalid @enderror" placeholder="Enter education history." required autocomplete="education_history" autofocus>
	              @error('education_history')
	                    <span class="invalid-feedback" role="alert">
	                        <strong>{{ $message }}</strong>
	                    </span>              
	              @enderror                
              </div>
			  <div class="form-group">
                <label for="inputName">Address<span class="estricCls">*</span></label>
                <input type="text" name="address" id="address" value="{{$customerInfo['address']}}" class="form-control @error('address') is-invalid @enderror" placeholder="Enter address." required autocomplete="address" autofocus>

	              @error('address')
	                    <span class="invalid-feedback" role="alert">
	                        <strong>{{ $message }}</strong>
	                    </span>              
	              @enderror                
              </div>
			  
				<div class="form-group">
					<label for="inputName">Income<span class="estricCls">*</span></label>
					<input type="text" name="income" id="income" value="{{$customerInfo['income']}}" class="form-control @error('income') is-invalid @enderror" placeholder="Enter income." required autocomplete="income" autofocus>

					  @error('income')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>              
					  @enderror                
				  </div>

              <div class="form-group">
                <label for="inputStatus">Status<span class="estricCls">*</span></label>
                <select name="status" id="status" class="form-control custom-select">
                  <option <?php if($customerInfo['status'] == 'Inactive') {
                    echo 'selected="selected"';
                  } ?>  value="Inactive">Inactive</option>
                  <option <?php if($customerInfo['status'] == 'Active') {
                    echo 'selected="selected"';
                  } ?> value="Active">Active</option>
                </select>
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