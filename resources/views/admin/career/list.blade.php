@extends('layouts.masters')

@section('title', 'Career List')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Career List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Career List</li>
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
           
            

            <a href="{{route('admin.addCareer')}}" class="btn btn-info btn-sm float-sm-left ml-1"><i class="fa fa-plus" aria-hidden="true"></i> Add New Career</a>

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
                        JobTitle
                    </th>
                    <th >
                      Opening
                  </th>
					<th >
                       JobLevel
                    </th>
                    <th >
                      JobType
                  </th>
                  <th >
                    Location
                </th>
                    <th >
                Description
                    </th>   
                    <th >
                       Status 
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
    $('#category-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('admin.ajaxCareerList') !!}',
        columns: [    

            { data: 'id', name: 'id' },
            { data: 'title', name: 'title' },
            { data: 'opening', name: 'opening' },

			{ data: 'job', name: 'job' },
      { data: 'jobtype', name: 'jobtype' },
      { data: 'location', name: 'location' },

			{ data: 'description', name: 'description' },

  

            { data: 'status', name: 'status' },
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

