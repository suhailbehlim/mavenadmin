 @extends('layouts.masters')

@section('title', 'Add Used Car')

@section('content')
<link href="{{url('/public')}}/css/select2.min.css" rel="stylesheet" />

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Step 2</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Step 2</li>
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
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Car Meta</h3>
			  <div class="card-tools">
				<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
					<i class="fas fa-minus"></i></button>
				</div>
            </div>
            <div class="card-body">

            	<form method="post" action="{{ route('admin.storeUsedCarStep2', $car_id) }}" enctype="multipart/form-data">
            		@csrf
					<div class="form-group">
					  <label for="inputStatus">Trim<span class="estricCls">*</span></label>
					  <select name="trim" id="trim" class="form-control custom-select" required>
						@if($car_models)
						@foreach($car_models as $trim)
						<option value="{{$trim->id}}">{{$trim->trim}}</option>
						@endforeach
						@endif
					  </select>
					</div>
					
					<div class="form-group">
					  <label for="inputStatus">Transmission<span class="estricCls">*</span></label>
					  <select name="transmission" id="transmission" class="form-control custom-select" required>
						@if($transmission)
						@foreach($transmission as $trans)
						<option value="{{$trans->id}}">{{$trans->transmission}}</option>
						@endforeach
						@endif
					  </select> 
					</div>
					<div class="form-group">
					  <label for="inputStatus">No. Of Doors<span class="estricCls">*</span></label>
					  <select name="no_of_doors" id="no_of_doors" class="form-control custom-select" required>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
						<option value="7">7</option>
						<option value="8">8</option>
						<option value="9">9</option>
						<option value="10">10</option>
					  </select>
					</div>
					<div class="form-group">
					  <label for="inputStatus">Seating Capacity<span class="estricCls">*</span></label>
					  <select name="seating_capacity" id="seating_capacity" class="form-control custom-select" required>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
						<option value="7">7</option>
						<option value="8">8</option>
						<option value="9">9</option>
						<option value="10">10</option>
						<option value="11">11</option>
						<option value="12">12</option>
						<option value="13">13</option>
						<option value="14">14</option>
						<option value="15">15</option>
						<option value="16">16</option>
						<option value="17">17</option>
						<option value="18">18</option>
						<option value="19">19</option>
						<option value="20">20</option>
						<option value="21">21</option>
						<option value="22">22</option>
						<option value="23">23</option>
						<option value="24">24</option>
						<option value="25">25</option>
						<option value="26">26</option>
						<option value="27">27</option>
						<option value="28">28</option>
						<option value="29">29</option>
						<option value="30">30</option>
					  </select>
					</div>
					<div class="form-group">
					  <label for="inputStatus">Body Type<span class="estricCls">*</span></label>
					  <select name="body_type" id="body_type" class="form-control custom-select" required>
						@if($body_type)
						@foreach($body_type as $type)
						<option value="{{$type->id}}">{{$type->body_type}}</option>
						@endforeach
						@endif
					  </select> 
					</div>
					
					<div class="form-group">
						<label for="inputName">Colour of the car<span class="estricCls">*</span></label>
						<input type="text" name="color" value="" id="color" class="form-control @error('color') is-invalid @enderror" placeholder="Enter Colour of the car" autocomplete="color" required autofocus>
						@error('color')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror  
					</div>
					
					<div class="form-group">
					  <label for="inputStatus">Fuel Type<span class="estricCls">*</span></label>
					  <select name="fuel_type" id="fuel_type" class="form-control custom-select" required>
						@if($fuel_type)
						@foreach($fuel_type as $type)
						<option value="{{$type->id}}">{{$type->type}}</option>
						@endforeach
						@endif
					  </select> 
					</div>
					
					<div class="form-group">
					  <label for="inputStatus">Transmission Car type<span class="estricCls">*</span></label>
					  <select name="transmission_type" id="transmission_type" class="form-control custom-select" required>
						<option value="manual">Manual</option>
						<option value="automatic">Automatic</option>
					  </select>
					</div>
					
					<div class="form-group">
						<label for="inputName">Vehicle Summery<span class="estricCls">*</span></label>
						<textarea name="vehicle_summery" id="vehicle_summery" class="form-control @error('vehicle_summery') is-invalid @enderror"  required></textarea>
						@error('vehicle_summery')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror  
					</div>
					
					<div class="form-group">
						<label for="inputName">Engine capacity<span class="estricCls">*</span></label>
						<input type="text" name="engine_capacity" value="" id="engine_capacity" class="form-control @error('engine_capacity') is-invalid @enderror" placeholder="Enter Engine capacity" autocomplete="price" required autofocus>
						@error('engine_capacity')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror  
					</div>
					
					<div class="form-group">
						<label for="inputName">Price<span class="estricCls">*</span></label>
						<input type="number" name="price" value="" id="price" class="form-control @error('price') is-invalid @enderror" placeholder="Enter Price" autocomplete="price" required autofocus>
						@error('price')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror  
					</div>
					
					<div class="form-group">
						<div id="clr_cont" class="contains">
							<label for="inputStatus">Features<span class="estricCls">*</span></label>
							<select class="fav_clr form-control" name="features[]" multiple="multiple">
								@if($features)
								@foreach($features as $ft)
								<optgroup label="{{$ft['name']}}">
									@if($ft['child'])
									@foreach($ft['child'] as $child)
									<option value="{{$child->id}}">{{$child->child}}</option>
									@endforeach
									@endif
								</optgroup>
								@endforeach
								@endif
							</select>
						</div>
					</div>
					
					<div class="form-group">
					  <label for="inputStatus">Number of Previous Owners<span class="estricCls">*</span></label>
					  <select name="previous_owners_number" id="previous_owners_number" class="form-control custom-select" required>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
						<option value="7">7</option>
						<option value="8">8</option>
						<option value="9">9</option>
						<option value="10">10</option>
					  </select>
					</div>
					
					<div class="form-group">
						<label for="inputName">Total Number of Driven KMs<span class="estricCls">*</span></label>
						<input type="number" name="driven_km" value="" id="driven_km" class="form-control @error('driven_km') is-invalid @enderror" placeholder="Enter Total Number of Driven KMs" autocomplete="driven_km" required autofocus>
						@error('driven_km')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror  
					</div>
					<div class="form-group">
					  <label for="inputStatus">History<span class="estricCls">*</span></label>
					  <select name="history" id="history" class="form-control custom-select" required>
						<option value="Accidental">Accidental</option>
						<option value="Non-Accidental">Non-Accidental</option>
					  </select>
					</div>
					<div class="form-group">
					  <label for="inputStatus">Type of Insurance<span class="estricCls">*</span></label>
					  <select name="insurance" id="insurance" class="form-control custom-select" required>
						<option value="First Party">First Party</option>
						<option value="Third Party">Third Party</option>
					  </select>
					</div>
					<div class="form-group">
					  <label for="inputStatus">Manufacturer warranty<span class="estricCls">*</span></label>
					  <select name="mfwarranty" id="mfwarranty" class="form-control custom-select" required>
						<option value="Yes">Yes</option>
						<option value="No">No</option>
					  </select>
					</div>
					<div class="form-group">
						<label for="inputName">Manufacturer warranty expiry date<span class="estricCls">*</span></label>
						<input type="date" name="mfwarrantydate" value="" id="mfwarrantydate" class="form-control @error('mfwarrantydate') is-invalid @enderror" placeholder="Enter Manufacturer warranty expiry date" autocomplete="mfwarrantydate" required autofocus>
						@error('mfwarrantydate')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror  
					</div>
					<div class="form-group">
						<label for="inputName">Drivetrain<span class="estricCls">*</span></label>
						<input type="text" name="drivetrain" value="" id="drivetrain" class="form-control @error('drivetrain') is-invalid @enderror" placeholder="Enter Drivetrain" autocomplete="drivetrain" required autofocus>
						@error('drivetrain')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror  
					</div>
					<div class="form-group">
						<label for="inputName">Fuel tank capacity (liters)<span class="estricCls">*</span></label>
						<input type="text" name="ftc" value="" id="ftc" class="form-control @error('ftc') is-invalid @enderror" placeholder="Enter Fuel tank capacity" autocomplete="ftc" required autofocus>
						@error('ftc')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror  
					</div>
					<div class="form-group">
						<label for="inputName">Mileage (kmpl)<span class="estricCls">*</span></label>
						<input type="text" name="mileage" value="" id="mileage" class="form-control @error('mileage') is-invalid @enderror" placeholder="Enter mileage" autocomplete="mileage" required autofocus>
						@error('mileage')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror  
					</div>
					<div class="form-group">
						<label for="inputName">Steering type<span class="estricCls">*</span></label>
						<input type="text" name="steering_type" value="" id="steering_type" class="form-control @error('steering_type') is-invalid @enderror" placeholder="Enter Steering type" autocomplete="steering_type" required autofocus>
						@error('steering_type')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror  
					</div>
					<div class="form-group">
						<label for="inputName">Suspension front<span class="estricCls">*</span></label>
						<input type="text" name="suspension_front" value="" id="suspension_front" class="form-control @error('suspension_front') is-invalid @enderror" placeholder="Enter Suspension front" autocomplete="suspension_front" required autofocus>
						@error('suspension_front')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror  
					</div>
					<div class="form-group">
						<label for="inputName">Comment by Seller<span class="estricCls">*</span></label>
						<input type="text" name="seller_comment" value="" id="seller_comment" class="form-control @error('seller_comment') is-invalid @enderror" placeholder="Enter Comment by Seller" autocomplete="seller_comment" required autofocus>
						@error('seller_comment')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror  
					</div>
					
					<div class="form-group">
						<label for="inputName">Reason for Sell<span class="estricCls">*</span></label>
						<input type="text" name="reason_sell" value="" id="reason_sell" class="form-control @error('reason_sell') is-invalid @enderror" placeholder="Enter Reason for Sell" autocomplete="reason_sell" required autofocus>
						@error('reason_sell')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror  
					</div>
					
					<div class="form-group">
					  <label for="inputStatus">Condition of the Car<span class="estricCls">*</span></label>
					  <select name="condition" id="condition" class="form-control custom-select" required>
						<option value="Not Running">Not Running</option>
						<option value="Running, but there are some issues">Running, but there are some issues</option>
						<option value="Good">Good</option>
					  </select>
					</div>
					 
					<div class="form-group">
						<label for="inputName">Car Images<span class="estricCls">*</span></label>
						<input type="file" name="images[]" value="" id="multiple_images" class="form-control" multiple>
					</div>

          
              <div class="form-group">
               <input type="submit" name="Update" value="Save" class="btn btn-success">
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
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
<script>
$(document).ready(function() {
    $('.fav_clr').select2({
		placeholder: 'Search Features', 
		width: '100%',
    });
});

$('.fav_clr').on("select2:select", function (e) { 
	var data = e.params.data.text;
	if(data=='all'){
		$(".fav_clr > option").prop("selected","selected");
		$(".fav_clr").trigger("change");
	}
});
</script>
@include('admin.customjs')
@stop