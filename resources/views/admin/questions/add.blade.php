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

            <li class="breadcrumb-item"><a href="{{route('admin.faqindex')}}">FAQ List</a></li>
            <li class="breadcrumb-item active">FAQ</li>
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

            <form method="post" action="{{ route('admin.addquestion') }}" >
              @csrf
                <div class="form-group">
                    <label>Question</label>
                    <input type="text" class="form-control" name="question" placeholder="enter question.." required>
                  </div>
                  <div class="form-group">
                    <label>Answer</label>
                    <textarea type="text" class="form-control" name="answer" placeholder="enter answer.." required cols="5" rows="5"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="inputStatus">Status<span class="estricCls">*</span></label>
                    <select name="status" id="status" class="form-control custom-select">
                      <option value="Inactive">InActive</option>
                      <option value="Active">Active</option>
                    </select>
                  </div>
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

@stop

