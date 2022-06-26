@extends('layouts.masters')

@section('title', 'Banners')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Course Cataloge</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Course Cataloge</li>
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

                <a href="{{ route('admin.addcataloge') }}" class="btn btn-info btn-sm float-sm-left ml-1"><i class="fa fa-plus" aria-hidden="true"></i> Add New Cataloge</a>

               

          </div>
        </div>


        <div class="card-body p-0 m-2">

        <div class="table-responsive">
          <table class="table table-striped" id="model-table">
              <thead>
                  <tr>
                    <th>
                        Id
                    </th>

                    <th >
                       Title
                    </th>

                    <th >
                        Categories
                    </th>
					
					<th >
                        Image
                    </th>
					<th >
                        section
                    </th>
                   

                    <th >
                        Created at
                    </th>
                    <th >
                        Action
                    </th>                    
                       
                  </tr>
              </thead>
               <tbody>
                @foreach($data as $item)
                <tr>
                <td>{{$item->id}}</td>
                <td>{{$item->title}}</td>
                <td>{{$item->categories}}</td>
                <td><img src="{{ URL::to('/public') }}/{{ $item->image }}" width="100"></td>
                 <td>{{$item->section}}</td>
                 <td>{{$item->created_at}}</td>
                 <td>
                    <a href="{{route('admin.editcataloge', [$item->id])}}" id="{{$item->id}}" class="btn btn-info btn-sm" title="Edit cataloge"><i class="far fa-edit"></i></a>
        
           <a href="{{route('admin.deletecataloge', [$item->id])}}" id="{{$item->id}}" id="{{$item->id}}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure want to delete ?');" title="Delete cataloge" ><i class="fas fa-trash-alt"></i></a>
                 </td>
                @endforeach
              
                </tr>
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

@endpush

