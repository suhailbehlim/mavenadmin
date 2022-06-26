 @extends('layouts.masters')

@section('title', 'Update Charges')

@section('content')

    <section class="content-header">

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

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Update Charges</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Update Charges</li>
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

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">

            

          <form method="post" action="{{ route('admin.saveCharges') }}" enctype="multipart/form-data">
            @csrf

          <div class="form-group">
            <label for="inputName">Boost charge for customer<span class="estricCls">*</span></label>
            <input type="text" name="boost_charge_for_customer" value="@if($chargesInfo['boost_charge_for_customer']){{ $chargesInfo['boost_charge_for_customer'] }}@endif" id="boost_charge_for_customer" class="form-control @error('boost_charge_for_customer') is-invalid @enderror" placeholder="Enter boost charge"  autocomplete="boost_charge_for_customer" required autofocus>

            @error('boost_charge_for_customer')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror  


          </div>



          <div class="form-group">
            <label for="inputName">Sponser charge for customer<span class="estricCls">*</span></label>
            <input type="text" name="sponser_charge_for_customer" value="{{ $chargesInfo['sponser_charge_for_customer'] }}" id="sponser_charge_for_customer" class="form-control @error('sponser_charge_for_customer') is-invalid @enderror" placeholder="Enter sponser charge"  autocomplete="sponser_charge_for_customer" required autofocus>

            @error('sponser_charge_for_customer')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror  


          </div>          


          <div class="form-group">
            <label for="inputName">Boost charge for dealer<span class="estricCls">*</span></label>
            <input type="text" name="boost_charge_for_dealer" value="{{ $chargesInfo['boost_charge_for_dealer'] }}" id="boost_charge_for_dealer" class="form-control @error('boost_charge_for_dealer') is-invalid @enderror" placeholder="Enter boost charge"  autocomplete="boost_charge_for_dealer" required autofocus>

            @error('boost_charge_for_dealer')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror  


          </div>          

          
          <div class="form-group">
            <label for="inputName">Sponser charge for dealer<span class="estricCls">*</span></label>
            <input type="text" name="sponser_charge_for_dealer" value="{{ $chargesInfo['sponser_charge_for_dealer'] }}" id="sponser_charge_for_dealer" class="form-control @error('sponser_charge_for_dealer') is-invalid @enderror" placeholder="Enter sponser charge"  autocomplete="sponser_charge_for_dealer" required autofocus>

            @error('sponser_charge_for_dealer')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror  


          </div> 
			<div class="form-group">
            <label for="inputName">360 Degree Photography Charges<span class="estricCls">*</span></label>
            <input type="text" name="photocharge" value="{{$mix->photography_price}}" id="photocharge" class="form-control @error('photocharge') is-invalid @enderror" placeholder="Enter 360 Degree Photography Charges"  autocomplete="photocharge" required autofocus>

            @error('photocharge')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror  


          </div> 	
			<div class="form-group">
            <label for="inputName">Inspection Charges<span class="estricCls">*</span></label>
            <input type="text" name="inspcharge" value="{{$mix->inspection_price}}" id="inspcharge" class="form-control @error('inspcharge') is-invalid @enderror" placeholder="Enter Inspection Charges"  autocomplete="inspcharge" required autofocus>

            @error('inspcharge')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror  


          </div> 

          <div class="form-group">
            <input type="submit" name="Save" value="Update" class="btn btn-success">
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