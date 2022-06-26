@extends('layouts.masters')

@section('title', 'Enquiry List')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Enquiry List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Enquiry List</li>
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
           
            

            <a href="" class="btn btn-info btn-sm float-sm-left ml-1"><i class="fa fa-plus" aria-hidden="true"></i> Add Enquiry</a>

                {{-- <a href="{{ route('admin.exportCategory', 'csv') }}" class="btn btn-success btn-sm float-sm-left ml-1"><i class="fa fa-download" aria-hidden="true"></i> Download CSV</a> --}}

          </div>
        </div>


        <div class="card-body p-0 m-2">

        <div class="table-responsive">
          <table class="table table-striped" id="category-table">
              <thead>
                  <tr>
                    <th>
                        Id
                    </th>

                    <th >
                        Name
                    </th>
					
					<th >
						Email
                    </th>
                    <th >
                      Phone Number 
                   </th>
                    <th >
                      Country
                  </th>
				  <th >
                       State 
                    </th>
                   
                    <th >Message</th>   
					<th >Channel</th>
					<th >Lead Source</th>
					<th >Remarks</th>
					<th >Sub Source</th>
					<th >Page</th>
                    <th >
                       Captcha
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
    $('#category-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('admin.ajaxenquiryList') !!}',
        columns: [    

            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
			{ data: 'email', name: 'email' },
      { data: 'phonenum', name: 'phonenum' },

      { data: 'country', name: 'country' },
	        { data: 'state', name: 'state' },

			{ data: 'message', name: 'message' },
			{ data: 'mx_channel', name: 'mx_channel' },
			{ data: 'source', name: 'source' },
			{ data: 'mx_remarks', name: 'mx_remarks' },
			{ data: 'mx_sub_source', name: 'mx_sub_source' },
			{ data: 'page', name: 'page' },

  

            { data: 'captcha', name: 'captcha' },
            
        ]
    });
});

</script>
@endpush 

