 @extends('layouts.masters')

@section('title', 'Add Used Car')

@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Used Car</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>

              <li class="breadcrumb-item"><a href="{{ route('admin.used_cars') }}">Cars</a></li>
              <li class="breadcrumb-item active">Add Used Car</li>
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
            <div class="card-body">

            	<form method="post" action="{{ route('admin.addCar') }}" enctype="multipart/form-data">
            		@csrf
					<div id="add">
						<div class="form-group">
						  <label for="inputStatus">Select Dealer<span class="estricCls">*</span></label>
						  <select name="dealername" id="dealername" class="form-control custom-select">
							@if($dealers)
							@foreach($dealers as $dealer)
								<option value="{{$dealer['id']}}">{{$dealer['first_name']}} {{$dealer['last_name']}}</option>
							@endforeach
							@endif
						  </select>
						</div>
				  </div>
				  <div class="form-group">
				   <input type="submit" name="Save" value="Next" class="btn btn-success">
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