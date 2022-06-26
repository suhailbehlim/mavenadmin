@extends('layouts.masters')

@section('title', 'Dealer Profile')

@section('content')


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

<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Dealer Profile</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>

            <li class="breadcrumb-item"><a href="{{ route('admin.dealers') }}">Dealer List</a></li>
            <li class="breadcrumb-item active">Dealer Profile</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>


        <!-- Main content -->
        <section class="content">
            <div class="row">

              <div class="col-md-6">
                    <div class="card card-primary">

                        <div class="card-header">
                            <h3 class="card-title">Basic Information</h3>
            
                            <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                            </div>
                        </div>

                        <div class="card-body">
            
                            <div class="form-group">
                            <label for="inputName">Full Name: </label>

                                @if( $dealerBasicInfo['name'] !='')
                                    {{ $dealerBasicInfo['name'] }}
                                @else 
                                    NA
                                @endif


                            </div>
            
                            <div class="form-group">
                            <label for="inputName">Email Address: </label>

                                @if( $dealerBasicInfo['email'] !='')
                                    {{ $dealerBasicInfo['email'] }}
                                @else 
                                    NA
                                @endif

                            </div>
            
                            <div class="form-group">
                                <label for="inputStatus">Created at: </label>
                                {{ date('d-m-y', strtotime($dealerBasicInfo['created_at']) ) }}   
                            </div>
            
            
                            <div class="form-group">
                            <label for="inputStatus">Status: </label>

                                @if( $dealerBasicInfo['status'] =='Active')
                                <small class="badge badge-success"> {{ $dealerBasicInfo['status'] }}</small>
                                    
                                @else 
                                <small class="badge badge-danger"> {{ $dealerBasicInfo['status'] }}</small>
                                @endif


                            </div>
                
                        
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
              </div>



                <div class="col-md-6">
                    <div class="card card-primary">

                        <div class="card-header">
                            <h3 class="card-title">Other Information</h3>
            
                            <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                            </div>
                        </div>

                        <div class="card-body">
            
                            <div class="form-group">
                                <label for="inputName" >Company Name: </label>
                                    
                                @if( $dealerOtherInfo['company_name'] !='')
                                    {{ $dealerOtherInfo['company_name'] }}
                                @else 
                                    NA
                                @endif 
                            </div>
            

                            <div class="form-group">
                                <label for="inputName" >Company Document: </label><br>
                                    
                                @if( $dealerOtherInfo['company_doc'] !='')
                                    <img src="{{ URL::to('/') }}/uploads/dealer_documents/thumbnail/{{ $dealerOtherInfo['company_doc'] }}" width="100"> 
                                @else 
                                    <img src="{{ URL::to('/') }}/uploads/no_user.png" width="100"> 
                                @endif                              
                            </div>

                            <div class="form-group">
                                <label for="inputName" >Approved Status: </label>
                                    
                                @if( $dealerOtherInfo['is_approved'] == '0')
                                  <small class="badge badge-danger"><i class="fa fa-ban" aria-hidden="true"></i>
                                    Pending</small>
                                @else 
                                
                                <small class="badge badge-success"><i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                    Approved</small>
                                @endif 
                            </div>

                        
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>             
            </div>

            

            <div class="row">


                <div class="col-md-12">
                    <div class="card card-primary">
                        
                        @if( $dealerOtherInfo['is_approved'] =='0')
                            <a href="{{ route('admin.approveDealer', $dealerBasicInfo['id']) }} " class="btn btn-success btn-sm">Activate Dealer Profile</a>
                        @endif
                        
                        @if( $dealerOtherInfo['is_approved'] =='1' )  
                            <a href="{{ route('admin.approveDealer', $dealerBasicInfo['id']) }} " class="btn btn-danger btn-sm">Deactivate Dealer Profile</a> 
                            
                        @endif
                    
                    </div>
                </div>
            </div>

      
        </section>
        <!-- /.content -->


@stop
