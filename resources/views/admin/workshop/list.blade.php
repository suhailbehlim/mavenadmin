@extends('layouts.masters')

@section('title', 'workshop List')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">

          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">VLSI Workshop</li>
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
			<div class="col-sm-6" style="float: left;">
            <h5>LIFE AT MAVEN SILICON</h5>
          </div>
		  <div class="col-sm-6" style="float: right;">
			  <div class="card-tools" style="float: right;">
				<a href="{{route('admin.workshopage')}}" class="btn btn-info btn-sm float-sm-left ml-1"> Page Content</a>
				<a href="{{route('admin.addLifeBanner')}}" class="btn btn-info btn-sm float-sm-left ml-1"><i class="fa fa-plus" aria-hidden="true"></i>New Banner</a>
			  </div>
		  </div>
        </div>


        <div class="card-body p-0 m-2">

        <div class="table-responsive">
          <table class="table table-striped" id="category-table">
              <thead>
                  <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Banner</th>
					<th>Actions</th>
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
        ajax: '{!! route('admin.ajaxworkshopList') !!}',
        columns: [    
            { data: 'id', name: 'id' },
            { data: 'title', name: 'title' },
            { data: 'banner', name: 'banner',
				render: function( data, type, full, meta ) {
					return "<img src=\"{{url('')}}/public/system/global/" + data + "\" height=\"50\"/>";
				}
			},
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

