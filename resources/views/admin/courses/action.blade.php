@extends('layouts.masters')

@section('title', 'Courses')

@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{$active_link}}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>

              <li class="breadcrumb-item"><a href="{{ route('admin.courses') }}">Course List</a></li>
              <li class="breadcrumb-item"><a href="{{ route('admin.description',$courseID) }}">Course Description</a></li>
              <li class="breadcrumb-item active">{{$active_link}}</li>
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
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header" style="justify-content: space-between;display: flex;">
              <h3 class="card-title">Details</h3>
<a href="{{ route('admin.courses-description-action',['type'=>'features','id'=>$courseID]) }}"><button class="btn btn-success">Add Feature</button></a>
<a href="{{ route('admin.courses-description-action',['type'=>'Admission Process','id'=>$courseID]) }}"><button class="btn btn-default">Admission Process</button></a>
<a href="{{ route('admin.courses-description-action',['type'=>'Scholarship Scheme','id'=>$courseID]) }}"><button class="btn btn-danger">Scholarship Scheme</button></a>
<a href="{{ route('admin.courses-description-action',['type'=>'Batch Calendar','id'=>$courseID]) }}"><button class="btn btn-info">Batch Calendar</button></a>
<a href="{{ route('admin.courses-description-action',['type'=>'Winning Difference','id'=>$courseID]) }}"><button class="btn btn-secondary">Winning Difference</button></a>
<a href="{{ route('admin.courses-description-action',['type'=>'faq','id'=>$courseID]) }}"><button class="btn btn-danger">FAQ</button></a>
              
            </div>
            <div class="card-body">
    
            	<form method="post" action="{{ route('admin.courses-description-action-add',[$type,$courseID]) }}" enctype="multipart/form-data">
            		@csrf
                    <input type="hidden" name="id" @if(isset($actionData->id))value="{{$actionData->id}}" @endif>
                    @if($type == 'features')
				  <div class="form-group">
                <label for="title">Title<span class="estricCls">*</span></label>
                <input type="text" name="title"  id="title" class="form-control @error('title') is-invalid @enderror" value="@if(isset($actionData->title)) {{$actionData->title}}@else {{ old('title') }}@endif" autofocus>
                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>

              <div class="form-group">
                <label for="primeryList">Primery List <span class="estricCls">*</span></label>
                <textarea name="primeryList"  id="primeryList" class="ckeditor form-control @error('primeryList') is-invalid @enderror" autofocus>@if(isset($actionData->primeryList)) {{$actionData->primeryList}}@else {{ old('primeryList') }}@endif</textarea>
                @error('primeryList')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
              <div class="form-group">
                <label for="secondaryList">Secondary List <span class="estricCls">*</span></label>
                <textarea name="secondaryList"  id="secondaryList" class="ckeditor form-control @error('secondaryList') is-invalid @enderror" autofocus>@if(isset($actionData->secondaryList)) {{$actionData->secondaryList}}@else {{ old('secondaryList') }}@endif</textarea>
                @error('secondaryList')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
                <div class="form-group">
                <label for="Order">Order<span class="estricCls">*</span></label>
                <input type="number" name="Order"  id="Order" class="form-control @error('Order') is-invalid @enderror" value="@if(isset($actionData->Order)) {{$actionData->Order}}@else {{ old('Order') }}@endif" autofocus>
                @error('Order')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
           
              
           
@elseif($type == 'Admission Process')
<div class="form-group">
                <label for="title">Title<span class="estricCls">*</span></label>
                <input type="text" name="title"  id="title" class="form-control @error('title') is-invalid @enderror" value="@if(isset($actionData->title)) {{$actionData->title}}@else {{ old('title') }}@endif" autofocus>
                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>

              <div class="form-group">
                <label for="description">Description <span class="estricCls">*</span></label>
                <textarea name="description"  id="description" class="ckeditor form-control @error('description') is-invalid @enderror" autofocus>@if(isset($actionData->description)) {{$actionData->description}}@else {{ old('description') }}@endif</textarea>
                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
             
                <div class="form-group">
                <label for="Order">Order<span class="estricCls">*</span></label>
                <input type="number" name="Order"  id="Order" class="form-control @error('Order') is-invalid @enderror" value="@if(isset($actionData->Order)) {{$actionData->Order}}@else {{ old('Order') }}@endif" autofocus>
                @error('Order')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
              <div class="form-group">
                <label for="image">Image <span class="estricCls">*</span></label>
                <input type="file"  name="image">
                @error('image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>

@elseif($type == 'Scholarship Scheme')
 <div class="form-group">
                <label for="title">Title<span class="estricCls">*</span></label>
                <input type="text" name="title"  id="title" class="form-control @error('title') is-invalid @enderror" value="@if(isset($actionData->title)) {{$actionData->title}}@else {{ old('title') }}@endif" autofocus>
                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>

              <div class="form-group">
                <label for="academic_criteria">Academic Criteria <span class="estricCls">*</span></label>
                 <input type="text" name="academic_criteria"  id="academic_criteria" class="form-control @error('admission_process_type') is-invalid @enderror" value="@if(isset($actionData->academic_criteria)) {{$actionData->academic_criteria}}@else {{ old('academic_criteria') }}@endif" autofocus>
                @error('academic_criteria')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
              <div class="form-group">
                <label for="test_score">Test Score <span class="estricCls">*</span></label>
                <input type="text" name="test_score"  id="test_score" class="form-control @error('test_score') is-invalid @enderror" value="@if(isset($actionData->test_score)) {{$actionData->test_score}}@else {{ old('test_score') }}@endif" autofocus>
                @error('test_score')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
              <div class="form-group">
                <label for="scholarship">Scholarship <span class="estricCls">*</span></label>
                <input type="text" name="scholarship"  id="scholarship" class="form-control @error('scholarship') is-invalid @enderror" value="@if(isset($actionData->scholarship)) {{$actionData->scholarship}}@else {{ old('scholarship') }}@endif" autofocus>
                @error('scholarship')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
                <div class="form-group">
                <label for="Order">Order<span class="estricCls">*</span></label>
                <input type="number" name="Order"  id="Order" class="form-control @error('Order') is-invalid @enderror" value="@if(isset($actionData->Order)) {{$actionData->Order}}@else {{ old('Order') }}@endif" autofocus>
                @error('Order')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>

@elseif($type == 'Batch Calendar')
<div class="form-group">
                <label for="mode">Mode<span class="estricCls">*</span></label>
                <input type="text" name="mode"  id="mode" class="form-control @error('mode') is-invalid @enderror" value="@if(isset($actionData->mode)) {{$actionData->mode}}@else {{ old('mode') }}@endif" autofocus>
                @error('mode')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>

              <div class="form-group">
                <label for="Date">Date <span class="estricCls">*</span></label>
                 <input type="date" name="Date"  id="Date" class="form-control @error('Date') is-invalid @enderror" value="@if(isset($actionData->Date))<?php echo date('Y-m-d',strtotime($actionData->Date)) ?>@else {{ old('Date') }}@endif" autofocus>
                @error('Date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
              <div class="form-group">
                <label for="Duration">Duration <span class="estricCls">*</span></label>
                <input type="text" name="Duration"  id="Duration" class="form-control @error('Duration') is-invalid @enderror" value="@if(isset($actionData->Duration)) {{$actionData->Duration}}@else {{ old('Duration') }}@endif" autofocus>
                @error('Duration')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
            
                <div class="form-group">
                <label for="Order">Order<span class="estricCls">*</span></label>
                <input type="number" name="Order"  id="Order" class="form-control @error('Order') is-invalid @enderror" value="@if(isset($actionData->Order)){{$actionData->Order}}@else {{ old('Order') }}@endif" autofocus>
                @error('Order')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
              @elseif($type == 'Winning Difference')
 <div class="form-group">
                <label for="title">Title<span class="estricCls">*</span></label>
                <input type="text" name="title"  id="title" class="form-control @error('title') is-invalid @enderror" value="@if(isset($actionData->title)) {{$actionData->title}}@else {{ old('title') }}@endif" autofocus>
                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>

             
               <div class="form-group">
                <label for="image">Icon <span class="estricCls">*</span></label>
                <input type="file"  name="icon">
                @error('icon')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
            
                <div class="form-group">
                <label for="Order">Order<span class="estricCls">*</span></label>
                <input type="number" name="Order"  id="Order" class="form-control @error('Order') is-invalid @enderror" value="@if(isset($actionData->Order)){{$actionData->Order}}@else {{ old('Order') }}@endif" autofocus>
                @error('Order')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
                @elseif($type == 'faq')
                <div class="form-group">
                <label for="question">Question<span class="estricCls">*</span></label>
                <input type="text" name="question"  id="question" class="form-control @error('question') is-invalid @enderror" value="@if(isset($actionData->question)) {{$actionData->question}}@else {{ old('question') }}@endif" autofocus>
                @error('question')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
            
              <div class="form-group">
                <label for="answer">Answer<span class="estricCls">*</span></label>
                <input type="text" name="answer"  id="answer" class="form-control @error('answer') is-invalid @enderror" value="@if(isset($actionData->answer)) {{$actionData->answer}}@else {{ old('answer') }}@endif" autofocus>
                @error('answer')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
            
                <div class="form-group">
                <label for="Order">Order<span class="estricCls">*</span></label>
                <input type="number" name="Order"  id="Order" class="form-control @error('Order') is-invalid @enderror" value="@if(isset($actionData->Order)){{$actionData->Order}}@else {{ old('Order') }}@endif" autofocus>
                @error('Order')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
@endif

              <div class="form-group">
               <input type="submit" name="Save" class="btn btn-success">
              </div>

			</form>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
       
      </div>


    </section>
    <!-- /.content -->

     <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">

        
        </div>


        <div class="card-body p-0 m-2">

        <div class="table-responsive">
            @if($type == 'features')
          <table class="table table-striped" id="">
              <thead>
                  <tr>
                    <th>
                        Id
                    </th>

                    <th >
                      Title
                    </th>

                    <th >
                        Primery List
                    </th>
                    
                    <th >
                        Secondary List
                    </th>
                   
                    <th >
                        Delete
                    </th>
                     <th >
                        Edit
                    </th>
                   

                                     
                       
                  </tr>
              </thead>
              <tbody>
                @foreach($tableData as $item)

                  <tr>
                      <td>{{$item->id}}</td>
                      <td>{{$item->title}}</td>
                      <td>{{$item->primeryList}}</td>
                      <td>{{$item->secondaryList}}</td>
                      <td><a href="{{ route('admin.courses-description-delete',['type'=>$type,'id'=>$item->id]) }}" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i></a></td>
                      <td><a href="{{ route('admin.courses-description-action',['type'=>$type,'id'=>$courseID,'actionId'=>$item->id]) }}" ><i class="fa fa-edit"></i></a></td>
                  </tr>
                  @endforeach
              </tbody>
              
          </table>
@elseif($type == 'Admission Process')
<table class="table table-striped" id="">
              <thead>
                  <tr>
                    <th>
                        Id
                    </th>

                    <th >
                      Image
                    </th>

                    <th >
                        Title
                    </th>
                    
                    <th >
                       Description
                    </th>
                   
                    <th >
                        Delete
                    </th>
                   

                                     
                       
                  </tr>
              </thead>
              <tbody>
                @foreach($tableData as $item)

                  <tr>
                      <td>{{$item->id}}</td>
                      <td>@if(isset($item->image))
                 <img src="{{ URL::to('/public') }}/system/courses/admission_process/<?php echo $item->image; ?>" width="40" height="40">
                 @endif</td>
                      <td>{{$item->title}}</td>
                      <td>{!!$item->description!!}</td>
                      <td><a href="{{ route('admin.courses-description-delete',['type'=>$type,'id'=>$item->id]) }}" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i></a></td>
                  </tr>
                  @endforeach
              </tbody>
              
          </table>
@elseif($type == 'Scholarship Scheme')
 <table class="table table-striped" id="">
              <thead>
                  <tr>
                    <th>
                        Id
                    </th>

                    <th >
                      Title
                    </th>

                    <th >
                        Academic Criteria
                    </th>
                    
                    <th >
                        Test Score
                    </th>
                    <th >
                        Scholarship
                    </th>
                   
                    <th >
                        Delete
                    </th>
                   

                                     
                       
                  </tr>
              </thead>
              <tbody>
                @foreach($tableData as $item)

                  <tr>
                      <td>{{$item->id}}</td>
                      <td>{{$item->title}}</td>
                      <td>{{$item->academic_criteria}}</td>
                      <td>{{$item->test_score}}</td>
                      <td>{{$item->scholarship}}</td>
                      <td><a href="{{ route('admin.courses-description-delete',['type'=>$type,'id'=>$item->id]) }}" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i></a></td>
                  </tr>
                  @endforeach
              </tbody>
              
          </table>
@elseif($type == 'Batch Calendar')
<table class="table table-striped" id="">
              <thead>
                  <tr>
                    <th>
                        Id
                    </th>

                    <th >
                      Mode
                    </th>

                    <th >
                        Date
                    </th>
                    
                    <th >
                      Duration
                    </th>
                   
                   
                    <th >
                        Delete
                    </th>
                    <th >
                        Edit
                    </th>
                   

                                     
                       
                  </tr>
              </thead>
              <tbody>
                @foreach($tableData as $item)

                  <tr>
                      <td>{{$item->id}}</td>
                      <td>{{$item->mode}}</td>
                      <td>{{$item->Date}}</td>
                      <td>{{$item->Duration}}</td>
                    
                      <td><a href="{{ route('admin.courses-description-delete',['type'=>$type,'id'=>$item->id]) }}" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i></a></td>
                         <td><a href="{{ route('admin.courses-description-action',['type'=>$type,'id'=>$item->id,'actionId'=>$item->id]) }}" ><i class="fa fa-edit"></i></a></td>
                  </tr>
                  @endforeach
              </tbody>
              
          </table>
          @elseif($type == 'Winning Difference')
<table class="table table-striped" id="">
              <thead>
                  <tr>
                    <th>
                        Id
                    </th>

                    <th >
                      Title
                    </th>

                    <th >
                        Icon
                    </th>
                    
                   
                   
                    <th >
                        Delete
                    </th>
                    <th >
                        Edit
                    </th>
                   

                                     
                       
                  </tr>
              </thead>
              <tbody>
                @foreach($tableData as $item)

                  <tr>
                      <td>{{$item->id}}</td>
                      <td>{{$item->title}}</td>
                    <td>
                         <img src="{{ URL::to('/public') }}/system/courses/Winning_Difference/<?php echo $item->icon; ?>" width="40" height="40">
                    </td>
                    
                      <td><a href="{{ route('admin.courses-description-delete',['type'=>$type,'id'=>$item->id]) }}" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i></a></td>
                         <td><a href="{{ route('admin.courses-description-action',['type'=>$type,'id'=>$item->id,'actionId'=>$item->id]) }}" ><i class="fa fa-edit"></i></a></td>
                  </tr>
                  @endforeach
              </tbody>
              
          </table>
          @elseif($type == 'faq')
          <table class="table table-striped" id="">
              <thead>
                  <tr>
                    <th>
                        Id
                    </th>

                    <th >
                      Question
                    </th>

                    <th >
                        Answer
                    </th>
                    
                   
                   
                    <th >
                        Delete
                    </th>
                    <th >
                        Edit
                    </th>
                   

                                     
                       
                  </tr>
              </thead>
              <tbody>
                @foreach($tableData as $item)

                  <tr>
                      <td>{{$item->id}}</td>
                      <td>{{$item->question}}</td>
                      <td>{{$item->answer}}</td>
                   
                    
                      <td><a href="{{ route('admin.courses-description-delete',['type'=>$type,'id'=>$item->id]) }}" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i></a></td>
                         <td><a href="{{ route('admin.courses-description-action',['type'=>$type,'id'=>$item->id,'actionId'=>$item->id]) }}" ><i class="fa fa-edit"></i></a></td>
                  </tr>
                  @endforeach
              </tbody>
              
          </table>
@endif
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->

<style>
    .row{
        margin-top: 20px;
    }
</style>
@stop