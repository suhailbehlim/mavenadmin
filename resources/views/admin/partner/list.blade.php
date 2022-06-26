@extends('layouts.masters')

@section('title', 'Partners List')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>CMS Page Section List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Partners List</li>
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
           
            

            <a href="{{route('admin.add-partner')}}" class="btn btn-info btn-sm float-sm-left ml-1"><i class="fa fa-plus" aria-hidden="true"></i> Add New Partners</a>
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
                        Section
                    </th>
					
					<th >
                       title 
                    </th>
                    <th >
                      Description 
                   </th>
                    <th >
                      image
                  </th>
				 
                    <th >
                        Action
                    </th>                  
                       
                  </tr>
              </thead>
              <tbody>
                @foreach(DB::table('partner_section')->get() as $item)
                  <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->sectionTitle}}</td>
                    <td>{{$item->title}}</td>
                    <td>{{$item->description}}</td>
                    <td><img src="{{asset('public/'.$item->image)}}" width="40" height="40"></td>
                    <td>
                        <a href="{{route('admin.edit-partner',$item->id)}}" id="{{$item->id}}" class="btn btn-info btn-sm" title="Edit Category"><i class="far fa-edit"></i></a>
                        <a href="{{route('admin.delete-partner',$item->id)}}" id="{{$item->id}}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure want to delete ?');" title="Delete Category"><i class="fas fa-trash-alt"></i></a>
                    </td>
                </tr>
                @endforeach
              </tbody>
              
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


</script>
@endpush 

