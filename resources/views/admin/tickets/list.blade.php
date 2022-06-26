@extends('layouts.masters')

@section('title', 'Enquiry Tickets')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Enquiry Tickets</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Enquiry Tickets</li>
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
        <div class="card-body p-0 m-2">
        <div class="table-responsive">
          <table class="table table-striped" id="users-table">
              <thead>
                  <tr>
                    <th>
                        Ticket Id
                    </th>

                    <th >
                        User
                    </th>

                    <th >
                        Query
                    </th>
					
					<th >
                        Ticket Status
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
        ajax: '{!! route('admin.ajaxTicketsList') !!}',
        columns: [    
            { data: 'ticket_id', name: 'ticket_id' },
            { data: 'userName', name: 'userName' },
            { data: 'query', name: 'query' },
			{ data: 'replied', name: 'replied' },
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

