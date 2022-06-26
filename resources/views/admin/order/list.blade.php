@extends('layouts.masters')

@section('title', 'Courses List')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Orders List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Orders List</li>
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
           
            

                <!-- <a href="{{ route('admin.addCourse') }}" class="btn btn-info btn-sm float-sm-left ml-1"><i class="fa fa-plus" aria-hidden="true"></i> Add New Course</a> -->

                {{-- <a href="{{ route('admin.exportModel', 'csv') }}" class="btn btn-success btn-sm float-sm-left ml-1"><i class="fa fa-download" aria-hidden="true"></i> Download CSV</a> --}}

          </div>
        </div>


        <div class="card-body p-0 m-2">

        <div class="table-responsive">
          <table class="table zero-configuration">
                                                <thead>
                                                <tr>
                                                    <th>Sr. no.</th>
                                                    <th>Transition ID</th>
                                                    <th>Course</th>
                                                    <th>Payment Status</th>
                                                    {{--<th>Package</th>--}}
                                                    <th>Payment</th>
                                                    <th>Created Date </th>

                                                    <!-- <th>Status</th> -->
                                                    <!-- <th>Action</th> -->
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($info as $key=>$item)

                                                    <tr>
                                                        <td>{{$key+1}}</td>
                                                        <td>{{ $item->paymentTransitionID }}</td>
                                                        <td>{{ $item->item }}</td>
                                                        <td>{{ $item->paymentTransitionStatus }}</td>
                                                        <td>{{ $item->payment }}</td>
                                                        {{--<td><a href="/admin/list/package">{{ $item->order[0]['package']['title'] }}</a></td>--}}
                                                        <td>{{ $item->created_at }}</td>
                                                        <!--  <td>
                                                             @if($item->paymentTransitionStatus != 'Failed')
                                                            <a href="/admin/view/{{$item->id}}/order"><i class="fa fa-eye text-green">View</i></a>
                                                                 @endif
                                                        </td> -->


                                                    </tr>
                                                @endforeach

                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <th>S. No.</th>
                                                    <th>Transition ID</th>
                                                      <th>Course</th>
                                                    <th>Contact</th>
                                                    <th>Payment</th>
                                                    <th>Transition ID </th>

                                                    <!-- <th>Status</th> -->
                                                    {{--<th>Action</th>--}}
                                                </tr>
                                                </tfoot>
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

