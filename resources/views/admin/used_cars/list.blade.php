@extends('layouts.masters')

@section('title', 'Used Cars List')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Used Cars List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Used Cars List</li>
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


      <!-- Default box -->
      <div class="card">
        <div class="card-header">

          <div class="card-tools">
				<a href="{{ route('admin.addUsedCar') }}" class="btn btn-info btn-sm float-sm-left ml-1"><i class="fa fa-plus" aria-hidden="true"></i> Add car for dealer</a>
                <a href="{{ route('admin.exportExcel', 'csv') }}" class="btn btn-success btn-sm float-sm-left ml-1"><i class="fa fa-download" aria-hidden="true"></i> Download CSV</a> 

          </div>
        </div>


        <div class="card-body p-0 m-2">

        <div class="table-responsive">
          <table class="table table-striped" id="users-table">
              <thead>
                  <tr>
                    <th>
                        Id
                    </th>
					<th >
                        Vehicle Type
                    </th>
                    <th >
                        Make
                    </th>

                    <th >
                        Model
                    </th>
					<th>
                        Years
                    </th>
					
					<th>
                        Registration Number
                    </th>
					
					<th >
                        Current Mileage
                    </th>
					<th >
                        Sold Notify
                    </th>
                    <th >
                      Status
					</th>

                    <th >
                        Created at
                    </th>                   
                    <th >
                        Action
                    </th>                    
                       
                  </tr>
              </thead>
              
          </table>

          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
@stop

@push('scripts')
<script>
$(function() {
    $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('admin.ajaxUsedCarList') !!}',
        columns: [    
            { data: 'id', name: 'id' },
            { data: 'type', name: 'type' },
			{ data: 'title', name: 'title' },
            { data: 'modelName', name: 'modelName' },
			{ data: 'year', name: 'year' },
			{ data: 'registration_number', name: 'registration_number' },
			{ data: 'current_mileage', name: 'current_mileage' },
			{ data: 'sold_notification', name: 'sold_notification' },
            { data: 'status', name: 'status' },
            { data: 'created_at', name: 'created_at' },
            { 
                data: 'action', 
                name: 'action',
                orderable: false
            }  
        ]
    });
});

</script>
@endpush

