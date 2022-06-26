@extends('layouts.masters')


@section('content')


<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>FAQ</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>

            <li class="breadcrumb-item"><a href="{{route('admin.faqindex')}}">FAQ List </a></li>
            <li class="breadcrumb-item active">FAQ Edit</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>


      <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Details</h3>

          </div>
          <div class="card-body">

            <form method="post" action="{{ route('admin.updatefaq',$faqInfo->id) }}" >
              @csrf
                <div class="form-group">
                    <label>Question</label>
                    <input type="text" class="form-control" name="question" placeholder="enter question.." id="question"  value="{{$faqInfo->question}}" required>
                  </div>
                  <div class="form-group">
                    <label >Answer</label>
                    <textarea type="text" class="form-control" id="answer" name="answer" placeholder="Enter Answer..." cols="30" rows="10" value="{{$faqInfo->answer}}"></textarea>
                  </div>
                <div class="form-group">
                  <label for="inputStatus">Status<span class="estricCls">*</span></label>
                  <select name="status" id="status" class="form-control custom-select">
                    <option <?php if($faqInfo->status == 'Inactive') {
                      echo 'selected="selected"';
                    } ?>  value="Inactive">Inactive</option>
                    <option <?php if($faqInfo->status == 'Active') {
                      echo 'selected="selected"';
                    } ?> value="Active">Active</option>
                  </select>
                </div>
                <div class="form-group">
          <input type="hidden" name="id" value="{{$faqInfo->id}}" id="id">
                 <input type="submit" name="Update" class="btn btn-success">
                
            
              </form>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
     
    </div>

@stop

