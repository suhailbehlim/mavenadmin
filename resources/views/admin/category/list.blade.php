@extends('layouts.masters')

@section('title', 'Category List')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Category List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Category List</li>
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
           
            

            <a href="{{route('admin.addCategory')}}" class="btn btn-info btn-sm float-sm-left ml-1"><i class="fa fa-plus" aria-hidden="true"></i> Add New Category</a>

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
                        Slug
                    </th>
					
					<th >
                        Name
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
        ajax: '{!! route('admin.ajaxCategoryList') !!}',
        columns: [    

            { data: 'id', name: 'id' },
            { data: 'slug', name: 'slug' },
			{ data: 'name', name: 'name' },
  

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

