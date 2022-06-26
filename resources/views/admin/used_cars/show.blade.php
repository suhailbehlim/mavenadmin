@extends('layouts.masters')

@section('title', 'Dealer Profile')

@section('content')


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

<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Used Car</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>

            <li class="breadcrumb-item"><a href="{{ route('admin.used_cars') }}">Car List</a></li>
            <li class="breadcrumb-item active">Car</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>


        <!-- Main content -->
        <section class="content">
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
            
                            <div class="form-group">
                            <label for="inputName">Vehicle Type: </label>
                                @if($vehicle_types->type!='')
                                    {{$vehicle_types->type}}
                                @else 
                                    NA
                                @endif
                            </div>
							
							<div class="form-group">
                            <label for="inputName">Make: </label>
                                @if($make->title!='')
                                    {{$make->title}}
                                @else 
                                    NA
                                @endif
                            </div>
            
                            <div class="form-group">
                            <label for="inputName">Model: </label>
                                @if($car_models->title!='')
                                    {{$car_models->title}}
                                @else 
                                    NA
                                @endif
                            </div>
							<div class="form-group">
                            <label for="inputName">Year: </label>
                                @if($detail->year !='')
                                    {{$detail->year }}
                                @else 
                                    NA
                                @endif
                            </div>
							
							<div class="form-group">
                                <label for="inputStatus">Registration Number: </label>
                                {{$detail->registration_number}}
                            </div>
							
							<div class="form-group">
                                <label for="inputStatus">Current Mileage: </label>
                                {{$detail->current_mileage}}
                            </div>
							
							<div class="form-group">
                                <label for="inputStatus">User Name: </label>
                                {{$user->first_name}} {{$user->last_name}}
                            </div>
							
							<div class="form-group">
                                <label for="inputStatus">User Type: </label>
                                {{$detail->user_type}}
                            </div>
							
							<div class="form-group">
                                <label for="inputStatus">Sold Notification: </label>
                                {{$detail->sold_notification}}
                            </div>
							
                            <div class="form-group">
                                <label for="inputStatus">Created at: </label>
                                {{ date('d-m-y', strtotime($detail->created_at) ) }}   
                            </div>
            
            
                            <div class="form-group">
                            <label for="inputStatus">Status: </label>
                                @if( $detail->status =='Active')
                                <small class="badge badge-success"> {{ $detail->status }}</small>
                                    
                                @else 
                                <small class="badge badge-danger"> {{ $detail->status}}</small>
                                @endif
                            </div>
                        </div>
                    </div>
				</div>
				
				<div class="col-md-6">
                    <div class="card card-primary">

                        <div class="card-header">
                            <h3 class="card-title">Car Data</h3>
            
                            <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="form-group">
                            <label for="inputName">Trim: </label>
                                @if($car_models->trim!='')
                                    {{$car_models->trim}}
                                @else 
                                    NA
                                @endif
                            </div>
							<div class="form-group">
                            <label for="inputName">Transmission: </label>
                                @if($trans->transmission!='')
                                    {{$trans->transmission}}
                                @else 
                                    NA
                                @endif
                            </div>
							<div class="form-group">
                            <label for="inputName">No. Of Doors: </label>
                                @if($cars_meta->no_of_doors!='')
                                    {{$cars_meta->no_of_doors}}
                                @else 
                                    NA
                                @endif
                            </div>
							<div class="form-group">
                            <label for="inputName">Seating Capacity: </label>
                                @if($cars_meta->seating_capacity!='')
                                    {{$cars_meta->seating_capacity}}
                                @else 
                                    NA
                                @endif
                            </div>
							<div class="form-group">
                            <label for="inputName">Body Type: </label>
                                @if($body_type->body_type!='')
                                    {{$body_type->body_type}}
                                @else 
                                    NA
                                @endif
                            </div>
							<div class="form-group">
                            <label for="inputName">Color: </label>
                                @if($cars_meta->color!='')
                                    {{$cars_meta->color}}
                                @else 
                                    NA
                                @endif
                            </div>
							<div class="form-group">
                            <label for="inputName">Fuel Type: </label>
                                @if($fuel_type)
                                    {{$fuel_type->type}}
                                @else 
                                    NA
                                @endif
                            </div>
							<div class="form-group">
                            <label for="inputName">Transmission Car type: </label>
                                @if($cars_meta->transmission_type!='')
                                    {{$cars_meta->transmission_type}}
                                @else 
                                    NA
                                @endif
                            </div>
							<div class="form-group">
                            <label for="inputName">Vehicle summery: </label>
                                @if($cars_meta->vehicle_summery!='')
                                    {{$cars_meta->vehicle_summery}}
                                @else 
                                    NA
                                @endif
                            </div>
							<div class="form-group">
                            <label for="inputName">Engine capacity: </label>
                                @if($cars_meta->engine_capacity!='')
                                    {{$cars_meta->engine_capacity}}
                                @else 
                                    NA
                                @endif
                            </div>
							<div class="form-group">
                            <label for="inputName">Price: </label>
                                @if($cars_meta->price!='')
                                    {{$cars_meta->price}}
                                @else 
                                    NA
                                @endif
                            </div>
							<div class="form-group">
                            <label for="inputName">Features: </label>
                                @if($cars_meta->features!='')
                                    {{$cars_meta->features}}
                                @else 
                                    NA
                                @endif
                            </div>
							<div class="form-group">
                            <label for="inputName">Number of Previous Owners: </label>
                                @if($cars_meta->previous_owners_number!='')
                                    {{$cars_meta->previous_owners_number}}
                                @else 
                                    NA
                                @endif
                            </div>
							<div class="form-group">
                            <label for="inputName">Total Number of Driven KMs: </label>
                                @if($cars_meta->driven_km!='')
                                    {{$cars_meta->driven_km}}
                                @else 
                                    NA
                                @endif
                            </div>
							<div class="form-group">
							  <label for="inputStatus">History:</label>
							  @if($cars_meta->history!='')
                                    {{$cars_meta->history}}
                                @else 
                                    NA
                                @endif
							</div>
							<div class="form-group">
							  <label for="inputStatus">Type of Insurance:</label>
							  @if($cars_meta->insurance!='')
                                    {{$cars_meta->insurance}}
                                @else 
                                    NA
                                @endif
							</div>
							<div class="form-group">
							  <label for="inputStatus">Manufacturer warranty:</label>
							  @if($cars_meta->mfwarranty!='')
                                    {{$cars_meta->mfwarranty}}
                                @else 
                                    NA
                                @endif
							</div>
							<div class="form-group">
								<label for="inputName">Manufacturer warranty expiry date:</label>
								@if($cars_meta->mfwarrantydate!='')
                                    {{$cars_meta->mfwarrantydate}}
                                @else 
                                    NA
                                @endif								
							</div>
							<div class="form-group">
								<label for="inputName">Drivetrain:</label>
								@if($cars_meta->drivetrain!='')
                                    {{$cars_meta->drivetrain}}
                                @else 
                                    NA
                                @endif
							</div>
							<div class="form-group">
								<label for="inputName">Fuel tank capacity (liters):</label>
								@if($cars_meta->ftc!='')
                                    {{$cars_meta->ftc}}
                                @else 
                                    NA
                                @endif
							</div>
							<div class="form-group">
								<label for="inputName">Mileage (kmpl):</label>
								@if($cars_meta->mileage!='')
                                    {{$cars_meta->mileage}}
                                @else 
                                    NA
                                @endif
							</div>
							<div class="form-group">
								<label for="inputName">Steering type:</label>
								@if($cars_meta->steering_type!='')
                                    {{$cars_meta->steering_type}}
                                @else 
                                    NA
                                @endif
							</div>
							<div class="form-group">
								<label for="inputName">Suspension front:</label>
								@if($cars_meta->suspension_front!='')
                                    {{$cars_meta->suspension_front}}
                                @else 
                                    NA
                                @endif
							</div>
							
							
							<div class="form-group">
                            <label for="inputName">Comment by Seller: </label>
                                @if($cars_meta->seller_comment!='')
                                    {{$cars_meta->seller_comment}}
                                @else 
                                    NA
                                @endif
                            </div>
							<div class="form-group">
                            <label for="inputName">Reason for Sell: </label>
                                @if($cars_meta->reason_sell!='')
                                    {{$cars_meta->reason_sell}}
                                @else 
                                    NA
                                @endif
                            </div>
							<div class="form-group">
                            <label for="inputName">Condition of the Car: </label>
                                @if($cars_meta->condition!='')
                                    {{$cars_meta->condition}}
                                @else 
                                    NA
                                @endif
                            </div>
							
                        </div>
                    </div>
				</div>
				
				<div class="col-md-6">
                    <div class="card card-primary">

                        <div class="card-header">
                            <h3 class="card-title">Images Information</h3>
            
                            <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                            </div>
                        </div>

                        <div class="card-body">
							<div class="form-group">
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
            

                            
                        </div>
                    </div>
                </div> 


			  
            </div>

      
        </section>
        <!-- /.content -->


@stop
