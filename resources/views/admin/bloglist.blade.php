@extends('layouts.masters')

@section('title', 'Blog List')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Blog List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Blog List</li>
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
           
            

                <a href="{{ route('admin.blog') }}" class="btn btn-info btn-sm float-sm-left ml-1"><i class="fa fa-plus" aria-hidden="true"></i> Add New blog</a>

                {{-- <a href="{{ route('admin.exportModel', 'csv') }}" class="btn btn-success btn-sm float-sm-left ml-1"><i class="fa fa-download" aria-hidden="true"></i> Download CSV</a> --}}

          </div>
        </div>


        <div class="card-body p-0 m-2">

        <div class="table-responsive">
          <table class="table table-striped" id="blogtable">
              <thead>
                  <tr>
                    <th>
                        Blog ID
                    </th>
					<th>
                        Blog Title
                    </th>

                    <th >
                        Blog Category
                    </th>
                    <th >
                      Blog Image
                  </th>
				  <th >
                      Blog Video
                  </th>                   
                       
                  <th >
                    Blog Content
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
    $('#blogtable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('admin.ajaxBloglist') !!}',
       
        columns: [ 
      { data: 'id', name: 'id' },
          
      { data: 'title', name: 'title' },
      { data: 'blogcategory', name: 'blogcategory' },
      { data: 'blogimage', name: 'blogimage' },
      { data: 'blogvideo', name: 'blogvideo' },
      { data: 'content', name: 'content' },
      


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

