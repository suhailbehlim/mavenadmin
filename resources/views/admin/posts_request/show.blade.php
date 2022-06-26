@extends('layouts.masters')

@section('title', 'Post Request')

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
          &nbsp;
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.posts_request') }}">Request</a></li>
            <li class="breadcrumb-item active">Payment & Status</li>
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
                            <h3 class="card-title">Payment & Status</h3>
                            <div class="card-tools">
                            </div>
                        </div>

                        <div class="card-body">
            
                            <div class="form-group">
                            <label for="inputName">amount: </label>
                                @if($detail->amount!='')
                                    {{$detail->amount}}
                                @else 
                                    NA
                                @endif
                            </div>
            
                            <div class="form-group">
                            <label for="inputName">Currency: </label>
                                @if( $detail->currency !='')
                                    {{ $detail->currency }}
                                @else 
                                    NA
                                @endif
                            </div>
							<div class="form-group">
                            <label for="inputName">Payment ID: </label>
                                @if( $detail->payment_id !='')
                                    {{ $detail->payment_id }}
                                @else 
                                    NA
                                @endif
                            </div>

							<div class="form-group">
                            <label for="inputName">Payment Mode: </label>
                                @if( $detail->payment_mode !='')
                                    {{ $detail->payment_mode }}
                                @else 
                                    NA
                                @endif
                            </div>
							
							<div class="form-group">
                            <label for="inputName">Date From: </label>
                                @if( $detail->from_date !='')
                                    {{ $detail->from_date }}
                                @else 
                                    NA
                                @endif
                            </div>

							<div class="form-group">
                            <label for="inputName">Date To: </label>
                                @if( $detail->to_date !='')
                                    {{ $detail->to_date }}
                                @else 
                                    NA
                                @endif
                            </div>
            
                            <div class="form-group">
                                <label for="inputStatus">Submit Date: </label>
                                {{ date('d-m-y', strtotime($detail->submit_date) ) }}   
                            </div>
            
            
                            <div class="form-group">
                            <label for="inputStatus">Status: </label>

                                @if( $detail->status =='success')
                                <small class="badge badge-success"> {{ $detail->status }}</small>
                                    
                                @else 
                                <small class="badge badge-danger"> {{ $detail->status }}</small>
                                @endif


                            </div>
							<form method="post" action="{{ route('admin.updateStatus', $detail->id) }}" enctype="multipart/form-data">
								@csrf
								<div class="form-group">
									<label for="inputStatus">Status<span class="estricCls">*</span></label>
									<select name="status" id="status" class="form-control custom-select">
									  <option <?php if($detail->status == 'pending') {
										echo 'selected="selected"';
									  } ?>  value="pending">Pending</option>
									  <option <?php if($detail->status == 'success') {
										echo 'selected="selected"';
									  } ?> value="success">Success</option>
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


@stop
