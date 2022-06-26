@extends('layouts.masters')

@section('title', 'Banners')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Banners</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Banners</li>
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

                <a href="{{ route('admin.banner') }}" class="btn btn-info btn-sm float-sm-left ml-1"><i class="fa fa-plus" aria-hidden="true"></i> Add New Banners</a>

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
                       Name
                    </th>

                    <th >
                        Alt
                    </th>
					
					<th >
                        Desktop Banner
                    </th>
					<th >
                        Mobile Banner
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
        ajax: '{!! route('admin.ajaxBannerList') !!}',
        columns: [    
            { data: 'id', name: 'id' },
            { data: 'title', name: 'title' },
            { data: 'alt', name: 'alt' },
			{ data: 'desktop_banner', name: 'desktop_banner',
				render: function( data, type, full, meta ) {
					return "<img src=\"{{url('')}}/public/uploads/banners/" + data + "\" height=\"50\"/>";
				}
			},
			{ data: 'mobile_banner', name: 'mobile_banner',
				render: function( data, type, full, meta ) {
					return "<img src=\"{{url('')}}/public/uploads/banners/" + data + "\" height=\"50\"/>";
				}
			},
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

