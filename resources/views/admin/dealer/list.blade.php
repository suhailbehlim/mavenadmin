@extends('layouts.masters')

@section('title', 'Educator List')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Educator List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Educator List</li>
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
           
              
           

                <a href="{{ route('admin.addDealer') }}" class="btn btn-info btn-sm float-sm-left ml-1"><i class="fa fa-plus" aria-hidden="true"></i> Add New Educator</a>

                {{-- <a href="{{ route('admin.exportExcel', 'xls') }}" class="btn btn-success btn-sm float-sm-left ml-1"><i class="fa fa-download" aria-hidden="true"></i> Download xls</a>
                <a href="{{ route('admin.exportExcel', 'xlsx') }}" class="btn btn-success btn-sm float-sm-left ml-1"><i class="fa fa-download" aria-hidden="true"></i> Download xlsx</a> --}}

                <a href="{{ route('admin.dealerExportExcel', 'csv') }}" class="btn btn-success btn-sm float-sm-left ml-1"><i class="fa fa-download" aria-hidden="true"></i> Download CSV</a>

          </div>
        </div>


        <div class="card-body p-0 m-2">

        <div class="table-responsive">

            <div class="card">
              <div class="card-body">
                <div class="row">
                    <div class="col-md-2">

                      <div class="form-group">
                        <label><strong>Search by Status :</strong></label>
                      </div>                      

                    </div>

                    <div class="col-md-3">
                      <div class="form-group">
                        <select id='status' class="form-control" style="width: 200px">
                          <option value="">--Select Status--</option>
                          <option value="Active">Active</option>
                          <option value="Inactive">Inactive</option>
                        </select>
                      </div>                      
                    </div>  

                </div>  

              </div>
          </div>

          <table class="table table-striped" id="users-table">
              <thead>
                  <tr>
                    <th>
                        Id
                    </th>

                    <th >
                        Username
                    </th>
					
					<th >
                        Name
                    </th>

                    <th >
                        Email
                    </th>
					<th >
                        Phone
                    </th>

                    <th >
                      Age
                  </th>
				  
				  <th >
                      Education History
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
    var table = $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {

          url: '{!! route('admin.datatables.ajaxDealerList') !!}',

          data: function (d) {
                d.status = $('#status').val(),
                d.search = $('input[type="search"]').val()
            }
        },
      
        columns: [    

            { data: 'id', name: 'id' },
            { data: 'username', name: 'username' },
            { data: 'name', name: 'name' },
			{ data: 'email', name: 'email' },
			{ data: 'phone', name: 'phone' },
			{ data: 'age', name: 'age' },
			{ data: 'education_history', name: 'education_history' },
            { data: 'created_at', name: 'created_at' },


            { 
                data: 'action', 
                name: 'action',
                orderable: false
            }  
        ]
    });

    $('#status').change(function(){
        table.draw();
    });

});

</script>
@endpush

