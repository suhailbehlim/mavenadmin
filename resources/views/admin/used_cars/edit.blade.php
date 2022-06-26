 @extends('layouts.masters')

@section('title', 'Edit Car')

@section('content')
<link href="{{url('/public')}}/css/select2.min.css" rel="stylesheet" />
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Car</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>

              <li class="breadcrumb-item"><a href="{{ route('admin.used_cars') }}">Used Cars</a></li>
              <li class="breadcrumb-item active">Edit Car</li>
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
              <h3 class="card-title">Basic Information</h3>
			  <div class="card-tools">
				<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
					<i class="fas fa-minus"></i></button>
				</div>
            </div>
            <div class="card-body">
            	<form method="post" action="{{ route('admin.updateUsedCar', $detail->id) }}" enctype="multipart/form-data">
            		@csrf
					<div class="form-group">
					  <label for="inputStatus">Vehicle Type<span class="estricCls">*</span></label>
					  <select name="vehicle_type" id="vehicle_type" class="form-control custom-select" required>
						@if($vehicle_type)
						@foreach($vehicle_type as $type)
						<option value="{{$type->id}}" @if($detail->vehicle_type==$type->id) selected @endif>{{$type->type}}</option>
						@endforeach
						@endif
					  </select> 
					</div>
					
					<div class="form-group">
					  <label for="inputStatus">Make<span class="estricCls">*</span></label>
					  <select name="make" id="make" class="form-control custom-select" onchange="getModel(this.value);" required>
						@if($make)
						@foreach($make as $km)
						<option value="{{$km['id']}}" @if($detail->make==$km['id']) selected @endif>{{$km['title']}}</option>
						@endforeach
						@endif
					  </select>
					</div>
					<div class="form-group">
					  <label for="inputStatus">Model<span class="estricCls">*</span></label>
					  <select name="model" id="model" class="form-control custom-select" required>
						@if($model)
						@foreach($model as $md)
						<option value="{{$md->id}}" @if($detail->model==$md->id) selected @endif>{{$md->model_id}}-{{$md->title}}</option>
						@endforeach
						@endif
					  </select>
					</div>
					
					<div class="form-group">
					  <label for="inputStatus">Year<span class="estricCls">*</span></label>
						<select name="year" id="year" class="form-control custom-select" required>
						
						</select>
					</div>
					
					<div class="form-group">
						<label for="inputName">Registration Number<span class="estricCls">*</span></label>
						<input type="text" name="registration_number" value="{{$detail->registration_number}}" id="registration_number" class="form-control @error('registration_number') is-invalid @enderror" placeholder="Enter Registration Number" autocomplete="registration_number" required autofocus>

						@error('registration_number')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror  
					</div>
					
					<div class="form-group">
						<label for="inputName">Current Mileage<span class="estricCls">*</span></label>
						<input type="number" name="current_mileage" value="{{$detail->current_mileage}}" id="current_mileage" class="form-control @error('current_mileage') is-invalid @enderror" placeholder="Enter Current Mileage" autocomplete="current_mileage" required autofocus>
						@error('current_mileage')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror  
					</div>
					
					<div class="form-group">
						<label for="inputStatus">Status<span class="estricCls">*</span></label>
						<select name="status" id="status" class="form-control custom-select">
						  <option <?php if($detail->status == 'Inactive') {
							echo 'selected="selected"';
						  } ?>  value="Inactive">Inactive</option>
						  <option <?php if($detail->status == 'Active') {
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

            	<form method="post" action="{{ route('admin.updateUsedCarMetas', $detail->id) }}" enctype="multipart/form-data">
            		@csrf
					
					<div class="form-group">
					  <label for="inputStatus">Trim<span class="estricCls">*</span></label>
					  <select name="trim" id="trim" class="form-control custom-select" required>
					  <?php //print_r($model);die; ?>
						@if($model)
						@foreach($model as $ts)
						<option value="{{$ts->id}}">{{$ts->trim}}</option>
						@endforeach
						@endif
					  </select>
					</div>
					
					<div class="form-group">
					  <label for="inputStatus">Transmission<span class="estricCls">*</span></label>
					  <select name="transmission" id="transmission" class="form-control custom-select" required>
						@if($transmission)
						@foreach($transmission as $trans)
						<option value="{{$trans->id}}" @if($cars_meta->transmission==$trans->id) selected @endif>{{$trans->transmission}}</option>
						@endforeach
						@endif
					  </select> 
					</div>
					<div class="form-group">
					  <label for="inputStatus">No. Of Doors<span class="estricCls">*</span></label>
					  <select name="no_of_doors" id="no_of_doors" class="form-control custom-select" required>
						<option value="2" @if($cars_meta->no_of_doors==2) selected @endif>2</option>
						<option value="3" @if($cars_meta->no_of_doors==3) selected @endif>3</option>
						<option value="4" @if($cars_meta->no_of_doors==4) selected @endif>4</option>
						<option value="5" @if($cars_meta->no_of_doors==5) selected @endif>5</option>
						<option value="6" @if($cars_meta->no_of_doors==6) selected @endif>6</option>
						<option value="7" @if($cars_meta->no_of_doors==7) selected @endif>7</option>
						<option value="8" @if($cars_meta->no_of_doors==8) selected @endif>8</option>
						<option value="9" @if($cars_meta->no_of_doors==9) selected @endif>9</option>
						<option value="10" @if($cars_meta->no_of_doors==10) selected @endif>10</option>
					  </select>
					</div>
					<div class="form-group">
					  <label for="inputStatus">Seating Capacity<span class="estricCls">*</span></label>
					  <select name="seating_capacity" id="seating_capacity" class="form-control custom-select" required>
						<option value="2" @if($cars_meta->seating_capacity==2) selected @endif>2</option>
						<option value="3" @if($cars_meta->seating_capacity==3) selected @endif>3</option>
						<option value="4" @if($cars_meta->seating_capacity==4) selected @endif>4</option>
						<option value="5" @if($cars_meta->seating_capacity==5) selected @endif>5</option>
						<option value="6" @if($cars_meta->seating_capacity==6) selected @endif>6</option>
						<option value="7" @if($cars_meta->seating_capacity==7) selected @endif>7</option>
						<option value="8" @if($cars_meta->seating_capacity==8) selected @endif>8</option>
						<option value="9" @if($cars_meta->seating_capacity==9) selected @endif>9</option>
						<option value="10" @if($cars_meta->seating_capacity==10) selected @endif>10</option>
						<option value="11" @if($cars_meta->seating_capacity==11) selected @endif>11</option>
						<option value="12" @if($cars_meta->seating_capacity==12) selected @endif>12</option>
						<option value="13" @if($cars_meta->seating_capacity==13) selected @endif>13</option>
						<option value="14" @if($cars_meta->seating_capacity==14) selected @endif>14</option>
						<option value="15" @if($cars_meta->seating_capacity==15) selected @endif>15</option>
						<option value="16" @if($cars_meta->seating_capacity==16) selected @endif>16</option>
						<option value="17" @if($cars_meta->seating_capacity==17) selected @endif>17</option>
						<option value="18" @if($cars_meta->seating_capacity==18) selected @endif>18</option>
						<option value="19" @if($cars_meta->seating_capacity==19) selected @endif>19</option>
						<option value="20" @if($cars_meta->seating_capacity==20) selected @endif>20</option>
						<option value="21" @if($cars_meta->seating_capacity==21) selected @endif>21</option>
						<option value="22" @if($cars_meta->seating_capacity==22) selected @endif>22</option>
						<option value="23" @if($cars_meta->seating_capacity==23) selected @endif>23</option>
						<option value="24" @if($cars_meta->seating_capacity==24) selected @endif>24</option>
						<option value="25" @if($cars_meta->seating_capacity==25) selected @endif>25</option>
						<option value="26" @if($cars_meta->seating_capacity==26) selected @endif>26</option>
						<option value="27" @if($cars_meta->seating_capacity==27) selected @endif>27</option>
						<option value="28" @if($cars_meta->seating_capacity==28) selected @endif>28</option>
						<option value="29" @if($cars_meta->seating_capacity==29) selected @endif>29</option>
						<option value="30" @if($cars_meta->seating_capacity==30) selected @endif>30</option>
					  </select>
					</div>
					<div class="form-group">
					  <label for="inputStatus">Body Type<span class="estricCls">*</span></label>
					  <select name="body_type" id="body_type" class="form-control custom-select" required>
						@if($body_type)
						@foreach($body_type as $type)
						<option value="{{$type->id}}" @if($cars_meta->body_type==$type->id) selected @endif>{{$type->body_type}}</option>
						@endforeach
						@endif
					  </select> 
					</div>
					
					<div class="form-group">
						<label for="inputName">Colour of the car<span class="estricCls">*</span></label>
						<input type="text" name="color" value="{{$cars_meta->color}}" id="color" class="form-control @error('color') is-invalid @enderror" placeholder="Enter Colour of the car" autocomplete="color" required autofocus>
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
						<option value="{{$type->id}}" @if($cars_meta->fuel_type==$type->id) selected @endif >{{$type->type}}</option>
						@endforeach
						@endif
					  </select> 
					</div>
					
					<div class="form-group">
					  <label for="inputStatus">Transmission Car type<span class="estricCls">*</span></label>
					  <select name="transmission_type" id="transmission_type" class="form-control custom-select" required>
						<option value="manual" @if($cars_meta->transmission_type=='manual') selected @endif>Manual</option>
						<option value="automatic" @if($cars_meta->transmission_type=='automatic') selected @endif>Automatic</option>
					  </select>
					</div>
					
					<div class="form-group">
						<label for="inputName">Vehicle Summery<span class="estricCls">*</span></label>
						<textarea name="vehicle_summery" id="vehicle_summery" class="form-control @error('vehicle_summery') is-invalid @enderror"  required>{{$cars_meta->vehicle_summery}}</textarea>
						@error('vehicle_summery')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror  
					</div>
					
					<div class="form-group">
						<label for="inputName">Engine capacity<span class="estricCls">*</span></label>
						<input type="text" name="engine_capacity" value="{{$cars_meta->engine_capacity}}" id="engine_capacity" class="form-control @error('engine_capacity') is-invalid @enderror" placeholder="Enter Engine capacity" autocomplete="price" required autofocus>
						@error('engine_capacity')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror  
					</div>
					
					<div class="form-group">
						<label for="inputName">Price<span class="estricCls">*</span></label>
						<input type="number" name="price" value="{{$cars_meta->price}}" id="price" class="form-control @error('price') is-invalid @enderror" placeholder="Enter Price" autocomplete="price" required autofocus>
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
						<option value="1" @if($cars_meta->previous_owners_number==1) selected @endif>1</option>
						<option value="2" @if($cars_meta->previous_owners_number==2) selected @endif>2</option>
						<option value="3" @if($cars_meta->previous_owners_number==3) selected @endif>3</option>
						<option value="4" @if($cars_meta->previous_owners_number==4) selected @endif>4</option>
						<option value="5" @if($cars_meta->previous_owners_number==5) selected @endif>5</option>
						<option value="6" @if($cars_meta->previous_owners_number==6) selected @endif>6</option>
						<option value="7" @if($cars_meta->previous_owners_number==7) selected @endif>7</option>
						<option value="8" @if($cars_meta->previous_owners_number==8) selected @endif>8</option>
						<option value="9" @if($cars_meta->previous_owners_number==9) selected @endif>9</option>
						<option value="10" @if($cars_meta->previous_owners_number==10) selected @endif>10</option>
					  </select>
					</div>
					
					<div class="form-group">
						<label for="inputName">Total Number of Driven KMs<span class="estricCls">*</span></label>
						<input type="number" name="driven_km" value="{{$cars_meta->driven_km}}" id="driven_km" class="form-control @error('driven_km') is-invalid @enderror" placeholder="Enter Total Number of Driven KMs" autocomplete="driven_km" required autofocus>
						@error('driven_km')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror  
					</div>
					<div class="form-group">
					  <label for="inputStatus">History<span class="estricCls">*</span></label>
					  <select name="history" id="history" class="form-control custom-select" required>
						<option value="Accidental" @if($cars_meta->history=='Accidental') selected @endif>Accidental</option>
						<option value="Non-Accidental" @if($cars_meta->history=='Non-Accidental') selected @endif>Non-Accidental</option>
					  </select>
					</div>
					<div class="form-group">
					  <label for="inputStatus">Type of Insurance<span class="estricCls">*</span></label>
					  <select name="insurance" id="insurance" class="form-control custom-select" required>
						<option value="First Party" @if($cars_meta->insurance=='First Party') selected @endif>First Party</option>
						<option value="Third Party" @if($cars_meta->insurance=='Third Party') selected @endif>Third Party</option>
					  </select>
					</div>
					<div class="form-group">
					  <label for="inputStatus">Manufacturer warranty<span class="estricCls">*</span></label>
					  <select name="mfwarranty" id="mfwarranty" class="form-control custom-select" required>
						<option value="Yes" @if($cars_meta->mfwarranty=='Yes') selected @endif>Yes</option>
						<option value="No" @if($cars_meta->mfwarranty=='No') selected @endif>No</option>
					  </select>
					</div>
					<div class="form-group">
						<label for="inputName">Manufacturer warranty expiry date<span class="estricCls">*</span></label>
						<input type="date" name="mfwarrantydate" value="{{$cars_meta->mfwarrantydate}}" id="mfwarrantydate" class="form-control @error('mfwarrantydate') is-invalid @enderror" placeholder="Enter Manufacturer warranty expiry date" autocomplete="mfwarrantydate" required autofocus>
						@error('mfwarrantydate')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror  
					</div>
					<div class="form-group">
						<label for="inputName">Drivetrain<span class="estricCls">*</span></label>
						<input type="text" name="drivetrain" value="{{$cars_meta->drivetrain}}" id="drivetrain" class="form-control @error('drivetrain') is-invalid @enderror" placeholder="Enter Drivetrain" autocomplete="drivetrain" required autofocus>
						@error('drivetrain')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror  
					</div>
					<div class="form-group">
						<label for="inputName">Fuel tank capacity (liters)<span class="estricCls">*</span></label>
						<input type="text" name="ftc" value="{{$cars_meta->ftc}}" id="ftc" class="form-control @error('ftc') is-invalid @enderror" placeholder="Enter Fuel tank capacity" autocomplete="ftc" required autofocus>
						@error('ftc')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror  
					</div>
					<div class="form-group">
						<label for="inputName">Mileage (kmpl)<span class="estricCls">*</span></label>
						<input type="text" name="mileage" value="{{$cars_meta->mileage}}" id="mileage" class="form-control @error('mileage') is-invalid @enderror" placeholder="Enter mileage" autocomplete="mileage" required autofocus>
						@error('mileage')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror  
					</div>
					<div class="form-group">
						<label for="inputName">Steering type<span class="estricCls">*</span></label>
						<input type="text" name="steering_type" value="{{$cars_meta->steering_type}}" id="steering_type" class="form-control @error('steering_type') is-invalid @enderror" placeholder="Enter Steering type" autocomplete="steering_type" required autofocus>
						@error('steering_type')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror  
					</div>
					<div class="form-group">
						<label for="inputName">Suspension front<span class="estricCls">*</span></label>
						<input type="text" name="suspension_front" value="{{$cars_meta->suspension_front}}" id="suspension_front" class="form-control @error('suspension_front') is-invalid @enderror" placeholder="Enter Suspension front" autocomplete="suspension_front" required autofocus>
						@error('suspension_front')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror  
					</div>
					
					
					
					<div class="form-group">
						<label for="inputName">Comment by Seller<span class="estricCls">*</span></label>
						<input type="text" name="seller_comment" value="{{$cars_meta->seller_comment}}" id="seller_comment" class="form-control @error('seller_comment') is-invalid @enderror" placeholder="Enter Comment by Seller" autocomplete="seller_comment" required autofocus>
						@error('seller_comment')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror  
					</div>
					
					<div class="form-group">
						<label for="inputName">Reason for Sell<span class="estricCls">*</span></label>
						<input type="text" name="reason_sell" value="{{$cars_meta->reason_sell}}" id="reason_sell" class="form-control @error('reason_sell') is-invalid @enderror" placeholder="Enter Reason for Sell" autocomplete="reason_sell" required autofocus>
						@error('reason_sell')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror  
					</div>
					
					<div class="form-group">
					  <label for="inputStatus">Condition of the Car<span class="estricCls">*</span></label>
					  <select name="condition" id="condition" class="form-control custom-select" required>
						<option value="Not Running" @if($cars_meta->condition=='Not Running') selected @endif>Not Running</option>
						<option value="Running, but there are some issues" @if($cars_meta->condition=='Running, but there are some issues') selected @endif>Running, but there are some issues</option>
						<option value="Good" @if($cars_meta->condition=='Good') selected @endif>Good</option>
					  </select>
					</div>
					 
					<div class="form-group">
						<label for="inputName">Car Images<span class="estricCls">*</span></label>
						<input type="file" name="images[]" value="" id="multiple_images" class="form-control" multiple>
						<label for="inputName" >Car Images: </label>
						@if( $cars_meta->images !='')
							<?php $impl = explode(',',$cars_meta->images);
							foreach($impl as $img){ ?>
								<img src="{{ URL::to('/public') }}/uploads/cars_images/<?php echo $img; ?>" width="100">
							<?php } ?>
						@else 
							NA
						@endif
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
<script>
setTimeout(function(){ $("#year").val('{{$detail->year}}'); }, 2000);
</script>
    @include('admin.customjs')

@stop