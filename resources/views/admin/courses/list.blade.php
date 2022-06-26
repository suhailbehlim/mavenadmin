@extends('layouts.masters')

@section('title', 'Courses List')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Courses List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Courses List</li>
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
           
            

                <a href="{{ route('admin.addCourse') }}" class="btn btn-info btn-sm float-sm-left ml-1"><i class="fa fa-plus" aria-hidden="true"></i> Add New Course</a>

                {{-- <a href="{{ route('admin.exportModel', 'csv') }}" class="btn btn-success btn-sm float-sm-left ml-1"><i class="fa fa-download" aria-hidden="true"></i> Download CSV</a> --}}

          </div>
        </div>


        <div class="card-body p-0 m-2">

        <div class="table-responsive">
          <table class="table table-striped" id="model-table">
              <thead>
                  <tr>
                    <th>
                     Course ID
                  </th>
                   
					<th>
                        Course Type
                    </th>
                    <th >
                      Category
                  </th>
                  <!--   <th >
                        Languages
                    </th> -->
                    <th >
                      Title
                  </th>
				  <th >
                      Price
                  </th>
				  
				 <!--  <th >
                      Image
                  </th>
                   
				  <th >
            video
        </th> -->
        <th >
          Batch Date&Time
      </th> 
        <th >
          Offer
      </th> 
      <th >
        Timing
    </th>  
    <th >
      Duration
  </th>  
  <th >
    Next batch
</th>   
      <th >
        Updated date
    </th>  
                    <th >
                        description
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
    $('#model-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('admin.datatables.ajaxCoursesList') !!}',
        columns: [    
          { data: 'id', name: 'id' },

            { data: 'course_type', name: 'course_type' },
            { data: 'category', name: 'category' },

			// { data: 'languages', name: 'languages' },
			{ data: 'title', name: 'title' },
			{ data: 'price', name: 'price' },
			// { data: 'thumbnail', name: 'thumbnail' },
			// { data: 'shorts', name: 'shorts' },
      { data: 'batch', name: 'batch' },
      { data: 'offer', name: 'offer' },
      { data: 'timing', name: 'timing' },
      { data: 'duration', name: 'duration' },
      { data: 'nextbatch', name: 'nextbatch' },

      { data: 'updated_at', name: 'updated_at' },



            { 
                data: 'description', 
                name: 'description',
                orderable: false
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

